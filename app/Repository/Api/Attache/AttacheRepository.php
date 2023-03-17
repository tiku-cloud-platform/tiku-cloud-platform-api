<?php
declare(strict_types = 1);

namespace App\Repository\Api\Attache;

use App\Model\Api\StoreAttache;
use App\Repository\ApiRepositoryInterface;
use Closure;

/**
 * 附件管理
 */
class AttacheRepository implements ApiRepositoryInterface
{

    public function repositorySelect(Closure $closure, int $perSize, array $searchFields = []): array
    {
        if (count($searchFields) == 0) {
            return [];
        }
        $items = (new StoreAttache())::query()
            ->with(["cover:uuid,file_url,file_name"])
            ->where($closure)
            ->orderByDesc("orders")
            ->orderByDesc("id")
            ->paginate($perSize, $searchFields);

        return [
            "items" => $items->items(),
            "page" => $items->currentPage(),
            "size" => $items->perPage(),
            "total" => $items->total()
        ];
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
        if (count($searchFields) == 0) {
            return [];
        }
        $bean = (new StoreAttache())::query()
            ->where($closure)
            ->first($searchFields);

        return !empty($bean) ? $bean->toArray() : [];
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