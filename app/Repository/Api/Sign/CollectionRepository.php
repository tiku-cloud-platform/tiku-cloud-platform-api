<?php
declare(strict_types = 1);

namespace App\Repository\Api\Sign;

use App\Model\Api\StoreUserSignCollection;
use App\Repository\ApiRepositoryInterface;

/**
 * 签到账户
 */
class CollectionRepository implements ApiRepositoryInterface
{

    public function repositorySelect(\Closure $closure, int $perSize): array
    {
        // TODO: Implement repositorySelect() method.
    }

    public function repositoryCreate(array $insertInfo): bool
    {
        if ((new StoreUserSignCollection())::query()->created($insertInfo)) {
            return true;
        }
        return false;
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