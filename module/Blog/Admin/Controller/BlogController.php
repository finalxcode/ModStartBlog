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
                
                // 页面加载时的初始化逻辑
                setTimeout(function() {
                    // 重新获取当前值，确保DOM完全加载
                    var parentValue = $parentSelect.val();
                    var childValue = $childSelect.val();
                    
                    console.log("延时初始化检查:", {
                        parentValue: parentValue,
                        childValue: childValue,
                        parentOptions: $parentSelect.find("option").length,
                        childOptions: $childSelect.find("option").length
                    });
                    
                    // 如果已选择一级分类，则加载对应的二级分类
                    if (parentValue) {
                        loadSubcategories(parentValue, childValue);
                    }
                    
                    // 如果已选择二级分类，则更新标签选项
                    if (childValue) {
                        updateTagOptions(childValue);
                    }
                }, 500); // 延时500ms确保DOM完全渲染
                
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
                    console.log("二级分类变更，准备设置标签自动完成");
                    
                    // 检查是否已经设置了自动完成
                    if (!window.tagAutocompleteSetup) {
                        setupTagAutocomplete();
                        window.tagAutocompleteSetup = true;
                        console.log("标签自动完成已设置");
                    }
                }
                
                function setupTagAutocomplete() {
                    // 查找Tagify生成的标签输入框
                    var $tagInput = $(".tagify__input");
                    var $tagifyContainer = $(".tagify");
                    var $hiddenInput = $("input[name=\"tag\"]");
                    
                    console.log("查找标签输入组件:", {
                        tagifyInput: $tagInput.length,
                        tagifyContainer: $tagifyContainer.length,
                        hiddenInput: $hiddenInput.length
                    });
                    
                    if ($tagInput.length === 0 || $tagifyContainer.length === 0) {
                        console.warn("未找到Tagify标签输入框，尝试延时重新查找");
                        setTimeout(function() {
                            setupTagAutocomplete();
                        }, 1000);
                        return;
                    }
                    
                    // 使用第一个找到的标签输入框
                    $tagInput = $tagInput.first();
                    $tagifyContainer = $tagifyContainer.first();
                    console.log("使用标签输入框:", {
                        input: $tagInput[0],
                        container: $tagifyContainer[0],
                        hidden: $hiddenInput[0]
                    });
                    
                    // 清除之前的事件绑定
                    $tagInput.off(".tagAutocomplete");
                    $tagifyContainer.off(".tagAutocomplete");
                    
                    // 设置Tagify容器和输入框的自动完成功能
                    $tagifyContainer.on("click.tagAutocomplete", function(e) {
                        e.stopPropagation();
                        console.log("标签容器被点击", this);
                        setTimeout(function() {
                            showTagSuggestions("", $tagifyContainer[0]);
                        }, 100);
                    });
                    
                    $tagInput.on("focus.tagAutocomplete click.tagAutocomplete", function(e) {
                        e.stopPropagation();
                        console.log("标签输入框获得焦点", this);
                        setTimeout(function() {
                            showTagSuggestions("", $tagifyContainer[0]);
                        }, 100);
                    });
                    
                    $tagInput.on("input.tagAutocomplete keyup.tagAutocomplete", function() {
                        var inputValue = $(this).text() || "";  // 使用text()而不是val()
                        console.log("用户输入:", inputValue);
                        
                        // 只有当用户真正在输入时才过滤，点击选择时不过滤
                        if (!window.selectingTag) {
                            showTagSuggestions(inputValue.trim(), $tagifyContainer[0]);
                        }
                    });
                    
                    // 失去焦点时隐藏建议
                    $tagInput.on("blur.tagAutocomplete", function() {
                        setTimeout(function() {
                            if (!$(".tag-suggestions:hover").length) {
                                console.log("输入框失去焦点，隐藏建议");
                                $(".tag-suggestions").remove();
                            }
                        }, 200);
                    });
                    
                    // 点击其他地方时隐藏建议（但不包括建议框本身）
                    $(document).off("click.tagSuggestions").on("click.tagSuggestions", function(e) {
                        if (!$(e.target).closest(".tag-suggestions, .tagify").length) {
                            console.log("点击其他地方，隐藏建议");
                            $(".tag-suggestions").remove();
                        }
                    });
                }
                
                function showTagSuggestions(typingText, inputElement) {
                    // 移除之前的建议
                    $(".tag-suggestions").remove();
                    
                    // 检查是否选择了二级分类
                    var $categorySelect = $("select[name=\"categoryId\"], input[name=\"categoryId\"]");
                    var selectedCategoryId = $categorySelect.val();
                    
                    if (!selectedCategoryId) {
                        console.log("未选择二级分类，不显示标签建议");
                        return;
                    }
                    
                    // 获取当前选中分类的标签
                    var currentTags = [];
                    if (window.categoryTags && window.categoryTags[selectedCategoryId]) {
                        currentTags = window.categoryTags[selectedCategoryId];
                    }
                    
                    if (!currentTags || currentTags.length === 0) {
                        console.log("当前分类没有推荐标签");
                        return;
                    }
                    
                    // 过滤掉无效的标签
                    currentTags = currentTags.filter(function(tag) {
                        return tag && tag !== "undefined" && tag.trim() !== "";
                    });
                    
                    var $input = $(inputElement);
                    var suggestions = [];
                    
                    // 获取已经添加的标签
                    var $hiddenInput = $("input[name=\"tag\"]");
                    var existingTags = [];
                    if ($hiddenInput.val()) {
                        existingTags = $hiddenInput.val().split(":").filter(function(t) {
                            return t && t.trim() !== "";
                        });
                    }
                    
                    // 过滤掉已存在的标签
                    var availableTags = currentTags.filter(function(tag) {
                        return existingTags.indexOf(tag) === -1;
                    });
                    
                    // 如果用户没有输入，显示所有可用的推荐标签
                    if (!typingText) {
                        suggestions = availableTags.slice(0, 8); // 最多显示8个
                    } else {
                        // 过滤匹配的标签
                        suggestions = availableTags.filter(function(tag) {
                            return tag.toLowerCase().indexOf(typingText.toLowerCase()) >= 0;
                        }).slice(0, 8);
                    }
                    
                    if (suggestions.length === 0) {
                        console.log("没有匹配的标签建议");
                        return;
                    }
                    
                    console.log("显示标签建议:", suggestions);
                    console.log("输入框元素:", $input[0]);
                    console.log("输入框位置:", $input.offset());
                    
                    // 创建建议下拉框
                    var $suggestions = $("<div class=\"tag-suggestions\" style=\"position:absolute;background:white;border:1px solid #ccc;border-radius:4px;box-shadow:0 2px 8px rgba(0,0,0,0.1);z-index:99999;max-width:300px;min-width:200px;font-size:14px;\"></div>");
                    
                    suggestions.forEach(function(tag, index) {
                        var $item = $("<div class=\"suggestion-item\" style=\"padding:8px 12px;cursor:pointer;" + (index < suggestions.length - 1 ? "border-bottom:1px solid #f0f0f0;" : "") + "\" data-tag=\"" + tag + "\">" + tag + "</div>");
                        
                        $item.hover(
                            function() { $(this).css("background-color", "#f5f5f5"); },
                            function() { $(this).css("background-color", "white"); }
                        );
                        
                        $item.on("mousedown", function(e) {
                            // 使用mousedown而不是click，防止blur事件先触发
                            e.preventDefault();
                            e.stopPropagation();
                            var selectedTag = $(this).data("tag");
                            console.log("点击选择标签:", selectedTag, "容器:", inputElement);
                            
                            // 设置标志防止输入事件干扰
                            window.selectingTag = true;
                            
                            insertTag(selectedTag, inputElement);
                            $(".tag-suggestions").remove();
                            
                            // 清空输入框内容并重新获得焦点
                            setTimeout(function() {
                                var $tagifyInput = $(inputElement).find(".tagify__input");
                                $tagifyInput.text("");
                                $tagifyInput.focus();
                                
                                // 重置标志
                                setTimeout(function() {
                                    window.selectingTag = false;
                                }, 100);
                            }, 100);
                            
                            return false;
                        });
                        
                        $suggestions.append($item);
                    });
                    
                    // 更准确的定位建议框 - 基于Tagify容器
                    var $container = $(inputElement);  // 这里的inputElement是tagify容器
                    var inputOffset = $container.offset();
                    var inputHeight = $container.outerHeight();
                    var inputWidth = $container.outerWidth();
                    
                    console.log("定位信息:", {
                        offset: inputOffset,
                        height: inputHeight,
                        width: inputWidth,
                        element: inputElement
                    });
                    
                    // 基于Tagify容器定位
                    var topPosition = inputOffset.top + inputHeight + 2;
                    var leftPosition = inputOffset.left;
                    
                    // 确保不超出视窗
                    var windowHeight = $(window).height();
                    var windowWidth = $(window).width();
                    var scrollTop = $(window).scrollTop();
                    
                    if (topPosition + 200 > windowHeight + scrollTop) {
                        topPosition = inputOffset.top - 200 - 2; // 显示在输入框上方
                    }
                    
                    if (leftPosition + 300 > windowWidth) {
                        leftPosition = windowWidth - 300 - 20;
                    }
                    
                    $suggestions.css({
                        "position": "fixed",
                        "top": (topPosition - scrollTop) + "px",
                        "left": leftPosition + "px"
                    });
                    
                    // 阻止建议框的所有事件冒泡
                    $suggestions.on("mousedown mouseup click", function(e) {
                        e.stopPropagation();
                    });
                    
                    $("body").append($suggestions);
                    console.log("标签建议框已显示，最终位置:", (topPosition - scrollTop), leftPosition);
                }
                
                function insertTag(tag, tagifyContainer) {
                    console.log("插入标签到Tagify:", tag, "容器:", tagifyContainer);
                    
                    var $container = $(tagifyContainer);
                    var $hiddenInput = $("input[name=\"tag\"]");
                    var $tagifyInput = $container.find(".tagify__input");
                    
                    console.log("DOM元素检查:", {
                        container: $container[0],
                        hiddenInput: $hiddenInput[0],
                        tagifyInput: $tagifyInput[0]
                    });
                    
                    // 查找jQuery.tagify实例
                    var tagifyInstance = null;
                    
                    // ModStart使用的是jQuery.tagify，实例存储在jQuery对象的data中
                    // 查找隐藏输入框的tagify实例
                    if ($hiddenInput.length > 0) {
                        // 方法1：从jQuery data查找
                        tagifyInstance = $hiddenInput.data("tagify");
                        if (tagifyInstance) {
                            console.log("从jQuery data找到Tagify实例");
                        }
                        
                        // 方法2：从jQuery实例查找
                        if (!tagifyInstance && typeof $hiddenInput.tagify === "function") {
                            // 尝试获取已存在的实例
                            try {
                                var jqueryData = $hiddenInput.data();
                                for (var key in jqueryData) {
                                    if (key.indexOf("tagify") !== -1) {
                                        tagifyInstance = jqueryData[key];
                                        console.log("从jQuery内部data找到Tagify实例:", key);
                                        break;
                                    }
                                }
                            } catch (e) {
                                console.log("查找jQuery内部data失败:", e);
                            }
                        }
                        
                        // 方法3：通过原始DOM元素查找
                        if (!tagifyInstance && $hiddenInput[0]) {
                            var elem = $hiddenInput[0];
                            if (elem.tagify) {
                                tagifyInstance = elem.tagify;
                                console.log("从原始DOM元素找到Tagify实例");
                            }
                        }
                    }
                    
                    console.log("最终找到的Tagify实例:", tagifyInstance);
                    
                    // 方法1：使用jQuery.tagify API
                    if (tagifyInstance) {
                        console.log("使用jQuery.tagify实例添加标签");
                        try {
                            // jQuery.tagify的API方式
                            if (typeof tagifyInstance.addTags === "function") {
                                tagifyInstance.addTags([tag]);
                                console.log("成功通过addTags添加标签:", tag);
                                return;
                            } else if (typeof $hiddenInput.tagify === "function") {
                                // 通过jQuery接口添加
                                $hiddenInput.tagify("addTags", [tag]);
                                console.log("成功通过jQuery接口添加标签:", tag);
                                return;
                            }
                        } catch (e) {
                            console.error("Tagify API失败:", e);
                        }
                    }
                    
                    // 方法1.5：尝试直接通过jQuery.tagify接口
                    if (typeof $hiddenInput.tagify === "function") {
                        console.log("尝试直接使用jQuery.tagify接口");
                        try {
                            $hiddenInput.tagify("addTags", [tag]);
                            console.log("成功通过直接接口添加标签:", tag);
                            return;
                        } catch (e) {
                            console.error("jQuery.tagify接口失败:", e);
                        }
                    }
                    
                    console.log("所有API方法失败，使用备用方法");
                    
                    // 方法2：直接更新隐藏字段并重新初始化Tagify
                    console.log("使用直接更新方法添加标签");
                    
                    // 更新隐藏字段
                    var currentValue = $hiddenInput.val() || "";
                    var newValue = "";
                    
                    if (currentValue === "") {
                        newValue = tag;
                    } else {
                        // 确保不重复添加
                        var existingTags = currentValue.split(":").filter(function(t) { return t.trim() !== ""; });
                        if (existingTags.indexOf(tag) === -1) {
                            newValue = currentValue + ":" + tag;
                        } else {
                            console.log("标签已存在，跳过添加");
                            return;
                        }
                    }
                    
                    console.log("更新隐藏字段值:", newValue);
                    $hiddenInput.val(newValue);
                    
                    // 方法2.1：如果有Tagify实例，尝试重新加载值
                    if (tagifyInstance) {
                        try {
                            // 尝试各种Tagify更新方法
                            if (typeof tagifyInstance.loadOriginalValues === "function") {
                                tagifyInstance.loadOriginalValues();
                                console.log("使用loadOriginalValues更新");
                            } else if (typeof tagifyInstance.DOM.scope.refresh === "function") {
                                tagifyInstance.DOM.scope.refresh();
                                console.log("使用refresh更新");
                            } else {
                                // 手动重建标签
                                var tags = newValue.split(":").filter(function(t) { return t.trim() !== ""; });
                                tagifyInstance.removeAllTags();
                                tagifyInstance.addTags(tags);
                                console.log("手动重建标签");
                            }
                        } catch (e) {
                            console.error("Tagify更新失败:", e);
                        }
                    }
                    
                    // 方法2.2：强制重新渲染
                    setTimeout(function() {
                        // 触发change事件
                        $hiddenInput.trigger("change");
                        
                        // 如果仍然没有显示，尝试重新创建Tagify
                        if ($container.hasClass("tagify--empty")) {
                            console.log("标签仍然为空，尝试强制重新渲染");
                            
                            // 临时移除然后重新添加值
                            var tempValue = $hiddenInput.val();
                            $hiddenInput.val("").trigger("change");
                            
                            setTimeout(function() {
                                $hiddenInput.val(tempValue).trigger("change");
                                console.log("强制重新渲染完成");
                            }, 100);
                        }
                        
                        console.log("标签插入完成，最终隐藏字段值:", $hiddenInput.val());
                    }, 100);
                }
            });
            
            // 级联分类选择JavaScript逻辑
            $(document).on("change", "select[name=parentCategoryId]", function() {
                console.log("一级分类选择改变");
                var parentId = $(this).val();
                var $categorySelect = $("select[name=categoryId]");
                
                if (!parentId) {
                    console.log("清空二级分类选项");
                    $categorySelect.html("<option value=\"\">请先选择一级分类</option>");
                    return;
                }
                
                console.log("加载二级分类，parentId:", parentId);
                
                // 显示加载状态
                $categorySelect.html("<option value=\"\">加载中...</option>");
                
                // 发送AJAX请求获取二级分类
                $.ajax({
                    url: "/admin/blog/subcategories/" + parentId,
                    type: "GET",
                    dataType: "json",
                    success: function(response) {
                        console.log("二级分类加载成功:", response);
                        
                        if (response.code === 0 && response.data) {
                            var options = "<option value=\"\">请选择二级分类</option>";
                            var currentCategoryId = $categorySelect.data("current-value") || "";
                            $.each(response.data, function(index, category) {
                                var selected = (currentCategoryId && currentCategoryId == category.id) ? " selected" : "";
                                options += "<option value=\"" + category.id + "\"" + selected + ">" + category.title + "</option>";
                            });
                            $categorySelect.html(options);
                            
                            // 恢复原选中值
                            if (currentCategoryId) {
                                $categorySelect.val(currentCategoryId);
                            }
                        } else {
                            console.error("二级分类加载失败:", response.msg || "未知错误");
                            $categorySelect.html("<option value=\"\">加载失败</option>");
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX请求失败:", status, error);
                        $categorySelect.html("<option value=\"\">加载失败</option>");
                    }
                });
            });
            
            // 页面加载时，如果有选中的一级分类，自动触发级联加载
            $(document).ready(function() {
                setTimeout(function() {
                    var $parentSelect = $("select[name=parentCategoryId]");
                    var $categorySelect = $("select[name=categoryId]");
                    
                    // 保存当前二级分类的值（编辑模式）
                    var currentCategoryValue = $categorySelect.val();
                    if (currentCategoryValue) {
                        $categorySelect.data("current-value", currentCategoryValue);
                        console.log("保存当前二级分类值:", currentCategoryValue);
                    }
                    
                    if ($parentSelect.val()) {
                        console.log("页面加载时触发级联逻辑");
                        $parentSelect.trigger("change");
                    }
                }, 500);
            });
        ');

        $builder
            ->init('blog')
            ->field(function ($builder) use ($categoryTags) {
                /** @var HasFields $builder */
                $builder->id('id', 'ID');
                // 级联分类选择：先选一级分类，再选二级分类
                $builder->select('parentCategoryId', '一级分类')
                    ->help('请先选择一级分类')
                    ->optionModel('blog_category', 'id', 'title', ['pid' => 0])
                    ->hookRendering(function (AbstractField $field, $item, $index) {
                        if ($field->renderMode() == FieldRenderMode::FORM) {
                            // 编辑时，根据二级分类自动设置一级分类
                            if (!empty($item->categoryId)) {
                                $category = ModelUtil::get('blog_category', $item->categoryId);
                                if ($category && $category['pid'] > 0) {
                                    $field->value($category['pid']);
                                }
                            }
                        }
                    });
                    
                $builder->select('categoryId', '二级分类')
                    ->required()
                    ->help('请先选择一级分类，然后选择对应的二级分类')
                    ->options(['' => '请先选择一级分类'])
                    ->hookRendering(function (AbstractField $field, $item, $index) {
                        if ($field->renderMode() == FieldRenderMode::FORM) {
                            if (!empty($item->categoryId)) {
                                // 编辑时，根据当前选中的二级分类，加载对应的一级分类下的所有二级分类
                                $currentCategory = ModelUtil::get('blog_category', $item->categoryId);
                                if ($currentCategory && $currentCategory['pid'] > 0) {
                                    $subcategories = ModelUtil::all('blog_category', ['pid' => $currentCategory['pid']], ['id', 'title'], ['sort', 'asc']);
                                    $options = [];
                                    $options[''] = '请选择二级分类';
                                    foreach ($subcategories as $sub) {
                                        $options[$sub['id']] = $sub['title'];
                                    }
                                    $field->options($options);
                                    // 设置当前选中的二级分类值
                                    $field->value($item->categoryId);
                                }
                            }
                        }
                    });
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
                $builder->tags('tag', '标签')
                    ->serializeType(Tags::SERIALIZE_TYPE_COLON_SEPARATED);
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
                // 从输入数据中获取分类ID
                $input = InputPackage::buildFromInput();
                $categoryId = $input->getInteger('categoryId');
                
                // 验证必须选择二级分类
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
        if (empty($parentId)) {
            return Response::generate(-1, '请提供一级分类ID');
        }
        
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
