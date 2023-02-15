<?php
declare(strict_types = 1);

namespace App\Model\Shell;

use App\Model\Model;

class StoreArticleReadHistory extends Model
{
    protected $table = "store_article_read_history";

    protected $fillable = [
        "uuid",
        "store_uuid",
        "article_uuid",
        "user_uuid",
    ];
}