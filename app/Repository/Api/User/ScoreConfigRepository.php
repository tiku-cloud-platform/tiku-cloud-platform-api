<?php
declare(strict_types = 1);

namespace App\Repository\Api\User;


use App\Model\Api\StorePlatformScore;
use App\Repository\ApiRepositoryInterface;
use Closure;
use Hyperf\Di\Annotation\Inject;

/**
 * 平台积分配置
 *
 * Class ScoreConfigRepository
 * @package App\Repository\Api\Api
 */
class ScoreConfigRepository implements ApiRepositoryInterface
{
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
            $searchFields = ['uuid', 'key', 'title', 'score', 'is_show', 'store_uuid',];
        }
        $bean = (new StorePlatformScore)::query()->where([['is_show', '=', 1]])->where($closure)->first($searchFields);

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