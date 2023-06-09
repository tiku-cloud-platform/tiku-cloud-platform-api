<?php
declare(strict_types = 1);

namespace App\Model\Common;

use App\Model\BaseModel;

/**
 * 文章分享历史
 * Class StoreArticleShare
 * @package App\Model\Common
 */
class StoreArticleShare extends BaseModel
{
    protected $table = 'store_article_share_history';

    protected $fillable = [
        'uuid',
        'store_uuid',
        'user_uuid',
        'article_uuid',
        "share_type"
    ];
}