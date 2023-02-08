<?php
declare(strict_types = 1);

namespace App\Repository\Api\Platform;


use App\Model\Api\StoreBanner;
use App\Repository\ApiRepositoryInterface;
use Closure;

/**
 * 轮播图
 * Class BannerRepository
 * @package App\Repository\Api\Platform
 */
class BannerRepository implements ApiRepositoryInterface
{
    public function repositorySelect(Closure $closure, int $perSize, array $searchFields = []): array
    {
        if (count($searchFields)) {
            $searchFields = ['title', 'file_uuid', 'url', 'type as redirect_type',];
        }
        $items = (new StoreBanner())::query()
            ->with(['image:uuid,file_url as url,file_name as name,file_hash as hash'])
            ->where($closure)
            ->where([['is_show', '=', 1]])
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