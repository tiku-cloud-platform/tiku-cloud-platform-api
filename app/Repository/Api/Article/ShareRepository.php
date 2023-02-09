<?php
declare(strict_types = 1);

namespace App\Repository\Api\Article;

use App\Exception\DbDataMessageException;
use App\Model\Api\StoreArticleShare;
use App\Repository\ApiRepositoryInterface;
use Throwable;

/**
 * 文章阅点赞记录
 * Class ReadShareRepository
 * @package App\Repository\Api\Article
 */
class ShareRepository implements ApiRepositoryInterface
{
    public function repositorySelect(\Closure $closure, int $perSize, array $searchFields = []): array
    {
        return [];
    }

    public function repositoryCreate(array $insertInfo): bool
    {
        try {
            if ((new StoreArticleShare())::query()->create($insertInfo)) {
                return true;
            }
        } catch (Throwable $throwable) {

        }
        return false;
    }

    public function repositoryAdd(array $addInfo): int
    {
        return 0;
    }

    public function repositoryFind(\Closure $closure, array $searchFields = []): array
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