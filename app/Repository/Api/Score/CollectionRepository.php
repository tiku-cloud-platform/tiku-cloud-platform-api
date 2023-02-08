<?php
declare(strict_types = 1);

namespace App\Repository\Api\Score;

use App\Model\Api\StoreUserScoreCollection;
use App\Repository\ApiRepositoryInterface;
use Closure;

/**
 * 积分汇总
 */
class CollectionRepository implements ApiRepositoryInterface
{

    public function repositorySelect(Closure $closure, int $perSize, array $searchFields = []): array
    {
        return [];
    }

    public function repositoryCreate(array $insertInfo): bool
    {
        return false;
    }

    public function repositoryAdd(array $addInfo): int
    {
        return 0;
    }

    public function repositoryFind(Closure $closure, array $searchFields = []): array
    {
        if (count($searchFields)) {
            $searchFields = ["score"];
        }
        $bean = (new StoreUserScoreCollection())::query()->where($closure)->first($searchFields);
        return !empty($bean) ? $bean->toArray() : [];
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