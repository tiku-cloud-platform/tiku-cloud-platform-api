<?php
declare(strict_types = 1);

namespace App\Model\Common;

use App\Model\BaseModel;

/**
 * 文章阅读历史
 * Class StoreArticleRead
 * @package App\Model\Common
 */
class StoreArticleRead extends BaseModel
{
    protected $table = 'store_article_read_history';

    protected $fillable = [
        'uuid',
        'store_uuid',
        'user_uuid',
        'article_uuid',
    ];
}