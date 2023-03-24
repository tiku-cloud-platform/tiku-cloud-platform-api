<?php
declare(strict_types = 1);

namespace App\Repository\Api\Book;

use App\Model\Api\StoreBookCate;
use App\Repository\ApiRepositoryInterface;
use Closure;

/**
 * 教程分类
 */
class CateRepository implements ApiRepositoryInterface
{

    public function repositoryAll(Closure $closure, int $perSize, array $searchFields = []): array
    {
        if (count($searchFields) == 0) {
            return [];
        }
        return (new StoreBookCate())::query()->where($closure)->where([
            ["is_show", "=", 1]
        ])->orderByDesc("orders")->limit($perSize)->get($searchFields)->toArray();
    }

    public function repositorySelect(Closure $closure, int $perSize, array $searchFields = []): array
    {
        // TODO: Implement repositorySelect() method.
    }

    public function repositoryCreate(array $insertInfo): bool
    {
        // TODO: Implement repositoryCreate() method.
    }

    public function repositoryAdd(array $addInfo): int
    {
        // TODO: Implement repositoryAdd() method.
    }

    public function repositoryFind(Closure $closure, array $searchFields = []): array
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