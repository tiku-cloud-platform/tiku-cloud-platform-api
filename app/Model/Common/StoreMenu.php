<?php
declare(strict_types = 1);

namespace App\Model\Common;


use App\Model\BaseModel;
use Hyperf\Database\Model\Relations\BelongsTo;

/**
 * 用户端菜单
 *
 * Class StoreMenu
 * @package App\Model\Common
 */
class StoreMenu extends BaseModel
{
    protected $table = 'store_menu';

    /**
     * 菜单图标地址
     *
     * @return BelongsTo
     */
    public function image(): BelongsTo
    {
        return $this->belongsTo(StorePlatformFile::class, 'file_uuid', 'uuid');
    }
}