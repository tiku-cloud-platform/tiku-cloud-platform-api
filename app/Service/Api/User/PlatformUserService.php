<?php
declare(strict_types = 1);

namespace App\Service\Api\User;

use App\Constants\CacheKey;
use App\Constants\CacheTime;
use App\Mapping\RedisClient;
use App\Mapping\Request\RequestApp;
use App\Mapping\Request\UserLoginInfo;
use App\Repository\Api\User\PlatformUserRepository;
use App\Service\ApiServiceInterface;
use Closure;
use Hyperf\Di\Annotation\Inject;
use function PHPUnit\Framework\exactly;

/**
 * 平台用户
 */
class PlatformUserService implements ApiServiceInterface
{
    /**
     * @Inject()
     * @var PlatformUserRepository
     */
    protected $platformUserRepository;

    /**
     * 查询条件处理
     * @param array $requestParams
     * @return Closure
     */
    public static function searchWhere(array $requestParams): Closure
    {
        return function ($query) use ($requestParams) {
            extract($requestParams);
            if (!empty($uuid)) {
                $query->where("uuid", "=", $uuid);
            }
        };
    }

    public function serviceSelect(array $requestParams): array
    {
        // TODO: Implement serviceSelect() method.
    }

    public function serviceCreate(array $requestParams): bool
    {
        // TODO: Implement serviceCreate() method.
    }

    /**
     * 更新用户主信息
     * @param array $requestParams
     * @return int
     * @throws \RedisException
     */
    public function serviceUpdate(array $requestParams): int
    {
        unset($requestParams["city"], $requestParams["hobby"], $requestParams["skills"]);
        // 查询邮箱是否存在
        if (isset($requestParams["email"])) {
            $bean = (new PlatformUserRepository())->repositoryFind(function ($query) use ($requestParams) {
                $query->whereNotIn("uuid", [UserLoginInfo::getUserId()])->where([
                    ["email", "=", $requestParams["email"]]],
                );
            });
        }
        if (empty($bean)) {
            if ($this->platformUserRepository->repositoryUpdate([
                ["store_uuid", "=", RequestApp::getStoreUuid()],
                ["uuid", "=", UserLoginInfo::getUserId()],
            ], $requestParams)) {// 更新成功之后，更新缓存信息[当前只判断是微信小程序，后续增加客户端，需要根据客户端判断来更新]
                $userInfo = RedisClient::getInstance()->get(CacheKey::MINI_LOGIN_TOKEN . UserLoginInfo::getLoginToken());
                if (!empty($userInfo)) {
                    $userInfo              = json_decode($userInfo, true);
                    $userInfo["nickname"]  = $requestParams["nickname"];
                    $userInfo["real_name"] = $requestParams["real_name"];
                    $userInfo["remark"]    = $requestParams["remark"];
                    $userInfo["gender"]    = $requestParams["gender"];
                    $userInfo["birthday"]  = $requestParams["birthday"];
                    $userInfo["email"]     = $requestParams["email"];
                    $userInfo["age"]       = $requestParams["age"];
                    RedisClient::getInstance()->set(
                        CacheKey::MINI_LOGIN_TOKEN . UserLoginInfo::getLoginToken(),
                        json_encode($userInfo, JSON_UNESCAPED_UNICODE),
                        CacheTime::USER_LOGIN_EXPIRE_TIME,
                    );
                }
                return 1;
            }
        }
        return 100;
    }

    public function serviceDelete(array $requestParams): int
    {
        // TODO: Implement serviceDelete() method.
    }

    /**
     * 获取用户信息
     * @param array $requestParams
     * @return array
     */
    public function serviceFind(array $requestParams): array
    {
        if ($requestParams["type"] === "basic") {
            return UserLoginInfo::getUserLoginInfo();// 获取用户基础信息
        } else if ($requestParams["type"] === "all") {// 获取用户全量信息
            // 格式化数据，避免一些隐私数据返回给客户端
            $bean = $this->platformUserRepository->repositoryFind(self::searchWhere(["uuid" => UserLoginInfo::getUserId()]));
            if (!empty($bean)) {
                return [
                    "birthday" => $bean["birthday"],
                    "age" => $bean["age"],
                    "email" => $bean["email"],
                    "gender" => $bean["gender"],
                    "mobile" => $bean["mobile"],
                    "real_name" => $bean["real_name"],
                    "remark" => $bean["remark"],
                    "level_title" => $bean["level"]["title"],
                    "mini_nickname" => $bean["mini"]["nickname"],
                    "mini_district" => $bean["mini"]["district"],
                    "mini_province" => $bean["mini"]["province"],
                    "mini_country" => $bean["mini"]["country"],
                    "mini_city" => $bean["mini"]["city"],
                    "mini_avatar_url" => $bean["mini"]["avatar_url"],
                ];
            }
        }
        return [];
    }
}