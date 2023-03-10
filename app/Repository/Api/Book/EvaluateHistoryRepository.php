<?php
declare(strict_types = 1);

namespace App\Repository\Api\Book;

use App\Model\Api\StoreBookEvaluateHistory;
use App\Repository\ApiRepositoryInterface;
use Closure;

/**
 * 教程评价
 */
class EvaluateHistoryRepository implements ApiRepositoryInterface
{

    public function repositorySelect(Closure $closure, int $perSize, array $searchFields = []): array
    {
        $items = (new StoreBookEvaluateHistory())::query()
            ->with(["user:user_uuid,nickname,avatar_url"])
            ->where($closure)
            ->where([["is_show", "=", 1]])
            ->paginate($perSize, $searchFields);

        return [
            "items" => $items->items(),
            "page" => $items->currentPage(),
            "size" => $perSize,
            "total" => $items->total(),
        ];
    }

    public function repositoryCreate(array $insertInfo): bool
    {
        $result = (new StoreBookEvaluateHistory())::query()->create($insertInfo);
        return (bool)$result->getKey();
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