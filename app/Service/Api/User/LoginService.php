<?php
declare(strict_types = 1);

namespace App\Service\Api\User;

use App\Constants\CacheKey;
use App\Constants\CacheTime;
use App\Library\WeChat\WeChatMiNi;
use App\Mapping\RedisClient;
use App\Mapping\Request\RequestApp;
use App\Mapping\UUID;
use App\Repository\Api\User\WeChatApiRepository;
use App\Service\ApiServiceInterface;
use Closure;
use EasyWeChat\Kernel\Exceptions\InvalidConfigException;
use Hyperf\Di\Annotation\Inject;
use RedisException;

/**
 * 用户登录
 */
class LoginService implements ApiServiceInterface
{
    /**
     * @Inject()
     * @var WeChatApiRepository
     */
    protected $miniUserRepository;

    /**
     * 微信code授权
     * @param array $requestParams
     * @return array[1 => "登录成功", 2 => "登录失败", 3 => "用户被禁用"]
     * @throws InvalidConfigException
     * @throws RedisException
     */
    public function serviceMiNiCodeAuth(array $requestParams): array
    {
        $jsonCode = WeChatMiNi::getInstance()->auth->session($requestParams["code"]);
        if (!empty($jsonCode["errcode"])) {
            return ["code" => 100];
        }
        $userInfo = $this->miniUserRepository->repositoryFind(function ($query) use ($jsonCode) {
            $query->where("openid", "=", $jsonCode["openid"]);
        });
        $userId   = UUID::getUUID();
        // 不存在则创建（提前生成用户uuid，当返回值为true时，表示用户创建成功，则把改uuid插入队列，方便队列对该用户增加额外的业务操作）。
        $userGrade = [];
        if (empty($userInfo)) {
            // 查询最会员等级
            $userGrade  = (new GradeService())->serviceFind([]);
            $insertUser = $this->miniUserRepository->repositoryCreate([
                "openid" => $jsonCode["openid"],
                "user_uuid" => $userId,
                "grade_uuid" => isset($userGrade["uuid"]) ? $userGrade["uuid"] : "",
                "device" => $requestParams["device"] ?? [],
            ]);
            if ($insertUser) {
                $userInfo = $this->miniUserRepository->repositoryFind(function ($query) use ($jsonCode) {
                    $query->where("openid", "=", $jsonCode["openid"]);
                });
                if (empty($userInfo)) {
                    return ["code" => 2];
                }
            }
        }
        if ($userInfo["is_forbidden"] === 1) {
            return ["code" => 3];
        }
        $loginToken  = md5(UUID::getUUID());
        $cacheResult = $this->setLoginCache(CacheKey::MINI_LOGIN_TOKEN . $loginToken, [
            "avatar_url" => $userInfo["avatar_url"],
            "nickname" => $userInfo["nickname"],
            "real_name" => $userInfo["user"]["real_name"],
            "gender" => $userInfo["gender"],
            "age" => $userInfo["user"]["age"],
            "mobile" => $userInfo["user"]["mobile"],
            "email" => $userInfo["user"]["email"],
            "birthday" => $userInfo["user"]["birthday"],
            "remark" => $userInfo["user"]["remark"],
            "user_uuid" => $userInfo["user"]["uuid"],
            "store_uuid" => $userInfo["store_uuid"],
            "user_agent" => $requestParams["user_agent"],
        ]);
        RedisClient::getInstance()->lPush(CacheKey::USER_REGISTER, json_encode([
            "store_uuid" => RequestApp::getStoreUuid(),
            "user_uuid" => $userId
        ], JSON_UNESCAPED_UNICODE));
        if ($cacheResult) {
            return array_merge([
                "avatar_url" => $userInfo["avatar_url"],
                "nickname" => $userInfo["nickname"],
                "real_name" => $userInfo["user"]["real_name"],
                "gender" => $userInfo["gender"],
                "birthday" => $userInfo["user"]["birthday"],
                "remark" => $userInfo["user"]["remark"],
                "user_uuid" => $userInfo["user"]["uuid"],
                "level_title" => isset($userGrade["uuid"]) ? $userGrade["title"] : "普通会员",
            ], ["code" => 1, "login_token" => $loginToken]);
        }
        return ["code" => 2];
    }

    /**
     * 设置用户登录信息
     * @param string $loginToken
     * @param array $userInfo
     * @return bool
     * @throws RedisException
     */
    private function setLoginCache(string $loginToken, array $userInfo): bool
    {
        $cacheResult = RedisClient::getInstance()->set($loginToken,
            json_encode($userInfo, JSON_UNESCAPED_UNICODE), CacheTime::USER_LOGIN_EXPIRE_TIME);
        if (is_bool($cacheResult)) {
            return true;
        }
        return false;
    }

    public static function searchWhere(array $requestParams): Closure
    {
        return function () {
        };
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