<?php
declare(strict_types = 1);

namespace App\Mapping\Request;

use Hyperf\Utils\Context;

/**
 * 用户登录信息
 */
class UserLoginInfo
{
    /**
     * 获取用户信息
     * @return array
     */
    public static function getUserLoginInfo(): array
    {
        return json_decode(Context::get("mini:login:info"), true);
    }

    /**
     * 获取用户id
     * @return string
     */
    public static function getUserId(): string
    {
        return (string)json_decode(Context::get("mini:login:info"), true)["user_uuid"];
    }
}