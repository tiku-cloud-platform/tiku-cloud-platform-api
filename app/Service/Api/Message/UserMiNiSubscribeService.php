<?php

namespace App\Service\Api\Message;

use App\Mapping\Request\RequestApp;
use App\Mapping\Request\UserLoginInfo;
use App\Mapping\UUID;
use App\Repository\Api\Message\UserMiNiSubscribeRepository;
use App\Service\ApiServiceInterface;
use Closure;
use Hyperf\Di\Annotation\Inject;

/**
 * 用户订阅微信小程序模板信息
 */
class UserMiNiSubscribeService implements ApiServiceInterface
{
    /**
     * @Inject()
     * @var UserMiNiSubscribeRepository
     */
    protected $subscribeRepository;

    public static function searchWhere(array $requestParams): Closure
    {
        // TODO: Implement searchWhere() method.
    }

    public function serviceSelect(array $requestParams): array
    {
        // TODO: Implement serviceSelect() method.
    }

    /**
     * 创建微信小程序订阅消息
     * @param array $requestParams
     * @return bool
     */
    public function serviceCreate(array $requestParams): bool
    {
        return $this->subscribeRepository->repositoryCreate([
            'uuid' => UUID::getUUID(),
            'store_uuid' => RequestApp::getStoreUuid(),
            'user_uuid' => UserLoginInfo::getUserId(),
            'template_config_uuid' => $requestParams["template_uuid"],
        ]);
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