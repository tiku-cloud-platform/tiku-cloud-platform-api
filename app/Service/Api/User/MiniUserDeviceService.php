<?php
declare(strict_types = 1);

namespace App\Service\Api\User;

use App\Repository\Api\User\MiniUserDeviceRepository;
use App\Service\ApiServiceInterface;
use Hyperf\Di\Annotation\Inject;

/**
 * 微信注册设备信息
 */
class MiniUserDeviceService implements ApiServiceInterface
{
    /**
     * @Inject()
     * @var MiniUserDeviceRepository
     */
    protected $userDeviceRepository;

    public static function searchWhere(array $requestParams)
    {
        // TODO: Implement searchWhere() method.
    }

    public function serviceSelect(array $requestParams): array
    {
        // TODO: Implement serviceSelect() method.
    }

    /**
     * 记录注册设备信息
     * @param array $requestParams
     * @return bool
     */
    public function serviceCreate(array $requestParams): bool
    {
        return $this->userDeviceRepository->repositoryCreate($requestParams);
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