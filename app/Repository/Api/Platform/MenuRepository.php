<?php
declare(strict_types = 1);

namespace App\Repository\Api\Platform;


use App\Model\Api\StoreMenu;
use App\Repository\ApiRepositoryInterface;
use Closure;

/**
 * 用户端菜单
 *
 * Class BannerRepository
 * @package App\Repository\Api\Platform
 */
class MenuRepository implements ApiRepositoryInterface
{
    public function repositorySelect(Closure $closure, int $perSize, array $searchFields = []): array
    {
        if (count($searchFields) === 0) {
            $searchFields = ['title', 'file_uuid', 'url', 'type',];
        }
        $items = (new StoreMenu())::query()
            ->with(['image:uuid,file_url as url,file_name as path,file_hash as hash'])
            ->where([['is_show', '=', 1]])
            ->where($closure)
            ->select($searchFields)
            ->orderByDesc('orders')
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