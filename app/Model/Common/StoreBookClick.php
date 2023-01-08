<?php
declare(strict_types = 1);

namespace App\Model\Common;

use App\Model\BaseModel;

/**
 * 书籍点赞记录
 */
class StoreBookClick extends BaseModel
{
    protected $table = "store_book_click";

    protected $fillable = [
        "book_uuid",
        "uuid",
        "user_uuid",
        "store_uuid",
    ];
}