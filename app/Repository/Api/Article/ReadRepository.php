<?php
declare(strict_types = 1);

namespace App\Repository\Api\Article;

use App\Model\Api\StoreArticleRead;
use App\Repository\ApiRepositoryInterface;
use Closure;
use Throwable;

/**
 * 阅读历史
 */
class ReadRepository implements ApiRepositoryInterface
{
    public function repositorySelect(Closure $closure, int $perSize, array $searchFields = []): array
    {
        return [];
    }

    public function repositoryCreate(array $insertInfo): bool
    {
        try {
            if ((new StoreArticleRead())::query()->create($insertInfo)) return true;
            return false;
        } catch (Throwable $throwable) {

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