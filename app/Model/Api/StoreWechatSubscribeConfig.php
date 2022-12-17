<?php
declare(strict_types = 1);

namespace App\Model\Api;

/**
 * 微信订阅消息
 * Class StoreWechatSubscribeConfig
 * @package App\Model\Api
 */
class StoreWechatSubscribeConfig extends \App\Model\Common\StoreWechatSubscribeConfig
{
    public $searchFields = [
        'uuid',
        'title',
        'template_id',
        'file_uuid',
    ];

    protected $hidden = [
        "file_uuid",
    ];

    protected $appends = [
        'subscribe_number'// 剩余提醒次数
    ];

    public function getSubscribeNumberAttribute($key)
    {
        return 0;
    }
}