<?php
declare(strict_types = 1);

namespace App\Repository\Api\Exam;


use App\Model\Api\StoreExamOption;
use App\Repository\ApiRepositoryInterface;
use Closure;

/**
 * 选择试题
 * Class OptionRepository
 * @package App\Repository\Api\Exam
 */
class OptionRepository implements ApiRepositoryInterface
{
    public function repositorySelect(Closure $closure, int $perSize, array $searchFields = []): array
    {
        if (count($searchFields) === 0) {
            $searchFields = ['uuid', 'title', 'answer', 'analysis', 'level',];
        }
        $items = (new StoreExamOption)::query()
            ->with(['items:uuid,title,option_uuid,check,is_check'])
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

    public function repositoryWhereId(string $field, array $searchWhere): array
    {
        $items = (new StoreExamOption)::query()->whereIn($field, $searchWhere)->get(['answer', 'answer_income_score', 'uuid', 'store_uuid']);
        if (!empty($items)) return $items->toArray();
        return [];
    }
}