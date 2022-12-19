<?php
declare(strict_types = 1);

namespace App\Model\Api;


/**
 * 文章阅读点赞记录
 * Class StoreArticleReadClick
 * @package App\Model\Api
 */
class StoreArticleReadClick extends \App\Model\Common\StoreArticleReadClick
{
    public $searchFields = [
        'store_uuid',
        'user_uuid',
        'article_uuid',
        'type',
    ];
}