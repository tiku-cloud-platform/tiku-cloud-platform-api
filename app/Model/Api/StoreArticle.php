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
    protected $hidden = [
        "file_uuid"
    ];
}