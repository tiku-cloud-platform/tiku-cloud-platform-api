<?php
declare(strict_types = 1);

namespace App\Repository\Api\Book;

use App\Model\Api\StoreBook;
use App\Repository\ApiRepositoryInterface;
use Closure;

/**
 * 书籍管理
 */
class BookRepository implements ApiRepositoryInterface
{
    /**
     * 书籍列表
     * @param Closure $closure
     * @param int $perSize
     * @return array
     */
    public function repositorySelect(Closure $closure, int $perSize): array
    {
        $items = StoreBook::query()
            ->with(["image:uuid,file_url as url,file_name as path"])
            ->where($closure)
            ->where([["is_show", "=", 1]])
            ->select(["uuid", "file_uuid", "title", "author", "tags", "source", "numbers", "collection_number", "level",
                "score", "click_number"])
            ->orderByDesc("orders")
            ->paginate($perSize);
        return [
            "items" => $items->items(),
            "page" => $items->currentPage(),
            "size" => $perSize,
            "total" => $items->total(),
        ];
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
     * 查询详情
     * @param Closure $closure
     * @return array
     */
    public function repositoryFind(Closure $closure): array
    {
        $bean = StoreBook::query()->where($closure)
            ->with(["image:uuid,file_url as url,file_name as path"])
            ->where([["is_show", "=", 1]])
            ->select(["uuid", "file_uuid", "title", "author", "tags", "source", "numbers", "collection_number",
                "level", "score", "intro", "click_number"])
            ->first();
        if (!empty($bean)) {
            return $bean->toArray();
        }
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