<?php
declare(strict_types = 1);

namespace App\Repository\Api\Article;

use App\Exception\DbDataMessageException;
use App\Exception\DbDuplicateMessageException;
use App\Mapping\HttpDataResponse;
use App\Model\Api\StoreArticle;
use App\Model\Api\StoreArticleCollection;
use App\Model\Api\StoreArticleRead;
use App\Repository\ApiRepositoryInterface;
use Closure;
use Hyperf\DbConnection\Db;
use Throwable;

/**
 * 文章阅收藏记录
 * Class ReadCollectionRepository
 * @package App\Repository\Api\Article
 */
class CollectionRepository implements ApiRepositoryInterface
{
    public function repositorySelect(Closure $closure, int $perSize, array $searchFields = []): array
    {
        return [];
    }

    public function repositoryCreate(array $insertInfo): bool
    {
        try {
            $updateRow = 0;
            Db::transaction(function () use ($insertInfo, &$updateRow) {
                $createResult = (new StoreArticleCollection())::query()->create($insertInfo);
                $updateResult = (new ArticleRepository())->repositoryUpdateCollectionNumber($insertInfo["article_uuid"]);
                if ($createResult->getKey() && $updateResult > 0) {
                    $updateRow = 1;
                }
            }, 2);
            return $updateRow > 0;
        } catch (Throwable $throwable) {
            preg_match("/Duplicate entry/", $throwable->getMessage(), $msg);
            if (!empty($msg[0])) {
                throw  new DbDuplicateMessageException("已存在收藏记录");
            } else {
                throw new DbDataMessageException($throwable->getMessage());
            }
        }
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