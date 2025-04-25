<?php

namespace Module\Blog\Model;

use Illuminate\Database\Eloquent\Model;
use ModStart\Core\Dao\ModelUtil;
use ModStart\Core\Type\TreeAble;

class BlogCategory extends Model implements TreeAble
{
    protected $table = 'blog_category';

    public static function getTreeList()
    {
        return ModelUtil::getTreeList(BlogCategory::class);
    }

    public function children()
    {
        return $this->hasMany(BlogCategory::class, 'pid', 'id');
    }

    public function parent()
    {
        return $this->belongsTo(BlogCategory::class, 'pid', 'id');
    }
}
