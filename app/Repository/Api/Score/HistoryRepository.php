<?php
declare(strict_types = 1);

namespace App\Repository\Api\Score;

use App\Model\Api\StoreUserScoreHistory;
use App\Repository\ApiRepositoryInterface;
use Closure;

/**
 * 积分历史
 */
class HistoryRepository implements ApiRepositoryInterface
{

    public function repositorySelect(Closure $closure, int $perSize, array $searchFields = []): array
    {
        if (count($searchFields)) {
            $searchFields = ["title", "type", "score", "created_at as time"];
        }
        $items = (new StoreUserScoreHistory())::query()
            ->where($closure)
            ->where([["is_show", "=", 1]])
            ->orderByDesc("id")
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