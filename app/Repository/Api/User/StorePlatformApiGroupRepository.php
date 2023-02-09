<?php
declare(strict_types = 1);

namespace App\Repository\Api\User;

use App\Model\Api\StorePlatformUserGroup;
use App\Repository\ApiRepositoryInterface;
use Closure;
use Hyperf\Di\Annotation\Inject;

/**
 * 商户平台用户分组
 *
 * Class StorePlatformApiGroupRepository
 * @package App\Repository\Api\Api
 */
class StorePlatformApiGroupRepository implements ApiRepositoryInterface
{
    public function repositorySelect(Closure $closure, int $perSize, array $searchFields = []): array
    {
        if (count($searchFields) === 0) {
            $searchFields = ['uuid', 'title'];
        }
        $items = (new StorePlatformUserGroup())::query()->where($closure)
            ->select($searchFields)
            ->where([['is_show', '=', 1]])
            ->orderByDesc('id')
            ->paginate($perSize);

        return [
            'items' => $items->items(),
            'total' => $items->total(),
            'size' => $items->perPage(),
            'page' => $items->currentPage(),
        ];
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
            $searchFields = ["uuid", "title"];
        }
        $bean = (new StorePlatformUserGroup)::query()
            ->where($closure)
            ->select($searchFields)
            ->first();

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