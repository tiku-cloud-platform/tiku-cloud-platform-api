<?php
declare(strict_types = 1);

namespace App\Model\Common;

use App\Model\BaseModel;
use Hyperf\Database\Model\Relations\BelongsTo;

/**
 * 附件管理
 */
class StoreAttache extends BaseModel
{
    protected $table = "store_attache";

    protected $hidden = [
        "file_uuid"
    ];

    public function cover(): BelongsTo
    {
        return $this->belongsTo(StorePlatformFile::class, "file_uuid", "uuid");
    }

    public function getCreatedAtAttribute($key)
    {
        return date("Y-m-d", strtotime($key));
    }
}