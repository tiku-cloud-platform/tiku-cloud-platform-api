<?php
declare(strict_types = 1);

namespace App\Repository\Api\User;

use App\Model\Api\StoreMiniUserDevice;
use App\Repository\ApiRepositoryInterface;
use Closure;
use Hyperf\Di\Annotation\Inject;
use Throwable;

/**
 * 微信注册设备信息
 */
class MiniUserDeviceRepository implements ApiRepositoryInterface
{
    public function repositorySelect(Closure $closure, int $perSize, array $searchFields = []): array
    {
        return [];
    }

    public function repositoryCreate(array $insertInfo): bool
    {
        try {
            $newModel = (new StoreMiniUserDevice)::query()->create($insertInfo);
            return !empty($newModel->getKey());
        } catch (Throwable $throwable) {
            return false;
        }
    }

    public function repositoryAdd(array $addInfo): int
    {
        return 0;
    }

    public function repositoryFind(Closure $closure, array $searchFields = []): array
    {
        return [];
    }

    public function repositoryUpdate(array $updateWhere, array $updateInfo): int
    {
        return 0;
    }

    public function repositoryDelete(array $deleteWhere): int
    {
        return 0;
    }

    public function repositoryWhereInDelete(array $deleteWhere, string $field): int
    {
        return 0;
    }
}