<?php
declare(strict_types = 1);

namespace App\Repository\Api\User;


use App\Model\Api\StoreUserSignHistory;
use App\Repository\ApiRepositoryInterface;
use Closure;
use Hyperf\DbConnection\Db;
use Hyperf\Di\Annotation\Inject;

/**
 * 用户签到历史
 *
 * Class SignHistoryRepository
 * @package App\Repository\Api\Api
 */
class SignHistoryRepository implements ApiRepositoryInterface
{
    public function repositorySelect(Closure $closure, int $perSize, array $searchFields = []): array
    {
        return [];
    }

    public function repositoryCreate(array $insertInfo): bool
    {
        /** @var object $self */
        $signHistoryRepository    = new StoreUserSignHistory();
        $signCollectionRepository = new SignCollectionRepository();
        $scoreRepository          = new ScoreHistoryRepository();

        $returnVal = false;

        if (empty($insertInfo['yesterdayInfo'])) {// 重置签到天数
            Db::transaction(function () use ($insertInfo, $signCollectionRepository, $signHistoryRepository, &$returnVal, $scoreRepository) {
                $signHistoryRepository::query()->create($insertInfo['history']);
                $signCollectionRepository->repositoryUpdate([
                    'user_uuid' => $insertInfo['history']['user_uuid'],
                    'store_uuid' => $insertInfo['history']['store_uuid'],
                ], ['sign_number' => 1]);
                if (!empty($insertInfo['score'])) {
                    $scoreRepository->repositoryCreate((array)$insertInfo['score']);
                }
                $returnVal = true;
            });
        } else {// 累计签到天数
            Db::transaction(function () use ($insertInfo, $signCollectionRepository, $signHistoryRepository, &$returnVal, $scoreRepository) {
                $signHistoryRepository::query()->create($insertInfo['history']);
                $signCollectionRepository->repositoryIncry([
                    'user_uuid' => $insertInfo['history']['user_uuid'],
                    'store_uuid' => $insertInfo['history']['store_uuid']
                ]);
                if (!empty($insertInfo['score'])) {
                    $scoreRepository->repositoryCreate((array)$insertInfo['score']);
                }

                $returnVal = false;
            });
        }

        return $returnVal;
    }

    public function repositoryAdd(array $addInfo): int
    {
        return 0;
    }

    public function repositoryFind(Closure $closure, array $searchFields = []): array
    {
        if (count($searchFields) === 0) {
            $searchFields = ['uuid', 'user_uuid', 'sign_date',];
        }
        $bean = (new StoreUserSignHistory())::query()
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
}