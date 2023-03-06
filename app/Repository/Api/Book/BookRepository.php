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
    public function repositorySelect(Closure $closure, int $perSize, array $searchFields = []): array
    {
        if (count($searchFields) === 0) {
            $searchFields = ["uuid", "file_uuid", "title", "author", "tags", "source", "numbers", "collection_number", "level",
                "score", "click_number", "content_desc", "version"];
        }
        $items = StoreBook::query()
            ->with(["image:uuid,file_url as url,file_name as path"])
            ->where($closure)
            ->where([["is_show", "=", 1]])
            ->select($searchFields)
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
        return false;
    }

    public function repositoryAdd(array $addInfo): int
    {
        return 0;
    }

    public function repositoryFind(Closure $closure, array $searchFields = []): array
    {
        if (count($searchFields) === 0) {
            $searchFields = ["uuid", "file_uuid", "title", "author", "tags", "source", "numbers", "collection_number",
                "level", "score", "intro", "click_number", "content_desc", "version"];
        }
        $bean = StoreBook::query()->where($closure)
            ->with(["image:uuid,file_url as url,file_name as path"])
            ->where([["is_show", "=", 1]])
            ->select($searchFields)
            ->first();
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
}