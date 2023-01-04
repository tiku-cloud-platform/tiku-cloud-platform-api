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
}