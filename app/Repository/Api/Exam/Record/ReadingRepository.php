<?php
declare(strict_types=1);

namespace App\Repository\Api\Exam\Record;

use App\Exception\DbDataMessageException;
use App\Model\Api\StoreExamReadingCollectionRelation;
use App\Model\Api\StoreUserExamReading;
use App\Repository\ApiRepositoryInterface;
use Closure;
use Hyperf\Di\Annotation\Inject;
use Throwable;

/**
 * 问答试题记录
 */
class ReadingRepository implements ApiRepositoryInterface
{
    /**
     * @Inject()
     * @var StoreUserExamReading
     */
    protected $readingModel;

    public function repositorySelect(Closure $closure, int $perSize): array
    {
        // TODO: Implement repositorySelect() method.
    }

    public function repositoryCreate(array $insertInfo): bool
    {
        // TODO: Implement repositoryCreate() method.
    }

    /**
     * 添加问答试题记录
     * @param array $addInfo
     * @return int
     */
    public function repositoryAdd(array $addInfo): int
    {
        try {
            $collection = StoreExamReadingCollectionRelation::query()
                ->where("exam_uuid", "=", $addInfo["reading_uuid"])
                ->first(["collection_uuid"]);
            if (!empty($collection)) {
                $addInfo["collection_uuid"] = $collection->collection_uuid;
                if ($this->readingModel::query()->insertGetId($addInfo)) {
                    return 1;
                }
            }
            return 0;
        } catch (Throwable $throwable) {
            throw new DbDataMessageException($throwable->getMessage());
        }
    }

    public function repositoryFind(Closure $closure): array
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