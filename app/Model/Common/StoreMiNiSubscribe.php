<?php
declare(strict_types = 1);

namespace App\Model\Common;

use App\Model\BaseModel;
use Hyperf\Database\Model\Relations\BelongsTo;

/**
 * 微信订阅消息配置
 * Class StoreWechatSubscribeConfig
 * @package App\Model\Common
 */
class StoreMiNiSubscribe extends BaseModel
{
    protected $table = 'store_mini_subscribe';

    protected $fillable = [
        'uuid',
        'store_uuid',
        'title',
        'template_id',
        'page',
        'data',
        'miniprogram_state',
        'lang',
        'is_show',
        'orders',
        'file_uuid',
        'description'
    ];

    protected $casts = [
        'data' => 'array'
    ];

    /**
     * 图标封面
     * @return BelongsTo
     * @author kert
     */
    public function image(): BelongsTo
    {
        return $this->belongsTo(StorePlatformFile::class, 'file_uuid', 'uuid');
    }
}