<?php
declare(strict_types = 1);

namespace App\Repository\Api\Article;


use App\Model\Api\StoreArticle;
use App\Repository\ApiRepositoryInterface;
use Closure;
use Hyperf\Di\Annotation\Inject;

/**
 * 文章
 *
 * Class ArticleRepository
 * @package App\Repository\Api\Article
 */
class ArticleRepository implements ApiRepositoryInterface
{
    /**
     * @Inject()
     * @var StoreArticle
     */
    protected $articleModel;

    public function __construct()
    {
    }

    /**
     * 查询数据
     * @param Closure $closure
     * @param int $perSize 分页大小
     * @return array
     */
    public function repositorySelect(Closure $closure, int $perSize): array
    {
        $items = (new StoreArticle)::query()
            ->with(['image:uuid,file_url as url,file_name as name,file_hash as hash'])
            ->with(['category:uuid,title'])
            ->where([['is_show', '=', 1]])
            ->where($closure)
            ->select([
                'uuid',
                'title',
                'file_uuid',
                'source',
                'read_number',
                'author',
                "article_category_uuid as category_uid",
                "click_number",
            ])
            ->orderByDesc('orders')
            ->paginate($perSize);

        return [
            'items' => $items->items(),
            'total' => $items->total(),
            'size' => $items->perPage(),
            'page' => $items->currentPage(),
        ];
    }

    /**
     * 创建数据
     *
     * @param array $insertInfo 创建信息
     * @return bool true|false
     */
    public function repositoryCreate(array $insertInfo): bool
    {
        // TODO: Implement repositoryCreate() method.
    }

    /**
     * 添加数据
     *
     * @param array $addInfo 添加信息
     * @return int 添加之后的ID或者行数
     */
    public function repositoryAdd(array $addInfo): int
    {
        // TODO: Implement repositoryAdd() method.
    }

    /**
     * 单条数据查询
     */
    public function repositoryFind(Closure $closure): array
    {
        $bean = (new StoreArticle)::query()
            ->with(['image:uuid,file_url as url,file_name as name,file_hash as hash'])
            ->with(['category:uuid,title'])
            ->where($closure)
            ->where([['is_show', '=', 1]])
            ->select([
                'uuid',
                'article_category_uuid as category_uid',
                'title',
                'file_uuid',
                'content',
                'publish_date',
                'author',
                'source',
                'read_number',
                'click_number',
            ])
            ->first();

        if (!empty($bean)) return $bean->toArray();
        return [];
    }

    /**
     * 更新数据
     *
     * @param array $updateWhere 修改条件
     * @param array $updateInfo 修改信息
     * @return int 更新行数
     */
    public function repositoryUpdate(array $updateWhere, array $updateInfo): int
    {
        // TODO: Implement repositoryUpdate() method.
    }

    /**
     * 删除数据
     *
     * @param array $deleteWhere 删除条件
     * @return int 删除行数
     */
    public function repositoryDelete(array $deleteWhere): int
    {
        // TODO: Implement repositoryDelete() method.
    }

    /**
     * 范围删除
     *
     * @param array $deleteWhere 删除条件
     * @param string $field 删除字段
     * @return int
     */
    public function repositoryWhereInDelete(array $deleteWhere, string $field): int
    {
        // TODO: Implement repositoryWhereInDelete() method.
    }

    /**
     * 更新阅读数量
     *
     * @param string $uuid
     * @return int
     */
    public function repositoryUpdateReadNumber(string $uuid): int
    {
        return (new StoreArticle)->fieldIncr((new StoreArticle)->getTable(),
            [['uuid', '=', $uuid]],
            'read_number', 1);
    }

    /**
     * 更新点赞数量
     * @param string $uuid
     * @param string $storeUUID
     * @return int
     */
    public function repositoryUpdateClickNumber(string $uuid): int
    {
        return (new StoreArticle)->fieldIncr((new StoreArticle)->getTable(),
            [['uuid', '=', $uuid]],
            'click_number', 1);
    }

    /**
     * 文章收藏数量
     * @param string $uuid
     * @return int
     */
    public function repositoryUpdateCollectionNumber(string $uuid): int
    {
        return (new StoreArticle)->fieldIncr((new StoreArticle)->getTable(),
            [['uuid', '=', $uuid]],
            'collection_number', 1);
    }
}