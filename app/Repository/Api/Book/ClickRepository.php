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
    public function repositorySelect(Closure $closure, int $perSize): array
    {
        // TODO: Implement repositorySelect() method.
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
        // TODO: Implement repositoryAdd() method.
    }

    public function repositoryFind(Closure $closure): array
    {
        $bean = (new StoreBookClick())::query()->where($closure)->first(["created_at as click_time"]);
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