<?php
declare(strict_types = 1);

namespace App\Repository\Api\Sign;

use App\Model\Api\StoreUserSignCollection;
use App\Repository\ApiRepositoryInterface;
use Closure;

/**
 * 签到账户
 */
class CollectionRepository implements ApiRepositoryInterface
{

    public function repositorySelect(Closure $closure, int $perSize, array $searchFields = []): array
    {
        return [];
    }

    public function repositoryCreate(array $insertInfo): bool
    {
        if ((new StoreUserSignCollection())::query()->create($insertInfo)) {
            return true;
        }
        return false;
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