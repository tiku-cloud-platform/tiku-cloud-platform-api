<?php

declare (strict_types=1);
namespace App\Repository\Api\Rank;

use App\Model\Api\StoreExamSubmitHistory;
use App\Repository\ApiRepositoryInterface;
use Hyperf\Di\Annotation\Inject;
/**
 * 答题排行
 *
 * Class ExamRepository
 * @package App\Repository\Api\Rank
 */
class ExamRepository implements ApiRepositoryInterface
{
    use \Hyperf\Di\Aop\ProxyTrait;
    use \Hyperf\Di\Aop\PropertyHandlerTrait;
    function __construct()
    {
        $this->__handlePropertyHandler(__CLASS__);
    }
    /**
     * @Inject()
     * @var StoreExamSubmitHistory
     */
    protected $examHistory;
    /**
     * 查询数据
     *
     * @param \Closure $closure
     * @param int $perSize 分页大小
     * @return array
     */
    public function repositorySelect(\Closure $closure, int $perSize) : array
    {
        $items = $this->examHistory::query()->with(['user:uuid,avatar_url,nickname'])->where($closure)->where('is_show', '=', 1)->orderByDesc('orders')->paginate($perSize);
        return ['items' => $items->items(), 'total' => $items->total(), 'size' => $items->perPage(), 'page' => $items->currentPage()];
    }
    /**
     * 创建数据
     *
     * @param array $insertInfo 创建信息
     * @return bool true|false
     */
    public function repositoryCreate(array $insertInfo) : bool
    {
        // TODO: Implement repositoryCreate() method.
    }
    /**
     * 添加数据
     *
     * @param array $addInfo 添加信息
     * @return int 添加之后的ID或者行数
     */
    public function repositoryAdd(array $addInfo) : int
    {
        // TODO: Implement repositoryAdd() method.
    }
    /**
     * 单条数据查询
     * @param \Closure $closure
     * @return array
     */
    public function repositoryFind(\Closure $closure) : array
    {
        // TODO: Implement repositoryFind() method.
    }
    /**
     * 更新数据
     *
     * @param array $updateWhere 修改条件
     * @param array $updateInfo 修改信息
     * @return int 更新行数
     */
    public function repositoryUpdate(array $updateWhere, array $updateInfo) : int
    {
        // TODO: Implement repositoryUpdate() method.
    }
    /**
     * 删除数据
     *
     * @param array $deleteWhere 删除条件
     * @return int 删除行数
     */
    public function repositoryDelete(array $deleteWhere) : int
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
    public function repositoryWhereInDelete(array $deleteWhere, string $field) : int
    {
        // TODO: Implement repositoryWhereInDelete() method.
    }
}