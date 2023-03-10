<?php
declare(strict_types = 1);

namespace App\Model\Common;

use App\Model\BaseModel;
use Hyperf\Database\Model\Relations\BelongsTo;

/**
 * 教程评价
 */
class StoreBookEvaluateHistory extends BaseModel
{
    protected $table = "store_book_evaluate_history";

    protected $fillable = [
        "uuid",
        "store_uuid",
        "book_uuid",
        "user_uuid",
        "is_show",
        "score",
        "content",
    ];

    protected $hidden = [
        "user_uuid"
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(StoreMiNiWeChatUser::class, "user_uuid", "user_uuid");
    }
}