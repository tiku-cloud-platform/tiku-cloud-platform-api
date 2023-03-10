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

    /**
     * 评分汇总
     * @param string $uuid 教程id
     * @return array
     */
    public function repositoryCollection(string $uuid): array
    {
        // 平均评分
        $totalScore = (new StoreBookEvaluateHistory())::query()->where([["book_uuid", "=", $uuid]])->sum("score");
        $count      = (new StoreBookEvaluateHistory())::query()->where([["book_uuid", "=", $uuid]])->count();
        $avgScore   = 0.00;
        if (!empty($count)) {
            $avgScore = number_format($totalScore / $count, 2);
        }
        // 不行评分
        $third = (new StoreBookEvaluateHistory())::query()->where([["book_uuid", "=", $uuid]])
            ->where("score", ">=", "0.00")
            ->where("score", "<=", "3.00")
            ->count();
        // 一般评分
        $second = (new StoreBookEvaluateHistory())::query()->where([["book_uuid", "=", $uuid]])
            ->where("score", ">", "3.00")
            ->where("score", "<=", "6.00")
            ->count();
        // 好看评分
        $firstScore = (new StoreBookEvaluateHistory())::query()->where([["book_uuid", "=", $uuid]])
            ->where("score", ">", "6.00")
            ->where("score", "<=", "10.00")
            ->count();

        return [
            "first" => $firstScore,
            "second" => $second,
            "third" => $third,
            "avg" => $avgScore,
            "count" => (new StoreBookEvaluateHistory())::query()->distinct()->where([["book_uuid", "=", $uuid]])
                ->groupBy(["user_uuid"])
                ->count("user_uuid")
        ];
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