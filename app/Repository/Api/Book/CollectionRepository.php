<?php
declare(strict_types = 1);

namespace App\Repository\Api\Book;

use App\Exception\DbDataMessageException;
use App\Exception\DbDuplicateMessageException;
use App\Model\Api\StoreBook;
use App\Model\Api\StoreBookCollection;
use App\Repository\ApiRepositoryInterface;
use Closure;
use Hyperf\DbConnection\Db;
use Throwable;

class CollectionRepository implements ApiRepositoryInterface
{
    public function repositorySelect(Closure $closure, int $perSize, array $searchFields = []): array
    {
        if (count($searchFields) == 0) {
            return [];
        }
        $items = (new StoreBookCollection())::query()
            ->with(["book:uuid,file_uuid,title,author,version,source,content_desc"])
            ->whereHas("book", function ($query) {
                $query->where("is_show", "=", 1);
            })
            ->where($closure)
            ->paginate($perSize, $searchFields);

        return [
            "items" => $items->items(),
            "page" => $items->currentPage(),
            "size" => $items->perPage(),
            "total" => $items->total(),
        ];
    }

    public function repositoryCreate(array $insertInfo): bool
    {
        try {
            Db::beginTransaction();
            $newModel  = StoreBookCollection::query()->create($insertInfo);
            $updateRow = StoreBook::query()->increment("collection_number");
            if (!empty($newModel->getKey()) && $updateRow) {
                Db::commit();
                return true;
            }
            Db::rollBack();
            return false;
        } catch (Throwable $throwable) {
            Db::rollBack();
            preg_match("/Duplicate entry/", $throwable->getMessage(), $msg);
            if (!empty($msg)) {
                throw new DbDuplicateMessageException("你已收藏");
            } else {
                throw new DbDataMessageException("收藏失败");
            }
        }
    }

    public function repositoryCount(string $userUuid): int
    {
        return (new StoreBookCollection())::query()->where([
            ["user_uuid", "=", $userUuid]
        ])->count();
    }

    public function repositoryAdd(array $addInfo): int
    {
        return 0;
    }

    public function repositoryFind(Closure $closure, array $searchFields = []): array
    {
        if (count($searchFields) === 0) {
            $searchFields = ["created_at as collection_time"];
        }
        $bean = (new StoreBookCollection())::query()->where($closure)->first($searchFields);
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