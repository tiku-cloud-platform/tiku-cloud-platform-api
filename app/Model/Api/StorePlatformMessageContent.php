<?php
declare(strict_types = 1);

namespace App\Model\Api;


use App\Mapping\UserInfo;

/**
 * 平台消息内容
 *
 * Class StorePlatformMessageContent
 * @package App\Model\Api
 */
class StorePlatformMessageContent extends \App\Model\Common\StorePlatformMessageContent
{
    protected $appends = [
        'is_read'
    ];

    public function getCreatedAtAttribute($key)
    {
        return date('Y-m-d', strtotime($key));
    }

    // 对应消息是否阅读
    public function getIsReadAttribute($key)
    {
        if (StorePlatformMessageHistory::query()
            ->where([
                ['platform_message_content_uuid', '=', $this->attributes['uuid']],
                ['user_uuid', '=', UserInfo::getWeChatUserInfo()['user_uuid']]
            ])
            ->first(['uuid'])) {
            return 1;
        }

        return 0;
    }
}