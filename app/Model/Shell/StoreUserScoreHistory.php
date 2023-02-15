<?php
declare(strict_types = 1);

namespace App\Model\Shell;

use App\Model\Model;

class StoreUserScoreHistory extends Model
{
    protected $table = "store_user_score_history";

    protected $fillable = [
        "client_type",
        "uuid",
        "title",
        "type",
        "score",
        "user_uuid",
        "store_uuid",
    ];
}