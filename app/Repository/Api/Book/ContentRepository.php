<?php
declare(strict_types = 1);

namespace App\Repository\Api\Book;

use App\Model\Api\StoreBookContent;
use App\Repository\ApiRepositoryInterface;
use Closure;

/**
 * 书籍内容管理
 */
class ContentRepository implements ApiRepositoryInterface
{
    /**
     * 文章目录
     * @param Closure $closure
     * @param int $perSize
     * @return array
     */
    public function repositoryCatalog(Closure $closure, int $perSize): array
    {
        $items = StoreBookContent::query()->where($closure)
            ->select(["title", "uuid"])
            ->where([["is_show", "=", 1]])
            ->orderByDesc("orders")
            ->paginate($perSize);

        return [
            "items" => $items->items(),
            "page" => $items->currentPage(),
            "size" => $perSize,
            "total" => $items->total(),
        ];
    }

    public function repositorySelect(Closure $closure, int $perSize): array
    {
        // TODO: Implement repositorySelect() method.
    }

    public function repositoryCreate(array $insertInfo): bool
    {
        // TODO: Implement repositoryCreate() method.
    }

    public function repositoryAdd(array $addInfo): int
    {
        // TODO: Implement repositoryAdd() method.
    }

    /**
     * 内容详情
     * @param Closure $closure
     * @return array
     */
    public function repositoryFind(Closure $closure): array
    {
        $bean = StoreBookContent::query()->where($closure)
            ->where([["is_show", "=", 1]])
            ->select([
                "uuid", "title", "content", "author", "source", "read_number", "click_number", "collection_number"
            ])->first();
        if (!empty($bean)) return $bean->toArray();
        return [];
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