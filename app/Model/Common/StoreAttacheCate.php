<?php
declare(strict_types = 1);

namespace App\Model\Common;

use App\Model\BaseModel;
use Hyperf\Database\Model\Relations\HasMany;

/**
 * 附件分类
 */
class StoreAttacheCate extends BaseModel
{
    protected $table = "store_attache_cate";

    protected $hidden = [
        "parent_uuid",
    ];

    public function children(): HasMany
    {
        return $this->hasMany(StoreAttacheCate::class, "parent_uuid", "uuid");
    }
}