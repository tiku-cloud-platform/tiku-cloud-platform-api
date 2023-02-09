<?php
declare(strict_types = 1);

namespace App\Repository\Api\Platform;

use App\Model\Api\StorePlatformContent;
use App\Repository\ApiRepositoryInterface;
use Closure;

/**
 * 平台内容
 * Class ContentRepository
 * @package App\Repository\Api\Platform
 */
class ContentRepository implements ApiRepositoryInterface
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
            $searchFields = ['content', 'title',];
        }
        $bean = (new StorePlatformContent)::query()
            ->where([['is_show', '=', 1]])
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