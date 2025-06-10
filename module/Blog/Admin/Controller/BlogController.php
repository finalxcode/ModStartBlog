<?php


namespace Module\Blog\Admin\Controller;


use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use ModStart\Admin\Concern\HasAdminQuickCRUD;
use ModStart\Admin\Layout\AdminCRUDBuilder;
use ModStart\Core\Dao\ModelUtil;
use ModStart\Core\Exception\BizException;
use ModStart\Core\Input\InputPackage;
use ModStart\Core\Input\Response;
use ModStart\Core\Util\CRUDUtil;
use ModStart\Field\AbstractField;
use ModStart\Field\Tags;
use ModStart\Field\Type\FieldRenderMode;
use ModStart\Form\Form;
use ModStart\Grid\GridFilter;
use ModStart\Repository\RepositoryUtil;
use ModStart\Support\Concern\HasFields;
use ModStart\Widget\ButtonDialogRequest;
use ModStart\Widget\TextLink;
use Module\Blog\Core\BlogSiteUrlBiz;
use Module\Blog\Core\BlogSuperSearchBiz;
use Module\Blog\Model\Blog;
use Module\Blog\Type\BlogVisitMode;
use Module\Blog\Util\BlogCategoryUtil;
use Module\Blog\Util\BlogTagUtil;
use Module\Blog\Util\UrlUtil;
use Module\Vendor\Provider\SiteUrl\SiteUrlProvider;
use Module\Vendor\QuickRun\Export\ImportHandle;

class BlogController extends Controller
{
    use HasAdminQuickCRUD;

