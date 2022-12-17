<?php
declare(strict_types = 1);

namespace App\Constants;

use Hyperf\Constants\AbstractConstants;
use Hyperf\Constants\Annotation\Constants;

/**
 * 缓存key配置.
 *
 * @Constants
 * Class LoginToken
 */
class CacheKey extends AbstractConstants
{
    /**
     * @Message("微信小程序用户积分排行")
     */
    const WECHAT_RANK_SCORE = 'wechat_rank_score:';


    // 新版配置key

    /**
     * @Message("商户开发配置")
     */
    const STORE_DEVEL_CONFIG = "dev:";

    /**
     * @Message("微信小程序配置")
     */
    const STORE_MINI_SETTING = "mini:";

    /**
     * @Message("公众号配置")
     */
    const STORE_OFFICE_SETTING = "office:";

    /**
     * @Message("小程序登录token")
     */
    const MINI_LOGIN_TOKEN = "mini:login:";
}
