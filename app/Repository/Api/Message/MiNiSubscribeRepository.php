<?php
declare(strict_types = 1);

namespace App\Repository\Api\Message;

use App\Model\Api\StoreMiNiSubscribe;
use App\Repository\ApiRepositoryInterface;
use Closure;

/**
 * 微信小程序模板订阅
 * Class ConfigRepository
 * @package App\Repository\Api\Subscribe
 */
class MiNiSubscribeRepository implements ApiRepositoryInterface
{
    public function __construct()
    {
    }

    public function repositorySelect(Closure $closure, int $perSize, array $searchFields = []): array
    {
        if (count($searchFields) === 0) {
            $searchFields = ['uuid', 'title', 'template_id', 'file_uuid',];
        }
        $items = (new StoreMiNiSubscribe)::query()
            ->with(['image:uuid,file_url as url,file_name as name,file_hash as hash'])
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