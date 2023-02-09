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
    protected $hidden = [
        "file_uuid",
    ];
}