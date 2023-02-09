<?php
declare(strict_types = 1);

namespace App\Repository\Api\User;


use App\Mapping\UUID;
use App\Model\Api\StoreUserSignCollection;
use App\Repository\ApiRepositoryInterface;
use Closure;
use Hyperf\Di\Annotation\Inject;

/**
 * 用户签到汇总
 *
 * Class SignCollectionRepository
 * @package App\Repository\Api\Api
 */
class SignCollectionRepository implements ApiRepositoryInterface
{
    public function repositorySelect(Closure $closure, int $perSize, array $searchFields = []): array
    {
        return [];
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
            $searchFields = ['uuid', 'user_uuid', 'sign_number',];
        }
        $bean = (new StoreUserSignCollection)::query()
            ->where($closure)
            ->select($searchFields)
            ->first();
        return !empty($bean) ? $bean->toArray() : [];
    }

    public function repositoryUpdate(array $updateWhere, array $updateInfo): int
    {
        $bean = (new StoreUserSignCollection)::query()->where('user_uuid', '=', $updateWhere['user_uuid'])->first(['uuid']);
        if (empty($bean)) {
            // 不存在记录
            if ((new StoreUserSignCollection)::query()->create([
                'uuid' => UUID::getUUID(),
                'user_uuid' => $updateWhere['user_uuid'],
                'sign_number' => 1,
                'store_uuid' => $updateWhere['store_uuid'],
                'is_show' => 1,
            ])) {
                return 0;
            }
            return 1;
        } else {
            // 存在记录
            return (new StoreUserSignCollection)::query()->where($updateWhere)->update($updateInfo);
        }
    }

    public function repositoryDelete(array $deleteWhere): int
    {
        return 0;
    }

    public function repositoryWhereInDelete(array $deleteWhere, string $field): int
    {
        return 0;
    }

    public function repositoryIncry(array $updateWhere): int
    {
        return (new StoreUserSignCollection())->fieldIncr((new StoreUserSignCollection())->getTable(), $updateWhere,
            'sign_number', 1);
    }
}