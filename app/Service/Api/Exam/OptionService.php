<?php
declare(strict_types = 1);

namespace App\Service\Api\Exam;


use App\Repository\Api\Exam\OptionRepository;
use App\Service\ApiServiceInterface;
use Closure;
use Hyperf\Di\Annotation\Inject;

/**
 * 单选试题
 *
 * Class OptionExamService
 * @package App\Service\Api\Exam
 */
class OptionService implements ApiServiceInterface
{
    /**
     * 格式化查询条件
     *
     * @param array $requestParams 请求参数
     * @return Closure 组装的查询条件
     */
    public static function searchWhere(array $requestParams): Closure
    {
        return function ($query) use ($requestParams) {
            extract($requestParams);
            if (!empty($exam_uuid)) {
                $query->where('exam_collection_uuid', '=', $exam_uuid);
            }
        };
    }

    /**
     * 查询单选试题选项列表
     * @param array $requestParams 请求参数
     * @return array 查询结果
     */
    public function serviceSelect(array $requestParams): array
    {
        if (!empty($requestParams["exam_uuid"])) {
            return (new OptionRepository)->repositorySelect(self::searchWhere($requestParams),
                (int)($requestParams['size'] ?? 20));
        }
        return [];
    }

    /**
     * 创建数据
     *
     * @param array $requestParams 请求参数
     * @return bool true|false
     */
    public function serviceCreate(array $requestParams): bool
    {
        // TODO: Implement serviceCreate() method.
    }

    /**
     * 更新数据
     *
     * @param array $requestParams 请求参数
     * @return int 更新行数
     */
    public function serviceUpdate(array $requestParams): int
    {
        // TODO: Implement serviceUpdate() method.
    }

    /**
     * 删除数据
     *
     * @param array $requestParams 请求参数
     * @return int 删除行数
     */
    public function serviceDelete(array $requestParams): int
    {
        // TODO: Implement serviceDelete() method.
    }

    /**
     * 查询单条数据
     *
     * @param array $requestParams 请求参数
     * @return array 删除行数
     */
    public function serviceFind(array $requestParams): array
    {
        // TODO: Implement serviceFind() method.
    }

    /**
     * 通过uuid查询数据
     *
     * @param array $uuidArray
     * @return array
     */
    public function serviceIdWhereIn(array $uuidArray): array
    {
        return (new OptionRepository)->repositoryWhereId('uuid', $uuidArray);
    }
}