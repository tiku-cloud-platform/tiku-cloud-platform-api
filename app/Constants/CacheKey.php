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

    /**
     * @Message("请先登录")
     */
    const MINI_NO_LOGIN = "min:not_login:msg";

    /**
     * @Message("用户签到")
     */
    const USER_SIGN = "user:sign:";

    /**
     * @Message("用户签到总数")
     */
    const USER_SIGN_TOTAL = "user:sign:total:";

    /**
     * @Message("签到天数配置")
     */
    const  SIGN_CONFIG = "sign_config:";

    /**
     * @Message("用户积分总数")
     */
    const SCORE_TOTAL = "score:total:";

    /**
     * @Message("文章阅读队列")
     */
    const ARTICLE_QUEUE = "article_queue";

    /**
     * @Message("签到积分队列")
     */
    const SIGN_QUEUE = "sign_queue";

    /**
     * @Message("问答试题队列")
     */
    const EXAM_READING = "exam_reading_queue";

    /**
     * @Message("用户注册队列")
     */
    const  USER_REGISTER = "user_register";

    const CLOUD_PLATFORM_FILE_TOKEN = "cloud_platform_file_token:";
}
