<?php
declare(strict_types = 1);

namespace App\Repository\Api\User;

use App\Model\Api\StoreUserMiNiSubscribe;
use App\Repository\ApiRepositoryInterface;
use Closure;
use Hyperf\Di\Annotation\Inject;

/**
 * 微信订阅消息记录
 *
 * Class TemplateSubscribe
 * @package App\Repository\Api\Api
 */
class TemplateSubscribeRepository implements ApiRepositoryInterface
{
    public function repositorySelect(Closure $closure, int $perSize, array $searchFields = []): array
    {
        return [];
    }

    public function repositoryCreate(array $insertInfo): bool
    {
        if ((new StoreUserMiNiSubscribe)::create($insertInfo)) return true;
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