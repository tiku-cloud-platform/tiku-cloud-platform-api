<?php
declare(strict_types = 1);

namespace App\Repository\Api\Platform;


use App\Model\Api\StorePlatformScore;
use App\Repository\ApiRepositoryInterface;
use Closure;

/**
 * 平台积分配置
 *
 * Class ScoreRepository
 * @package App\Repository\Api\Platform
 */
class ScoreRepository implements ApiRepositoryInterface
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
        if (count($searchFields)) {
            $searchFields = ['score', 'title', 'uuid', 'key'];
        }
        $bean = (new StorePlatformScore())::query()->where([['is_show', '=', 1]])
            ->where($closure)
            ->first($searchFields);

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