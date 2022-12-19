<?php
declare(strict_types = 1);

namespace App\Constants;

use Hyperf\Constants\Annotation\Constants;

/**
 *  缓存时长配置.
 *
 * @Constants
 * Class CacheTime
 */
class CacheTime extends Constants
{
    /**
     * @Message("用户端登录token前缀")
     */
    const USER_LOGIN_EXPIRE_TIME = 864000;

    /**
     * @Message("商户端系统配置")
     */
    const STORE_PLATFORM_SETTING_EXPIRE_TIME = 864000;
}
