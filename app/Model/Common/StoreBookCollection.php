<?php
declare(strict_types = 1);

namespace App\Model\Common;

use App\Model\BaseModel;

/**
 * 书籍收藏记录
 */
class StoreBookCollection extends BaseModel
{
    protected $table = "store_book_collection";

    protected $fillable = [
        "book_uuid",
        "uuid",
        "user_uuid",
        "store_uuid",
    ];
}