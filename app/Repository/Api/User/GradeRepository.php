<?php
declare(strict_types = 1);

namespace App\Repository\Api\User;

use App\Model\Api\StorePlatformUserGrade;
use App\Repository\ApiRepositoryInterface;
use Closure;

/**
 * 会员等级
 */
class GradeRepository implements ApiRepositoryInterface
{

    public function repositorySelect(Closure $closure, int $perSize): array
    {
        $items = (new StorePlatformUserGrade())::query()->where($closure)->where([
            ["is_show", "=", 1]
        ])->paginate($perSize, ["uuid", "title", "remark"]);

        return [
            "items" => $items->items(),
            "total" => $items->total(),
            "page" => $items->currentPage(),
            "size" => $items->perPage(),
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

    public function repositoryFind(Closure $closure): array
    {
        $bean = (new StorePlatformUserGrade())::query()->where($closure)->where([
            ["is_show", "=", 1]
        ])->orderBy("id")->first(["uuid", "title", "remark"]);
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