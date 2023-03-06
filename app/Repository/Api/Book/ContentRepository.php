<?php
declare(strict_types = 1);

namespace App\Repository\Api\Book;

use App\Model\Api\StoreBookContent;
use App\Repository\ApiRepositoryInterface;
use Closure;
use Throwable;

/**
 * 书籍内容管理
 */
class ContentRepository implements ApiRepositoryInterface
{
    /**
     * 文章目录
     * @param Closure $closure
     * @param int $perSize
     * @param array $searchFields
     * @return array
     */
    public function repositoryCatalog(Closure $closure, int $perSize, array $searchFields = []): array
    {
        if (count($searchFields) === 0) {
            $searchFields = ["title", "uuid"];
        }
        $items = StoreBookContent::query()->where($closure)
            ->select($searchFields)
            ->where([["is_show", "=", 1]])
            ->paginate($perSize);

        return [
            "items" => $items->items(),
            "page" => $items->currentPage(),
            "size" => $perSize,
            "total" => $items->total(),
        ];
    }

    public function repositorySelect(Closure $closure, int $perSize, array $searchFields = []): array
    {
        return [];
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
            $searchFields = [
                "uuid", "title", "content", "author", "source", "read_number", "click_number", "collection_number"
            ];
        }
        $bean = StoreBookContent::query()->where($closure)
            ->where([["is_show", "=", 1]])
            ->orderByDesc("orders")->first($searchFields);

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

    public function repositoryIncrement(array $updateWhere, string $incrementField, int $incrementValue = 1): int
    {
        try {
            return StoreBookContent::query()->where($updateWhere)->increment($incrementField, $incrementValue);
        } catch (Throwable $throwable) {
            return 0;
        }
    }
}