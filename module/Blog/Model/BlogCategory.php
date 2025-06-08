<?php

namespace Module\Blog\Model;

use Illuminate\Database\Eloquent\Model;
use ModStart\Core\Dao\ModelUtil;

class BlogCategory extends Model
{
    protected $table = 'blog_category';

    public static function getTreeList()
    {
        $models = ModelUtil::all(BlogCategory::class, [], ['*'], ['sort' => 'asc']);
        $nodes = [];
        foreach ($models as $model) {
            $nodes[] = [
                'id' => $model['id'],
                'pid' => $model['pid'],
                'title' => $model['title'],
                'sort' => $model['sort']
            ];
        }
        return \ModStart\Core\Util\TreeUtil::nodesToTree($nodes, 0, 'id', 'pid', 'sort');
    }

    public function children()
    {
        return $this->hasMany(BlogCategory::class, 'pid', 'id');
    }

    public function parent()
    {
        return $this->belongsTo(BlogCategory::class, 'pid', 'id');
    }

    /**
     * 获取树形结构的父级ID字段名
     * @return string
     */
    public function getTreeParentIdField()
    {
        return 'pid';
    }

    /**
     * 获取树形结构的排序字段名
     * @return string
     */
    public function getTreeSortField()
    {
        return 'sort';
    }

    /**
     * 获取树形结构的标题字段名
     * @return string
     */
    public function getTreeTitleField()
    {
        return 'title';
    }
}
