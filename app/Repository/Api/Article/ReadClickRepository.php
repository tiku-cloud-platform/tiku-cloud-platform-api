<?php
declare(strict_types = 1);

namespace App\Repository\Api\Article;


use App\Exception\DbDataMessageException;
use App\Exception\DbDuplicateMessageException;
use App\Model\Api\StoreArticleReadClick;
use App\Repository\ApiRepositoryInterface;
use Hyperf\Di\Annotation\Inject;
use Throwable;

/**
 * 文章阅读点赞历史
 *
 * Class ReadClickRepository
 * @package App\Repository\Api\Article
 */
class ReadClickRepository implements ApiRepositoryInterface
{
    public function repositorySelect(\Closure $closure, int $perSize): array
    {
        return [];
    }

    public function repositoryCreate(array $insertInfo): bool
    {
        try {
            if ((new StoreArticleReadClick)::query()->create($insertInfo)) {
                return true;
            }
        } catch (Throwable $throwable) {
            throw  new DbDuplicateMessageException("你已" . ($insertInfo["type"] == 1 ? "点赞" : "收藏"));
        }
        return false;
    }

    public function repositoryAdd(array $addInfo): int
    {
        return 0;
    }

    public function repositoryFind(\Closure $closure): array
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