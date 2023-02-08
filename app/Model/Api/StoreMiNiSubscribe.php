<?php
declare(strict_types = 1);

namespace App\Model\Api;

use App\Model\Common\StoreMiNiSubscribe as SubscribeModel;

/**
 * 微信订阅消息
 * Class StoreWechatSubscribeConfig
 * @package App\Model\Api
 */
class StoreMiNiSubscribe extends SubscribeModel
{
    protected $hidden = [
        "file_uuid",
    ];

    protected $appends = [
        'subscribe_number'// 剩余提醒次数
    ];

    public function getSubscribeNumberAttribute($key): int
    {
        return 0;
    }
}