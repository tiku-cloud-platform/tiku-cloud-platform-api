<?php
declare(strict_types = 1);

namespace App\Repository\Api\Exam;


use App\Model\Api\StoreExamOption;
use App\Repository\ApiRepositoryInterface;
use Closure;
use Hyperf\Di\Annotation\Inject;

/**
 * 选择试题
 *
 * Class OptionRepository
 * @package App\Repository\Api\Exam
 */
class OptionRepository implements ApiRepositoryInterface
{
    /**
     * 查询数据
     *
     * @param int $perSize 分页大小
     * @return array
     */
    public function repositorySelect(Closure $closure, int $perSize): array
    {
        $items = (new StoreExamOption)::query()
            ->with(['items:uuid,title,option_uuid,check,is_check'])
            ->whereHas('relationCollection', $closure)
            ->where([['is_show', '=', 1]])
            ->select([
                'uuid',
                'title',
                'answer',
                'analysis',
                'level',
            ])
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
        return false;
    }

    /**
     * 添加数据
     *
     * @param array $addInfo 添加信息
     * @return int 添加之后的ID或者行数
     */
    public function repositoryAdd(array $addInfo): int
    {
        return 0;
    }

    /**
     * 单条数据查询
     * @param Closure $closure
     * @return array
     */
    public function repositoryFind(Closure $closure): array
    {
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
        return 0;
    }

    /**
     * 删除数据
     *
     * @param array $deleteWhere 删除条件
     * @return int 删除行数
     */
    public function repositoryDelete(array $deleteWhere): int
    {
        return 0;
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
        return 0;
    }

    /**
     * 字段范围查询
     *
     * @param string $field 查询字段
     * @param array $searchWhere 查询条件
     * @return array
     */
    public function repositoryWhereId(string $field, array $searchWhere): array
    {
        $items = (new StoreExamOption)::query()->whereIn($field, $searchWhere)->get(['answer', 'answer_income_score', 'uuid', 'store_uuid']);
        if (!empty($items)) return $items->toArray();
        return [];
    }
}