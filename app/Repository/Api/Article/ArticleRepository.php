<?php
declare(strict_types = 1);

namespace App\Repository\Api\Article;


use App\Model\Api\StoreArticle;
use App\Repository\ApiRepositoryInterface;
use Closure;

/**
 * 文章数据
 * Class ArticleRepository
 * @package App\Repository\Api\Article
 */
class ArticleRepository implements ApiRepositoryInterface
{
    public function repositorySelect(Closure $closure, int $perSize, array $searchFields = []): array
    {
        if (count($searchFields) === 0) {
            $searchFields = [
                'uuid', 'title', 'file_uuid', 'source', 'read_number', 'author', "article_category_uuid as category_uid",
                "click_number", "share_number", "collection_number",
            ];
        }
        $items = (new StoreArticle)::query()
            ->with(['image:uuid,file_url as url,file_name as path,file_hash as hash'])
            ->with(['category:uuid,title'])
            ->where([['is_show', '=', 1]])
            ->where($closure)
            ->select($searchFields)
            ->orderBy("is_top")
            ->orderByDesc('orders')
            ->paginate($perSize);

        return [
            'items' => $items->items(),
            'total' => $items->total(),
            'size' => $items->perPage(),
            'page' => $items->currentPage(),
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

    public function repositoryFind(Closure $closure, array $searchFields = []): array
    {
        if (count($searchFields) === 0) {
            $searchFields = ['uuid', 'article_category_uuid as category_uid', 'title', 'file_uuid', 'content', 'publish_date',
                'author', 'source', 'read_number', 'click_number', "read_score", "click_score", "share_score", "collection_score",
                "read_expend_score",];
        }
        $bean = (new StoreArticle)::query()
            ->with(['image:uuid,file_url as url,file_name as name,file_hash as hash'])
            ->with(['category:uuid,title'])
            ->where($closure)
            ->where([['is_show', '=', 1]])
            ->select($searchFields)
            ->first();

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

    public function repositoryUpdateReadNumber(string $uuid): int
    {
        return (new StoreArticle)->fieldIncr((new StoreArticle)->getTable(),
            [['uuid', '=', $uuid]],
            'read_number', 1);
    }

    public function repositoryUpdateClickNumber(string $uuid): int
    {
        return (new StoreArticle)->fieldIncr((new StoreArticle)->getTable(),
            [['uuid', '=', $uuid]],
            'click_number', 1);
    }

    public function repositoryUpdateCollectionNumber(string $uuid): int
    {
        return (new StoreArticle)->fieldIncr((new StoreArticle)->getTable(),
            [['uuid', '=', $uuid]],
            'collection_number', 1);
    }

    public function repositoryUpdateShareNumber(string $uuid): int
    {
        return (new StoreArticle)->fieldIncr((new StoreArticle)->getTable(),
            [['uuid', '=', $uuid]],
            'share_number', 1);
    }
}