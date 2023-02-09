<?php
declare(strict_types = 1);

namespace App\Model\Common;

use App\Model\BaseModel;

/**
 * 文章点赞历史
 */
class StoreArticleClick extends BaseModel
{
    protected $table = "store_article_click_history";

    protected $fillable = [
        'uuid',
        'store_uuid',
        'user_uuid',
        'article_uuid',
    ];
}