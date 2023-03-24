<?php
declare(strict_types = 1);

namespace App\Model\Common;

use App\Model\BaseModel;
use Hyperf\Database\Model\Relations\BelongsTo;

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

    public function book(): BelongsTo
    {
        return $this->belongsTo(StoreBook::class, "book_uuid", "uuid")
            ->where([
                ["is_show", "=", 1]
            ])
            ->with(["image:uuid,file_url,file_name as file_path"]);
    }
}