<?php
declare(strict_types = 1);

namespace App\Model\Api;

use Hyperf\Database\Model\Relations\BelongsTo;

/**
 * 微信小程序用户
 *
 * Class StoreMiNiWeChatUser
 * @package App\Model\Api
 */
class StoreMiNiWeChatUser extends \App\Model\Common\StoreMiNiWeChatUser
{
    /**
     * 主账号
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(StorePlatformUser::class, 'user_uuid', 'uuid');
    }
}