<?php
declare(strict_types = 1);

namespace App\Model\Common;

use App\Model\BaseModel;

/**
 * 文章收藏历史
 * Class StoreArticleCollection
 * @package App\Model\Common
 */
class StoreArticleCollection extends BaseModel
{
    protected $table = 'store_article_collection_history';

    protected $fillable = [
        'uuid',
        'store_uuid',
        'user_uuid',
        'article_uuid',
    ];
}