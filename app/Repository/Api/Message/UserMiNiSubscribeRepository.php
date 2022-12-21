<?php

namespace App\Repository\Api\Message;

use App\Exception\DbDataMessageException;
use App\Model\Api\StoreUserMiNiSubscribe;
use App\Repository\ApiRepositoryInterface;
use Hyperf\Di\Annotation\Inject;
use Throwable;

/**
 * 用户订阅微信小程序模板信息
 */
class UserMiNiSubscribeRepository implements ApiRepositoryInterface
{
    /**
     * @Inject()
     * @var StoreUserMiNiSubscribe
     */
    protected $subscribeModel;

    public function repositorySelect(\Closure $closure, int $perSize): array
    {
        // TODO: Implement repositorySelect() method.
    }

    /**
     * 创建用户订阅微信小程序模板消息
     * @param array $insertInfo
     * @return bool
     */
    public function repositoryCreate(array $insertInfo): bool
    {
        try {
            $createSubscribe = $this->subscribeModel::query()->create($insertInfo);
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
        // TODO: Implement repositoryAdd() method.
    }

    public function repositoryFind(\Closure $closure): array
    {
        // TODO: Implement repositoryFind() method.
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