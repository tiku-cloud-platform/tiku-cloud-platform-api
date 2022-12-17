<?php
declare(strict_types = 1);

namespace App\Model\Api;


/**
 * 文章分类
 *
 * Class StoreArticleCategory
 * @package App\Model\Api
 */
class StoreArticleCategory extends \App\Model\Common\StoreArticleCategory
{
    public $searchFields = [
        'uuid as uid',
        'title',
        'file_uuid',
    ];

    protected $hidden = [
        "file_uuid",
    ];
}