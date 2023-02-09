<?php
declare(strict_types = 1);

namespace App\Repository\Api\Article;


use App\Model\Api\StoreArticleCategory;
use App\Repository\ApiRepositoryInterface;
use Closure;

/**
 * 文章分类
 * Class CategoryRepository
 * @package App\Repository\Api\Article
 */
class CategoryRepository implements ApiRepositoryInterface
{
    public function repositorySelect(Closure $closure, int $perSize, array $searchFields = []): array
    {
        if (count($searchFields) === 0) {
            $searchFields = ['uuid', 'title', 'file_uuid'];
        }
        $items = (new StoreArticleCategory)::query()
            ->with(['image:uuid,file_url as url,file_name as name,file_hash as hash'])
            ->where($closure)
            ->where([['is_show', '=', 1]])
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