<?php
declare(strict_types = 1);

namespace App\Model\Common;

use App\Model\BaseModel;

/**
 * 积分统计
 */
class StoreUserScoreCollection extends BaseModel
{
    protected $table = "store_user_score_collection";

    protected $fillable = [
        "user_uuid",
        "uuid",
        "score",
        "store_uuid",
    ];

    protected $casts = [
        "score" => "string"
    ];
}