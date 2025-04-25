<?php

namespace ModStart\Core\Type;

interface TreeAble
{
    /**
     * 获取树形结构的父级ID字段名
     * @return string
     */
    public function getTreeParentIdField();

    /**
     * 获取树形结构的排序字段名
     * @return string
     */
    public function getTreeSortField();

    /**
     * 获取树形结构的标题字段名
     * @return string
     */
    public function getTreeTitleField();
} 