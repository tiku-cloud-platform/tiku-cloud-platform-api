<?php
declare(strict_types = 1);

namespace App\Service\Api\User;

use App\Constants\CacheKey;
use App\Library\WeChat\WeChatMiNi;
use App\Mapping\RedisClient;
use App\Mapping\UUID;
use App\Repository\Api\User\WeChatApiRepository;
use App\Service\ApiServiceInterface;
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
     * @param string $code
     * @return array[1 => "登录成功", 2 => "登录失败", 3 => "用户被禁用"]
     * @throws InvalidConfigException|RedisException
     */
    public function serviceMiNiCodeAuth(array $requestParams): array
    {
        $jsonCode = WeChatMiNi::getInstance()->auth->session($requestParams["code"]);
        $userInfo = $this->miniUserRepository->repositoryFind(function ($query) use ($jsonCode) {
            $query->where("openid", "=", $jsonCode["openid"]);
        });
        $userId   = UUID::getUUID();
        // 不存在则创建（提前生成用户uuid，当返回值为true时，表示用户创建成功，则把改uuid插入队列，方便队列对该用户增加额外的业务操作）。
        if (empty($userInfo)) {
            $insertUser = $this->miniUserRepository->repositoryCreate([
                "openid" => $jsonCode["openid"],
                "user_uuid" => $userId,
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
        $loginToken  = UUID::getUUID();
        $cacheResult = $this->setLoginCache(CacheKey::MINI_LOGIN_TOKEN . $loginToken, $userInfo);
        if ($cacheResult) {
            return array_merge([
                "user_uuid" => $userId,
                "avatar_url" => $userInfo["avatar_url"],
                "nickname" => $userInfo["nickname"],
                "gender" => $userInfo["gender"],
                "level_title" => "普通会员",
                "level_uuid" => "xxxxxx",
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
        $cacheResult = RedisClient::getInstance()->set(CacheKey::MINI_LOGIN_TOKEN . $loginToken,
            json_encode($userInfo, JSON_UNESCAPED_UNICODE), 86400 * 10);
        if (is_bool($cacheResult)) {
            return true;
        }
        return false;
    }

    public static function searchWhere(array $requestParams)
    {
        // TODO: Implement searchWhere() method.
    }

    public function serviceSelect(array $requestParams): array
    {
        // TODO: Implement serviceSelect() method.
    }

    public function serviceCreate(array $requestParams): bool
    {
        // TODO: Implement serviceCreate() method.
    }

    public function serviceUpdate(array $requestParams): int
    {
        // TODO: Implement serviceUpdate() method.
    }

    public function serviceDelete(array $requestParams): int
    {
        // TODO: Implement serviceDelete() method.
    }

    public function serviceFind(array $requestParams): array
    {
        // TODO: Implement serviceFind() method.
    }
}