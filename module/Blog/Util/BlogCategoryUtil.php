<?php


namespace Module\Blog\Util;


use Illuminate\Support\Facades\Cache;
use ModStart\Core\Assets\AssetsUtil;
use ModStart\Core\Dao\ModelUtil;
use ModStart\Core\Util\TreeUtil;
use Module\Blog\Model\Blog;
use Module\Blog\Model\BlogCategory;

class BlogCategoryUtil
{
    public static function clearCache()
    {
        Cache::forget('Blog:Categories');
        // 同时清理二级分类标签缓存
        self::clearSubcategoryTagsCache();
    }

    public static function all()
    {
        return Cache::rememberForever('Blog:Categories', function () {
            $records = ModelUtil::all(BlogCategory::class, [], ['*'], ['sort', 'asc']);
            AssetsUtil::recordsFixFullOrDefault($records, 'cover', 'asset/image/none.png');
            foreach ($records as $k => $v) {
                $records[$k]['_url'] = UrlUtil::category($v);
            }
            return $records;
        });
    }

    public static function categoryTree()
    {
        $nodes = self::all();
        return TreeUtil::nodesToTree($nodes);
    }

    public static function categoryTreeFlat()
    {
        $tree = self::categoryTree();
        $nodes = TreeUtil::treeToListWithLevel($tree);
        foreach ($nodes as $i => $v) {
            $chain = TreeUtil::nodesChain($nodes, $v['id']);
            $nodes[$i]['_fullTitle'] = join('-', array_map(function ($item) {
                return $item['title'];
            }, $chain));
        }
        return $nodes;
    }

    public static function categoryChainWithItems($categoryId)
    {
        $records = self::all();
        return TreeUtil::nodesChainWithItems($records, $categoryId);
    }

    public static function get($id)
    {
        foreach (self::all() as $one) {
            if ($one['id'] == $id) {
                return $one;
            }
        }
        return null;
    }

    public static function listChildCategories($categoryId)
    {
        $records = self::all();
        $records = array_filter($records, function ($item) use ($categoryId) {
            return $item['pid'] == $categoryId;
        });
        return array_values($records);
    }

    public static function childrenIds($categoryId)
    {
        if ($categoryId <= 0) {
            return [];
        }
        $nodes = self::all();
        return array_merge([$categoryId], TreeUtil::nodesChildrenIds($nodes, $categoryId));
    }

    public static function updateCount($categoryIds)
    {
        if (!is_array($categoryIds)) {
            $categoryIds = [$categoryIds];
        }
        $categoryIds = array_unique($categoryIds);
        foreach ($categoryIds as $catId) {
            $chapter = self::get($catId);
            if (empty($chapter)) {
                continue;
            }
            $tree = self::categoryTree();
            $chain = TreeUtil::treeChain($tree, $catId);
            foreach ($chain as $item) {
                $ids = TreeUtil::treeNodeChildrenIds($tree, $item['id']);
                if (empty($ids)) {
                    $blogCount = 0;
                } else {
                    $blogCount = Blog::published()->whereIn('categoryId', $ids)->count();
                }
                ModelUtil::update(BlogCategory::class, $item['id'], [
                    'blogCount' => $blogCount,
                ]);
            }
        }
        self::clearCache();
    }

    /**
     * 获取所有二级分类的默认标签
     * @param int $limit 限制数量，0为不限制
     * @return array 标签→数量映射
     */
    public static function getSubcategoryTags($limit = 0)
    {
        $tagCounts = Cache::rememberForever('Blog:SubcategoryTags', function () {
            // 获取所有二级分类（pid > 0）
            $subcategories = BlogCategory::where('pid', '>', 0)->get(['id', 'title', 'default_tags'])->toArray();
            
            $tagCounts = [];
            
            foreach ($subcategories as $category) {
                if (empty($category['default_tags'])) {
                    continue;
                }
                
                // 解析标签（支持JSON和逗号分隔两种格式）
                $tags = self::parseTagsString($category['default_tags']);
                
                foreach ($tags as $tag) {
                    $tag = trim($tag);
                    if (empty($tag)) {
                        continue;
                    }
                    
                    // 统计每个标签对应的博客数量
                    if (!isset($tagCounts[$tag])) {
                        $tagCounts[$tag] = self::getTagBlogCount($tag);
                    }
                }
            }
            
            // 按博客数量降序排序
            arsort($tagCounts);
            
            return $tagCounts;
        });

        // 应用限制
        if ($limit > 0) {
            $tagCounts = array_slice($tagCounts, 0, $limit, true);
        }

        return $tagCounts;
    }

    /**
     * 解析标签字符串，支持JSON和逗号分隔两种格式
     * @param string $tagsString
     * @return array
     */
    private static function parseTagsString($tagsString)
    {
        if (empty($tagsString)) {
            return [];
        }
        
        // 尝试解析JSON格式
        if (strpos($tagsString, '[') === 0 || strpos($tagsString, '["') === 0) {
            $decoded = json_decode($tagsString, true);
            if (is_array($decoded)) {
                return array_filter(array_map('trim', $decoded));
            }
        }
        
        // 按逗号分隔
        return array_filter(array_map('trim', explode(',', $tagsString)));
    }

    /**
     * 获取标签对应的博客数量
     * @param string $tag
     * @return int
     */
    private static function getTagBlogCount($tag)
    {
        // 查询包含该标签的博客数量
        return Blog::published()
            ->where('tag', 'like', '%' . $tag . '%')
            ->count();
    }

    /**
     * 清除二级分类标签缓存
     */
    public static function clearSubcategoryTagsCache()
    {
        Cache::forget('Blog:SubcategoryTags');
    }
}
