<?php

namespace App\Repository\Api\Message;

use App\Exception\DbDataMessageException;
use App\Model\Api\StoreUserMiNiSubscribe;
use App\Repository\ApiRepositoryInterface;
use Closure;
use Throwable;

/**
 * 用户订阅微信小程序模板信息
 */
class UserMiNiSubscribeRepository implements ApiRepositoryInterface
{
    public function repositorySelect(Closure $closure, int $perSize, array $searchFields = []): array
    {
        return [];
    }

    public function repositoryCreate(array $insertInfo): bool
    {
        try {
            $createSubscribe = (new StoreUserMiNiSubscribe)::query()->create($insertInfo);
            if (!empty($createSubscribe->getAttribute("uuid"))) {
                return true;
            }
            return false;
        } catch (Throwable $exception) {
            throw  new DbDataMessageException($exception->getMessage());
        }
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