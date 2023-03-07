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
        return Context::get("login:info");
    }

    /**
     * 判断当前用户的登录信息
     * 如果未空，则表示未登录状态
     * 如果存在值，则表示处于登录状态
     * @return array
     */
    public function checkoutUserLoginInfo(): array
    {
        $cacheInfo = Context::get("login:info");
        if (!empty($cacheInfo)) {
            return Context::get("login:info");
        }
        return [];
    }

    /**
     * 获取用户id
     * @return string
     */
    public static function getUserId(): string
    {
        if (!empty(Context::get("login:info"))) {
            return Context::get("login:info")["user_uuid"];
        }
        return "";
    }

    /**
     * 获取登录缓存token
     * @return string
     */
    public static function getLoginToken(): string
    {
        if (!empty(Context::get("login:info"))) {
            return Context::get("login:info")["login_token"];
        }
        return "";
    }
}