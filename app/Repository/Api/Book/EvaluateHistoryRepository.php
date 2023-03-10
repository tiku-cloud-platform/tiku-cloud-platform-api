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
        $model = (new StoreBookEvaluateHistory())::query();
        // 平均评分
        $totalScore = $model->where([["book_uuid", "=", $uuid]])->sum("score");
        $count      = $model->where([["book_uuid", "=", $uuid]])->groupBy(["user_uuid"])->count();
        $avgScore   = 0.00;
        if (!empty($count)) {
            $avgScore = number_format($totalScore / $count, 2);
        }
        // 好看评分
        $firstScore = $model->where([["book_uuid", "=", $uuid]])->whereBetween("score", [0.00, 3.00])->count();
        // 一般评分
        $second = $model->where([["book_uuid", "=", $uuid]])->whereBetween("score", [3.01, 6.00])->count();
        // 不行评分
        $third = $model->where([["book_uuid", "=", $uuid]])->whereBetween("score", [6.01, 10.00])->count();

        return [
            "avg_score" => $avgScore,
            "first" => $firstScore,
            "second" => $second,
            "third" => $third,
            "avg" => $avgScore,
            "count" => $count,
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