<?php
declare(strict_types = 1);

namespace App\Repository\Api\User;


use App\Model\Api\StorePlatformMessageContent;
use App\Repository\ApiRepositoryInterface;
use Closure;

/**
 * 平台文章
 *
 * Class MessageContentRepository
 * @package App\Repository\Api\Api
 */
class MessageContentRepository implements ApiRepositoryInterface
{
    public function repositorySelect(Closure $closure, int $perSize, array $searchFields = []): array
    {
        if (count($searchFields)) {
            $searchFields = ['uuid', 'platform_message_category_uuid', 'title', 'created_at'];
        }
        $items = (new StorePlatformMessageContent)::query()
            ->with(['category:uuid,title'])
            ->where($closure)
            ->select($searchFields)
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
            $searchFields = ['uuid', 'platform_message_category_uuid', 'title', 'content', 'created_at'];
        }
        $bean = (new StorePlatformMessageContent)::query()
            ->with(['category:uuid,title'])
            ->where([['is_show', '=', 1]])
            ->where($closure)
            ->first($searchFields);

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

    public function repositoryCount(array $searchWhere = []): int
    {
        return (new StorePlatformMessageContent)::query()->where($searchWhere)->count('id');
    }
}