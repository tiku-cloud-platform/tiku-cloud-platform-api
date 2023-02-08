<?php
declare(strict_types = 1);

namespace App\Repository\Api\Exam;

use App\Model\Api\StoreExamCategory;
use App\Repository\ApiRepositoryInterface;
use Closure;

/**
 * 试题分类
 * Class CategoryRepository
 * @package App\Repository\Api\Exam
 */
class CategoryRepository implements ApiRepositoryInterface
{
    public function repositorySelect(Closure $closure, int $perSize, array $searchFields = []): array
    {
        if (count($searchFields) === 0) {
            $searchFields = ['uuid', 'title', 'file_uuid', 'big_file_uuid', 'parent_uuid',];
        }
        $items = (new StoreExamCategory)::query()
            ->with(['smallImage:uuid,file_name as name,file_url as url,file_hash as hash'])
            ->with(['bigImage:uuid,file_name as name,file_url as url,file_hash as hash'])
            ->where($closure)
            ->where('is_show', '=', 1)
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