    protected function crud(AdminCRUDBuilder $builder)
    {
        $updatedCategoryIds = [];
        $categoryTags = [];
        $categories = ModelUtil::all('blog_category');
        foreach ($categories as $cat) {
            if (!empty($cat['default_tags'])) {
                $tagsString = $cat['default_tags'];
                
                // 处理可能的JSON编码问题
                if (strpos($tagsString, '["') === 0 || strpos($tagsString, "[\"") === 0) {
                    // 尝试解码JSON
                    $decoded = json_decode($tagsString, true);
                    if (is_array($decoded)) {
                        $categoryTags[$cat['id']] = array_filter(array_map('trim', $decoded));
                    } else {
                        // 如果JSON解码失败，按逗号分割
                        $categoryTags[$cat['id']] = array_filter(array_map('trim', explode(',', $tagsString)));
                    }
                } else {
                    // 正常按逗号分割
                    $categoryTags[$cat['id']] = array_filter(array_map('trim', explode(',', $tagsString)));
                }
            }
        }

        // 调试：输出分类标签数据
        Log::info('页面加载时的分类标签数据', ['categoryTags' => $categoryTags]);
        
        \ModStart\ModStart::script('window.categoryTags = ' . json_encode($categoryTags) . ';');
        
        // 添加级联分类选择的JavaScript
        \ModStart\ModStart::script('
            $(document).ready(function() {
                // 使用更准确的选择器
                var $parentSelect = $("select[name=\"parentCategoryId\"], input[name=\"parentCategoryId\"]");
                var $childSelect = $("select[name=\"categoryId\"], input[name=\"categoryId\"]");
                
                console.log("级联分类初始化:", {
                    parentSelect: $parentSelect.length,
                    childSelect: $childSelect.length,
                    parentValue: $parentSelect.val(),
                    childValue: $childSelect.val()
                });
                
                var currentCategoryId = $childSelect.val();
                
                // 页面加载时，如果已选择二级分类，则加载对应的选项和标签
                if ($parentSelect.val()) {
                    loadSubcategories($parentSelect.val(), currentCategoryId);
                }
                
                // 页面加载时，如果已选择二级分类，则更新标签选项
                if (currentCategoryId) {
                    updateTagOptions(currentCategoryId);
                }
                
                function loadSubcategories(parentId, selectedId) {
                    console.log("加载二级分类:", parentId, selectedId);
                    
                    if (parentId) {
                        $childSelect.html("<option value=\"\">加载中...</option>");
                        
                        $.ajax({
                            url: "/admin/blog/subcategories/" + parentId,
                            type: "GET",
                            dataType: "json",
                            success: function(data) {
                                console.log("AJAX响应:", data);
                                
                                if (data.code === 0 && data.data) {
                                    $childSelect.html("<option value=\"\">请选择二级分类</option>");
                                    $.each(data.data, function(index, item) {
                                        var selected = (selectedId && selectedId == item.id) ? " selected" : "";
                                        $childSelect.append("<option value=\"" + item.id + "\"" + selected + ">" + item.title + "</option>");
                                    });
                                } else {
                                    $childSelect.html("<option value=\"\">加载失败</option>");
                                    console.error("数据格式错误:", data);
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error("AJAX请求失败:", status, error);
                                $childSelect.html("<option value=\"\">加载失败，请重试</option>");
                            }
                        });
                    } else {
                        $childSelect.html("<option value=\"\">请先选择一级分类</option>");
                    }
                }
                
                $parentSelect.on("change", function() {
                    var parentId = $(this).val();
                    console.log("一级分类变更:", parentId);
                    loadSubcategories(parentId, null);
                });
                
                // 添加二级分类变更时的标签更新
                $childSelect.on("change", function() {
                    var categoryId = $(this).val();
                    console.log("二级分类变更:", categoryId);
                    updateTagOptions(categoryId);
                });
                
                function updateTagOptions(categoryId) {
                    console.log("更新标签选项:", categoryId);
                    
                    var tags = [];
                    
                    if (categoryId && window.categoryTags && window.categoryTags[categoryId]) {
                        console.log("使用缓存的标签数据:", window.categoryTags[categoryId]);
                        tags = window.categoryTags[categoryId];
                        updateTagFieldOptions(tags);
                        return;
                    }
                    
                    if (!categoryId) {
                        // 清空标签选项
                        updateTagFieldOptions([]);
                        return;
                    }
                    
                    // 通过AJAX获取分类标签
                    console.log("通过AJAX获取分类标签:", categoryId);
                    $.ajax({
                        url: "/admin/blog/category-tags/" + categoryId,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            console.log("标签AJAX响应:", data);
                            if (data.code === 0) {
                                // 更新缓存
                                if (!window.categoryTags) {
                                    window.categoryTags = {};
                                }
                                window.categoryTags[categoryId] = data.data;
                                updateTagFieldOptions(data.data);
                            } else {
                                console.error("获取标签失败:", data.msg);
                                updateTagFieldOptions([]);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error("获取分类标签失败:", status, error);
                            updateTagFieldOptions([]);
                        }
                    });
                }
                
                function updateTagFieldOptions(tags) {
                    console.log("更新标签字段选项:", tags);
                    
                    // 查找标签输入框
                    var $tagInput = $("input[name=\"tag\"]");
                    if ($tagInput.length === 0) {
                        console.log("未找到标签输入框");
                        return;
                    }
                    
                    // 存储当前分类的推荐标签到全局变量
                    window.currentCategoryTags = tags || [];
                    console.log("已设置当前分类标签:", window.currentCategoryTags);
                    
                    // 检查是否已经设置了自动完成
                    if (!window.tagAutocompleteSetup) {
                        setupTagAutocomplete();
                        window.tagAutocompleteSetup = true;
                    }
                }
                
                function setupTagAutocomplete() {
                    var $tagInput = $("input[name=\"tag\"]");
                    
                    // 设置输入框的自动完成功能
                    $tagInput.on("input focus", function() {
                        var inputValue = this.value;
                        var lastCommaIndex = inputValue.lastIndexOf(",");
                        var currentTyping = "";
                        
                        if (lastCommaIndex >= 0) {
                            currentTyping = inputValue.substring(lastCommaIndex + 1).trim();
                        } else {
                            currentTyping = inputValue.trim();
                        }
                        
                        showTagSuggestions(currentTyping, this);
                    });
                    
                    // 点击其他地方时隐藏建议
                    $(document).on("click", function(e) {
                        if (!$(e.target).closest(".tag-suggestions, input[name=\"tag\"]").length) {
                            $(".tag-suggestions").remove();
                        }
                    });
                }
                
                function showTagSuggestions(typingText, inputElement) {
                    // 移除之前的建议
                    $(".tag-suggestions").remove();
                    
                    if (!window.currentCategoryTags || window.currentCategoryTags.length === 0) {
                        return;
                    }
                    
                    var $input = $(inputElement);
                    var suggestions = [];
                    
                    // 如果用户没有输入，显示所有推荐标签
                    if (!typingText) {
                        suggestions = window.currentCategoryTags.slice(0, 8); // 最多显示8个
                    } else {
                        // 过滤匹配的标签
                        suggestions = window.currentCategoryTags.filter(function(tag) {
                            return tag.toLowerCase().indexOf(typingText.toLowerCase()) >= 0;
                        }).slice(0, 8);
                    }
                    
                    if (suggestions.length === 0) {
                        return;
                    }
                    
                    // 创建建议下拉框
                    var $suggestions = $("<div class=\"tag-suggestions\" style=\"position:absolute;background:white;border:1px solid #ccc;border-radius:4px;box-shadow:0 2px 8px rgba(0,0,0,0.1);z-index:1000;max-width:300px;\"></div>");
                    
                    suggestions.forEach(function(tag) {
                        var $item = $("<div class=\"suggestion-item\" style=\"padding:8px 12px;cursor:pointer;border-bottom:1px solid #f0f0f0;\" data-tag=\"" + tag + "\">" + tag + "</div>");
                        
                        $item.hover(
                            function() { $(this).css("background-color", "#f5f5f5"); },
                            function() { $(this).css("background-color", "white"); }
                        );
                        
                        $item.on("click", function() {
                            var selectedTag = $(this).data("tag");
                            insertTag(selectedTag, inputElement);
                            $(".tag-suggestions").remove();
                        });
                        
                        $suggestions.append($item);
                    });
                    
                    // 定位建议框
                    var inputOffset = $input.offset();
                    $suggestions.css({
                        "top": inputOffset.top + $input.outerHeight(),
                        "left": inputOffset.left
                    });
                    
                    $("body").append($suggestions);
                }
                
                function insertTag(tag, inputElement) {
                    var $input = $(inputElement);
                    var currentValue = $input.val();
                    var lastCommaIndex = currentValue.lastIndexOf(",");
                    var newValue = "";
                    
                    if (lastCommaIndex >= 0) {
                        newValue = currentValue.substring(0, lastCommaIndex + 1) + " " + tag;
                    } else {
                        newValue = tag;
                    }
                    
                    $input.val(newValue).trigger("change").focus();
                    console.log("已插入标签:", tag);
                }
            });
        ');

        $builder
            ->init('blog')
            ->field(function ($builder) use ($categoryTags) {
                /** @var HasFields $builder */
                $builder->id('id', 'ID');
                // 级联分类选择：先选一级分类，再选二级分类
                $builder->select('parentCategoryId', '一级分类')
                    ->optionModel('blog_category', 'id', 'title', ['pid' => 0])
                    ->required()
                    ->listable(false)
                    ->hookRendering(function (AbstractField $field, $item, $index) {
                        // 编辑时，根据二级分类自动设置一级分类
                        if ($field->renderMode() == FieldRenderMode::FORM && !empty($item->categoryId)) {
                            $category = ModelUtil::get('blog_category', $item->categoryId);
                            if ($category && $category['pid'] > 0) {
                                $field->defaultValue($category['pid']);
                            }
                        }
                    })
                    ->hookValueSerialize(function ($value, AbstractField $field) {
                        // 这个字段仅用于界面选择，不保存到数据库
                        // 通过设置column为空字符串来避免保存
                        $field->column('');
                        return $value;
                    });
                    
                $builder->select('categoryId', '二级分类')
                    ->required()
                    ->help('请先选择一级分类，然后选择对应的二级分类');
                $builder->text('title', '标题')
                    ->hookRendering(function (AbstractField $field, $item, $index) {
                        switch ($field->renderMode()) {
                            case FieldRenderMode::GRID:
                            case FieldRenderMode::DETAIL:
                                return TextLink::primary(htmlspecialchars($item->title), UrlUtil::blog($item), 'target="_blank"');
                        }
                    })->required();
                $builder->richHtml('content', '内容')->required();
                $builder->textarea('summary', '摘要')->listable(false);
                // 构建扁平化的标签数组，用于标签字段的基础选项
                $allTags = [];
                foreach ($categoryTags as $catId => $tags) {
                    foreach ($tags as $tag) {
                        if (!empty($tag) && $tag !== 'undefined') {
                            $allTags[$tag] = $tag;
                        }
                    }
                }
                
                $builder->tags('tag', '标签')
                    ->serializeType(Tags::SERIALIZE_TYPE_COLON_SEPARATED)
                    ->tags($allTags);
                $builder->images('images', '图片')->listable(false);
                $builder->text('seoKeywords', 'SEO关键词')->listable(false);
                $builder->textarea('seoDescription', 'SEO描述')->listable(false);
                $builder->switch('isTop', '置顶')->gridEditable(true);
                $builder->switch('isHot', '热门')->gridEditable(true);
                $builder->switch('isRecommend', '推荐')->gridEditable(true);
                $builder->switch('isPublished', '立即发布')
                    ->optionsYesNo()
                    ->defaultValue(true)
                    ->when('=', false, function ($builder) {
                        /** @var HasFields $builder */
                        $builder->datetime('postTime', '定时发布')
                            ->defaultValue(date('Y-m-d H:i:s'));
                    });
                $builder->radio('visitMode', '访问模式')
                    ->optionType(BlogVisitMode::class)
                    ->defaultValue(BlogVisitMode::OPEN)
                    ->when('=', BlogVisitMode::PASSWORD, function ($builder) {
                        /** @var HasFields $builder */
                        $builder->text('visitPassword', '访问密码');
                    });
                $builder->datetime('created_at', '发布时间')
                    ->listable(false)
                    ->defaultValue(date('Y-m-d H:i:s'));
                $builder->display('updated_at', L('Updated At'))->listable(false);
            })
            ->hookResponse(function (Form $form) {
                if ($form->isModeAdd()) {
                    $input = InputPackage::buildFromInput();
                    if ('front' == $input->getTrimString('from')) {
                        // 如果是会员发布，记录会员ID
                        $memberUserId = $input->getInteger('memberUserId');
                        if ($memberUserId > 0) {
                            $form->item()->memberUserId = $memberUserId;
                            $form->item()->save();
                        }
                        return Response::generate(0, '发布成功', null, CRUDUtil::jsDialogCloseAndParentRefresh());
                    }
                }
            })
            ->gridFilter(function (GridFilter $filter) {
                $filter->eq('id', L('ID'));
                $filter->like('title', '标题');
                $filter->eq('isTop', '置顶')->autoHide(true)->switchRadioYesNo();
                $filter->eq('isHot', '热门')->autoHide(true)->switchRadioYesNo();
                $filter->eq('isRecommend', '推荐')->autoHide(true)->switchRadioYesNo();
                $filter->eq('isPublished', '发布')->autoHide(true)->switchRadioYesNo();
            })
            ->gridOperateAppend(ButtonDialogRequest::primary('<i class="iconfont icon-upload"></i> 批量导入', action('\\' . __CLASS__ . '@import')))
            ->pageJumpEnable(true)
            ->hookSaving(function (Form $form) use (&$updatedCategoryIds) {
                // 验证必须选择二级分类
                $categoryId = $form->getItemValue('categoryId');
                if (empty($categoryId)) {
                    throw new BizException('请选择二级分类');
                }
                
                // 验证选择的确实是二级分类（pid不为0）
                $category = ModelUtil::get('blog_category', $categoryId);
                if (empty($category) || $category['pid'] == 0) {
                    throw new BizException('必须选择二级分类，不能直接选择一级分类');
                }
                
                if ($form->itemId()) {
                    $blog = ModelUtil::get('blog', $form->itemId());
                    if (!empty($blog['categoryId'])) {
                        $updatedCategoryIds[] = $blog['categoryId'];
                    }
                }
                return Response::generateSuccess();
            })
            ->hookChanged(function (Form $form) use (&$updatedCategoryIds) {
                $tags = [];
                RepositoryUtil::makeItems($form->item())->map(function ($item) use (&$updatedCategoryIds, &$tags) {
                    $updatedCategoryIds[] = $item->categoryId;
                    SiteUrlProvider::updateBiz(BlogSiteUrlBiz::NAME, modstart_web_url('blog/' . $item->id), $item->title);
                    BlogSuperSearchBiz::syncUpsert([$item->toArray()]);
                    $tags[] = $item->tag;
                });
                if (!empty($updatedCategoryIds)) {
                    $updatedCategoryIds = array_unique($updatedCategoryIds);
                    BlogCategoryUtil::updateCount($updatedCategoryIds);
                }
                BlogTagUtil::clearCache();
            })
            ->hookDeleted(function (Form $form) {
                $form->item()->each(function ($item) {
                    SiteUrlProvider::delete(modstart_web_url('blog/' . $item->id));
                    BlogSuperSearchBiz::syncDelete($item->id);
                });
            })
            ->title('博客文章');
    }

    /**
     * 获取二级分类数据
     */
    public function subcategories($parentId)
    {
        $subcategories = ModelUtil::all('blog_category', ['pid' => $parentId], ['id', 'title'], ['sort', 'asc']);
        
        // 记录日志以便调试
        Log::info('获取二级分类', [
            'parentId' => $parentId,
            'count' => count($subcategories),
            'data' => $subcategories
        ]);
        
        return Response::generate(0, 'success', $subcategories);
    }

    /**
     * 获取分类的标签数据
     */
    public function categoryTags($categoryId)
    {
        try {
            $category = ModelUtil::get('blog_category', $categoryId);
            
            if (empty($category)) {
                Log::warning('分类不存在', ['categoryId' => $categoryId]);
                return Response::generate(-1, '分类不存在');
            }
            
            $tags = [];
            if (!empty($category['default_tags'])) {
                $tagsString = $category['default_tags'];
                
                // 处理可能的JSON编码问题
                if (strpos($tagsString, '["') === 0 || strpos($tagsString, "[\"") === 0) {
                    // 尝试解码JSON
                    $decoded = json_decode($tagsString, true);
                    if (is_array($decoded)) {
                        $tags = array_filter(array_map('trim', $decoded));
                    } else {
                        // 如果JSON解码失败，按逗号分割
                        $tags = array_filter(array_map('trim', explode(',', $tagsString)));
                    }
                } else {
                    // 正常按逗号分割
                    $tags = array_filter(array_map('trim', explode(',', $tagsString)));
                }
            }
            
            Log::info('获取分类标签', [
                'categoryId' => $categoryId,
                'categoryTitle' => $category['title'],
                'categoryPid' => $category['pid'],
                'defaultTags' => $category['default_tags'],
                'parsedTags' => $tags,
                'tagCount' => count($tags)
            ]);
            
            return Response::generate(0, 'success', $tags);
        } catch (\Exception $e) {
            Log::error('获取分类标签失败', [
                'categoryId' => $categoryId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return Response::generate(-1, '获取标签失败: ' . $e->getMessage());
        }
    }

    public function import(ImportHandle $handle)
    {
        $templateData = [];
        $templateData[] = [
            '测试文章', '1', '文章摘要', '<p>文章内容，支持富文本HTML</p>'
        ];
        return $handle
            ->withPageTitle('批量导入博客文章')
            ->withTemplateName('博客文章')
            ->withTemplateData($templateData)
            ->withHeadTitles([
                '标题', '分类ID', '摘要', '内容',
            ])
            ->handleImport(function ($data, $param) {
                $title = empty($data[0]) ? null : $data[0];
                BizException::throwsIfEmpty('标题为空', $title);
                $blog = ModelUtil::get(Blog::class, [
                    'title' => $title,
                ]);
                $update = [];
                $update['categoryId'] = intval(empty($data[1]) ? null : $data[1]);
                $update['summary'] = empty($data[2]) ? null : $data[2];
                $update['content'] = empty($data[3]) ? null : $data[3];
                $update['isPublished'] = true;
                if ($blog) {
                    ModelUtil::update(Blog::class, $blog['id'], $update);
                } else {
                    $update['title'] = $title;
                    ModelUtil::insert(Blog::class, $update);
                }
                return Response::generateSuccess();
            })
            ->performExcel();
    }
}
