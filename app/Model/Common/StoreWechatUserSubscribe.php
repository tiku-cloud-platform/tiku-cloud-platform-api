<?php
declare(strict_types = 1);

namespace App\Model\Common;

use App\Model\BaseModel;

/**
 * 微信小程序模板消息订阅记录
 * Class StoreWechatUserSubscribe
 * @package App\Model\Common
 */
class StoreWechatUserSubscribe extends BaseModel
{
    protected $table = 'store_user_mini_subscribe';

    protected $fillable = [
        'uuid',
        'store_uuid',
        'user_uuid',
        'template_config_uuid',
    ];
}