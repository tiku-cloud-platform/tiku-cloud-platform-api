<?php
declare(strict_types = 1);

namespace App\Repository\Api\Exam;

use App\Model\Api\StoreExamReading;
use App\Repository\ApiRepositoryInterface;
use Closure;

/**
 * 问答试题
 * Class ReadingRepository
 * @package App\Repository\Api\Exam
 */
class ReadingRepository implements ApiRepositoryInterface
{
    public function repositorySelect(Closure $closure, int $perSize, array $searchFields = []): array
    {
        if (count($searchFields) === 0) {
            $searchFields = ["uuid", "title"];
        }
        $items = (new StoreExamReading)::query()
            ->whereHas('relationCollection', $closure)
            ->where([['is_show', '=', 1]])
            ->select($searchFields)
            ->paginate($perSize);

        return [
            'items' => $items->items(),
            'total' => $items->total(),
            'size' => $items->perPage(),
            'page' => $items->currentPage(),
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
        if (count($searchFields) === 0) {
            $searchFields = ['uuid', 'title', 'content', "tips_expend_score as expend_score",
                "answer_income_score as income_score", "analysis", "level", "source_url",
                "source_author", "video_url", "created_at as publish_date", "read_number"
            ];
        }
        $bean = (new StoreExamReading)::query()
            ->where($closure)
            ->where([['is_show', '=', 1]])
            ->first($searchFields);
        if (!empty($bean)) return $bean->toArray();
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