<?php
declare(strict_types = 1);

namespace App\Constants;

use Hyperf\Constants\AbstractConstants;
use Hyperf\Constants\Annotation\Constants;

/**
 * @Constants
 */
class ErrorCode extends AbstractConstants
{
    /**
     * @Message("请求成功")
     */
    const REQUEST_SUCCESS = 1000;

    /**
     * @Message("请求失败")
     */
    const REQUEST_ERROR = 1001;

    /**
     * @Message("请先进行登录")
     */
    const REQUEST_INVALID = -1;
}
