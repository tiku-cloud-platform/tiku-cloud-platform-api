<?php
declare(strict_types = 1);

namespace App\Repository\Api\Exam;


use App\Model\Api\StoreExamCollection;
use App\Repository\ApiRepositoryInterface;
use Closure;

/**
 * 试卷
 *
 * Class CollectionRepository
 * @package App\Repository\Api\Exam
 */
class CollectionRepository implements ApiRepositoryInterface
{

    public function repositorySelect(Closure $closure, int $perSize, array $searchFields = []): array
    {
        if (count($searchFields) === 0) {
            $searchFields = ['uuid', 'title', 'file_uuid', 'submit_number', 'author', 'exam_category_uuid', "level", "created_at"];
        }
        $items = (new StoreExamCollection)::query()
            ->with(['image:uuid,file_url as url,file_name as path,file_hash as hash'])
            ->with(['category:uuid,title'])
            ->where([['is_show', '=', 1]])
            ->where($closure)
            ->select($searchFields)
            ->orderByDesc('orders')
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
            $searchFields = ['uuid', 'title', 'file_uuid', 'submit_number', 'exam_category_uuid', 'author', 'audit_author',
                'level', 'content', 'exam_time', "created_at"];
        }
        $bean = (new StoreExamCollection)::query()
            ->with(['image:uuid,file_url as url,file_name as path,file_hash as hash'])
            ->with(['category:uuid,title'])
            ->where([['is_show', '=', 1]])
            ->where($closure)
            ->first($searchFields);

        return !empty($bean) ? $bean->toArray() : [];
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

    public function repositoryIncrField(array $incrWhere, string $field = 'submit_number', int $incrValue = 1)
    {
        return (new StoreExamCollection)::query()->where($incrWhere)->increment($field, $incrValue);
    }
}