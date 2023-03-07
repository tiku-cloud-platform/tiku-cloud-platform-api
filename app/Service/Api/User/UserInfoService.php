<?php
declare(strict_types = 1);

namespace App\Service\Api\User;

use App\Library\WeChat\WeChatMiNi;
use App\Service\ApiServiceInterface;
use Closure;
use EasyWeChat\Kernel\Exceptions\InvalidConfigException;
use GuzzleHttp\Exception\GuzzleException;

/**
 * 用户信息操作
 */
class UserInfoService implements ApiServiceInterface
{

    public static function searchWhere(array $requestParams): Closure
    {
        return function ($query) use ($requestParams) {
            extract($requestParams);
        };
    }

    /**
     * 绑定微信手机号
     * @param array $requestParams
     * @return array ["code" => 1, "msg" => "绑定成功", "code" => 2, "msg"=> "异常错误", "code" => 3, "msg" => "微信错误信息"]
     * @throws GuzzleException
     * @throws InvalidConfigException
     */
    public function bindPhone(array $requestParams): array
    {
        $response = WeChatMiNi::getInstance()->phone_number->getUserPhoneNumber(trim($requestParams["code"]));
        if (isset($response["errcode"]) && $response["errcode"] == 0) {
            $phone = $response["phone_info"]["phoneNumber"];
            return ["code" => 1, "msg" => "绑定成功", "data" => $phone];
        }
        if (isset($response["errcode"]) && $response["errcode"] != 0) {
            return ["code" => 3, "msg" => $response["errmsg"], "data" => ""];
        }
        return ["code" => 2, "msg" => "绑定失败 请重试"];
    }

    public function serviceSelect(array $requestParams): array
    {
        return [];
    }

    public function serviceCreate(array $requestParams): bool
    {
        return false;
    }

    public function serviceUpdate(array $requestParams): int
    {
        return 0;
    }

    public function serviceDelete(array $requestParams): int
    {
        return 0;
    }

    public function serviceFind(array $requestParams): array
    {
        return [];
    }
}