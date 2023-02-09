<?php
declare(strict_types = 1);

namespace App\Repository\Api\User;


use App\Model\Api\StorePlatformMessageHistory;
use App\Repository\ApiRepositoryInterface;
use Hyperf\Di\Annotation\Inject;
use Throwable;

/**
 * 平台消息阅读历史
 * Class MessageHistoryRepository
 * @package App\Repository\Api\Api
 */
class MessageHistoryRepository implements ApiRepositoryInterface
{
    protected $historyModel;

    public function repositorySelect(\Closure $closure, int $perSize, array $searchFields = []): array
    {
        return [];
    }

    public function repositoryCreate(array $insertInfo): bool
    {
        try {
            if ((new StorePlatformMessageHistory)::query()->create($insertInfo)) {
                return true;
            }
        } catch (Throwable $throwable) {
            return false;
        }
        return false;
    }

    public function repositoryAdd(array $addInfo): int
    {
        return 0;
    }

    public function repositoryFind(\Closure $closure, array $searchFields = []): array
    {
        if (count($searchFields) === 0) {
            $searchFields = [];
        }
        $bean = (new StorePlatformMessageHistory)::query()
            ->where($closure)
            ->select($searchFields)
            ->first();
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
        return $this->historyModel::query()->where($searchWhere)->count('id');
    }
}