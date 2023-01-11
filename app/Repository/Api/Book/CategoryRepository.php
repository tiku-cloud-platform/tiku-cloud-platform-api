<?php
declare(strict_types = 1);

namespace App\Repository\Api\Book;

use App\Model\Api\StoreBookCategory;
use App\Repository\ApiRepositoryInterface;
use Closure;

class CategoryRepository implements ApiRepositoryInterface
{
    public function repositoryAllSelect(Closure $closure): array
    {
        $items = (new StoreBookCategory())::query()
            ->where([
                ["parent_uuid", "=", ""],
                ["is_show", "=", 1]
            ])
            ->where($closure)->get(["uuid", "title"]);
        if (!empty($items)) return $items->toArray();
        return [];
    }

    public function repositorySelect(Closure $closure, int $perSize): array
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

    public function repositoryFind(Closure $closure): array
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