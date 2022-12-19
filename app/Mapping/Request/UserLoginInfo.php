<?php
declare(strict_types = 1);

namespace App\Mapping\Request;

use Hyperf\Utils\Context;

/**
 * 全局用户登录信息
 * 在用户鉴权中间件中，不管是什么客户端，都使用相同的key实现set操作。
 * 在用户登录操作，不管是什么客户端，都使用相同的字段进行缓存。每一种客户端使用不同的缓存前缀。
 */
class UserLoginInfo
{
    /**
     * 获取用户信息
     * @return array
     */
    public static function getUserLoginInfo(): array
    {
        return json_decode(Context::get("login:info"), true);
    }

    /**
     * 获取用户id
     * @return string
     */
    public static function getUserId(): string
    {
        return (string)json_decode(Context::get("login:info"), true)["user_uuid"];
    }
}