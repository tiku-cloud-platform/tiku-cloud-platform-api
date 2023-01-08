<?php
declare(strict_types = 1);

namespace App\Model\Api;

/**
 * 数据列表
 */
class StoreBook extends \App\Model\Common\StoreBook
{
    protected $hidden = [
        "file_uuid",
    ];

    protected $appends = [
        "read_number",
    ];

    public function getReadNumberAttribute(): int
    {
        return (int)(new StoreBookContent())::query()->where([
            ["store_book_uuid", "=", $this->getAttribute("uuid")]
        ])->sum("read_number");

    }
}