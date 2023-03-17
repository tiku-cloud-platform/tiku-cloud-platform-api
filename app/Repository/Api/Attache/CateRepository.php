<?php
declare(strict_types = 1);

namespace App\Repository\Api\Attache;

use App\Model\Api\StoreAttacheCate;
use App\Repository\ApiRepositoryInterface;
use Closure;

/**
 * 附件管理
 */
class CateRepository implements ApiRepositoryInterface
{

    public function repositoryAll(Closure $closure): array
    {
        return (new StoreAttacheCate())::query()
            ->with(["children:uuid,title"])
            ->where($closure)
            ->orderByDesc("id")
            ->get(["uuid", "title", "parent_uuid"])
            ->toArray();
    }

    public function repositorySelect(Closure $closure, int $perSize, array $searchFields = []): array
    {
        // TODO: Implement repositorySelect() method.
    }

    public function repositoryCreate(array $insertInfo): bool
    {
        // TODO: Implement repositoryCreate() method.
    }

    public function repositoryAdd(array $addInfo): int
    {
        // TODO: Implement repositoryAdd() method.
    }

    public function repositoryFind(Closure $closure, array $searchFields = []): array
    {
        // TODO: Implement repositoryFind() method.
    }

    public function repositoryUpdate(array $updateWhere, array $updateInfo): int
    {
        // TODO: Implement repositoryUpdate() method.
    }

    public function repositoryDelete(array $deleteWhere): int
    {
        // TODO: Implement repositoryDelete() method.
    }

    public function repositoryWhereInDelete(array $deleteWhere, string $field): int
    {
        // TODO: Implement repositoryWhereInDelete() method.
    }
}