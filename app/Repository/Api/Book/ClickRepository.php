<?php
declare(strict_types = 1);

namespace App\Repository\Api\Book;

use App\Exception\DbDataMessageException;
use App\Exception\DbDuplicateMessageException;
use App\Model\Api\StoreBook;
use App\Model\Api\StoreBookClick;
use App\Repository\ApiRepositoryInterface;
use Closure;
use Hyperf\DbConnection\Db;
use Throwable;

class ClickRepository implements ApiRepositoryInterface
{
    public function repositorySelect(Closure $closure, int $perSize, array $searchFields = []): array
    {
        return [];
    }

    public function repositoryCreate(array $insertInfo): bool
    {
        try {
            Db::beginTransaction();
            $newModel  = StoreBookClick::query()->create($insertInfo);
            $updateRow = StoreBook::query()->increment("click_number");
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
                throw new DbDuplicateMessageException("你已点赞");
            } else {
                throw new DbDataMessageException("点赞失败");
            }
        }
    }

    public function repositoryAdd(array $addInfo): int
    {
        return 0;
    }

    public function repositoryFind(Closure $closure, array $searchFields = []): array
    {
        if (count($searchFields) === 0) {
            $searchFields = ["created_at as click_time"];
        }
        $bean = (new StoreBookClick())::query()->where($closure)->first($searchFields);
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