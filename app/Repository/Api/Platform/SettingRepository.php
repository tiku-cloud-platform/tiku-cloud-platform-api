<?php
declare(strict_types = 1);

namespace App\Repository\Api\Platform;


use App\Model\Api\StorePlatformConfig;
use App\Repository\ApiRepositoryInterface;
use Closure;

/**
 * 平台参数配置
 *
 * Class SettingRepository
 * @package App\Repository\Api\Platform
 */
class SettingRepository implements ApiRepositoryInterface
{
    public function repositorySelect(Closure $closure, int $perSize, array $searchFields = []): array
    {
        if (count($searchFields) === 0) {
            $searchFields = ['title', 'type', 'values', 'store_uuid',];
        }
        $items = (new StorePlatformConfig)::query()->where($closure)
            ->select($searchFields)
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
            $searchFields = ['title', 'type', 'values', 'store_uuid',];
        }
        $bean = (new StorePlatformConfig)::query()->where($closure)->first($searchFields);
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