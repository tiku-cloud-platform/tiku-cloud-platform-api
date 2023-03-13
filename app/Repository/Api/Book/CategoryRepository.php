<?php
declare(strict_types = 1);

namespace App\Repository\Api\Book;

use App\Model\Api\StoreBookCategory;
use App\Repository\ApiRepositoryInterface;
use Closure;

class CategoryRepository implements ApiRepositoryInterface
{
    public function repositoryAllSelect(Closure $closure, array $searchFields = []): array
    {
        if (count($searchFields) === 0) {
            $searchFields = ["uuid", "title"];
        }
        $items = (new StoreBookCategory())::query()
            ->where([
                ["is_show", "=", 1]
            ])
            ->whereNull("parent_uuid")
            ->where($closure)->get($searchFields);
        if (!empty($items)) return $items->toArray();
        return [];
    }

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