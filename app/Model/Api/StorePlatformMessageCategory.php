<?php
declare(strict_types = 1);

namespace App\Model\Api;


use App\Mapping\UserInfo;

/**
 * 平台消息类型
 *
 * Class PlatformMessageCategory
 * @package App\Model\Api
 */
class StorePlatformMessageCategory extends \App\Model\Common\StorePlatformMessageCategory
{
    protected $appends = [
        'message_number'
    ];

    /**
     * 消息未阅读数
     *
     * @return int
     */
    public function getMessageNumberAttribute()
    {
        $userInfo = UserInfo::getWeChatUserInfo();

        $items = StorePlatformMessageContent::query()
            ->where('platform_message_category_uuid', '=', $this->attributes['uuid'])
            ->get(['uuid']);
        if (!empty($items)) {
            $contentIdArray = array_column($items->toArray(), 'uuid');
            $readNumber     = StorePlatformMessageHistory::query()
                ->where(function ($query) use ($userInfo) {
                    if (!empty($userInfo)) {
                        $query->where('user_uuid', '=', $userInfo['user_uuid']);
                    }
                })
                ->whereIn('platform_message_content_uuid', $contentIdArray)
                ->count('id');

            return count($contentIdArray) - $readNumber;
        }

        return 0;
    }
}