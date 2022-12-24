<?php
declare(strict_types=1);

namespace App\Model\Common;

use App\Model\BaseModel;

/**
 * 问答试题记录
 */
class StoreUserExamReading extends BaseModel
{
    protected $table = "store_user_exam_reading";

    protected $fillable = [
        "reading_uuid",
        "store_uuid",
        "user_uuid",
        "uuid",
        "collection_uuid",
    ];
}