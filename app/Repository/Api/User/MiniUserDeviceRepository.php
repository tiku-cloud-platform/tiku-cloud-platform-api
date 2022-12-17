<?php
declare(strict_types = 1);

namespace App\Repository\Api\User;

use App\Model\Api\StoreMiniUserDevice;
use App\Repository\ApiRepositoryInterface;
use Hyperf\Di\Annotation\Inject;
use Throwable;

/**
 * 微信注册设备信息
 */
class MiniUserDeviceRepository implements ApiRepositoryInterface
{
    /**
     * @Inject()
     * @var StoreMiniUserDevice
     */
    protected $deviceModel;

    public function repositorySelect(\Closure $closure, int $perSize): array
    {
        // TODO: Implement repositorySelect() method.
    }

    /**
     * 记录注册设备信息
     * @param array $insertInfo
     * @return bool
     */
    public function repositoryCreate(array $insertInfo): bool
    {
        try {
            $newModel = $this->deviceModel::query()->create($insertInfo);
            return !empty($newModel->getKey());
        } catch (Throwable $throwable) {
            return false;
        }
    }

    public function repositoryAdd(array $addInfo): int
    {
        // TODO: Implement repositoryAdd() method.
    }

    public function repositoryFind(\Closure $closure): array
    {
        // TODO: Implement repositoryFind() method.
    }

    public function repositoryUpdate(array $updateWhere, array $updateInfo): int
    {
        // TODO: Implement repositoryUpdate() method.
    }

    public function repositoryDelete(array $deleteWhere): int
    {
        // TODO: Implement repositoryDelete() method.
    }

    public function repositoryWhereInDelete(array $deleteWhere, string $field): int
    {
        // TODO: Implement repositoryWhereInDelete() method.
    }
}