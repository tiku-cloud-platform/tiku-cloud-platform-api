<?php
declare(strict_types=1);

namespace App\Service\Api\User;

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
     */
    public function serviceUpdate(array $requestParams): int
    {
       return $this->platformUserRepository->repositoryUpdate([
            ["store_uuid", "=", RequestApp::getStoreUuid()],
            ["user_uuid", "=", UserLoginInfo::getUserId()],
        ],$requestParams);
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
            return $this->platformUserRepository->repositoryFind(self::searchWhere(["uuid" => UserLoginInfo::getUserId()]));
        }
        return [];
    }
}