<?php
declare(strict_types = 1);

namespace App\Repository\Api\User;


use App\Model\Api\StorePlatformMessageCategory;
use App\Repository\ApiRepositoryInterface;
use Closure;

/**
 * 平台消息分类
 *
 * Class MessageCategoryRepository
 * @package App\Repository\Api\Api
 */
class MessageCategoryRepository implements ApiRepositoryInterface
{
    public function repositorySelect(Closure $closure, int $perSize, array $searchFields = []): array
    {
        if (count($searchFields)) {
            $searchFields = ['uuid', 'title', 'file_uuid',];
        }
        $items = (new StorePlatformMessageCategory)::query()
            ->with(['coverFileInfo:uuid,file_url,file_name'])
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