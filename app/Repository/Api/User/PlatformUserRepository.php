<?php
declare(strict_types = 1);

namespace App\Repository\Api\User;

use App\Mapping\Request\UserLoginInfo;
use App\Model\Api\StoreMiNiWeChatUser;
use App\Model\Api\StorePlatformUser;
use App\Repository\ApiRepositoryInterface;
use Closure;
use Hyperf\DbConnection\Db;
use Hyperf\Di\Annotation\Inject;

/**
 * 平台用户
 * Class StorePlatformApiRepository
 * @package App\Repository\Api\User
 */
class PlatformUserRepository implements ApiRepositoryInterface
{
    public function repositorySelect(Closure $closure, int $perSize, array $searchFields = []): array
    {
        return [];
    }

    public function repositoryCreate(array $insertInfo): bool
    {
        if ((new StorePlatformUser)::query()->create($insertInfo)) return true;
        return false;
    }

    public function repositoryAdd(array $addInfo): int
    {
        return 0;
    }

    public function repositoryFind(Closure $closure, array $searchFields = []): array
    {
        if (count($searchFields) === 0) {
            $searchFields = ["*"];
        }
        $items = (new StorePlatformUser)::query()
            ->with(["level:uuid,title"])
            ->with(["mini:*"])
            ->where($closure)->first($searchFields);
        return !empty($items) ? $items->toArray() : [];
    }

    public function repositoryUpdate(array $updateWhere, array $updateInfo): int
    {
        $nickname = $updateInfo["nickname"];
        unset($updateInfo["nickname"], $updateInfo["user_uuid"], $updateInfo["store_uuid"],
            $updateInfo["login_token"]);
        if (empty($updateInfo["mobile"])) {
            unset($updateInfo["mobile"]);
        }
        if (empty($updateInfo["email"])) {
            unset($updateInfo["email"]);
        }
        $row = 0;
        Db::transaction(function () use ($updateInfo, $updateWhere, &$row, $nickname) {
            (new StoreMiNiWeChatUser())::query()->where([
                ["user_uuid", "=", UserLoginInfo::getUserId()]
            ])->update(["nickname" => $nickname]);
            unset($updateInfo["avatar_url"]);
            (new StorePlatformUser)::query()->where($updateWhere)->update($updateInfo);
            $row = 1;
        });
        return $row;
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