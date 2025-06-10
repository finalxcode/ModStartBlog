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
                $categoryTags[$cat['id']] = array_filter(array_map('trim', explode(',', !empty($cat['default_tags']) ? $cat[ 'default_tags'] : "")));
            }
        }

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
                
                // 页面加载时，如果已选择二级分类，则加载对应的选项
                if ($parentSelect.val()) {
                    loadSubcategories($parentSelect.val(), currentCategoryId);
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
                $builder->tags('tag', '标签')->addVariables(['categoryTags' => $categoryTags])
                    ->serializeType(Tags::SERIALIZE_TYPE_COLON_SEPARATED)
                    ->tagModelField('blog', 'tag', Tags::SERIALIZE_TYPE_COLON_SEPARATED);
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
