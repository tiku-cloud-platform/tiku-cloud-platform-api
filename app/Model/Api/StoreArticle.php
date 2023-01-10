<?php
declare(strict_types = 1);

namespace App\Model\Api;

/**
 * 文章
 *
 * Class StoreArticle
 * @package App\Model\Api
 */
class StoreArticle extends \App\Model\Common\StoreArticle
{
    /**
     * 详情查询字段
     *
     * @var array
     */
    public $searchFields = [
        'uuid',
        'article_category_uuid as category_uid',
        'title',
        'file_uuid',
        'content',
        'publish_date',
        'author',
        'source',
        'read_number',
        'click_number',
    ];

    /**
     * 列表查询字段
     *
     * @var array
     */
    public $listSearchFields = [
        'uuid',
        'title',
        'file_uuid',
        'source',
        'read_number',
        'author',
        "article_category_uuid as category_uid",
        "click_number",
    ];

    protected $hidden = [
        "file_uuid"
    ];
}