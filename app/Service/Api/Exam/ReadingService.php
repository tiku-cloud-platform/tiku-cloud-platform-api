<?php
declare(strict_types = 1);

namespace App\Service\Api\Exam;

use App\Repository\Api\Exam\ReadingRepository;
use App\Service\ApiServiceInterface;
use Closure;
use Hyperf\Di\Annotation\Inject;

/**
 * 问答试题
 *
 * Class ReadingService
 * @package App\Service\Api\Exam
 */
class ReadingService implements ApiServiceInterface
{
    /**
     * @Inject()
     * @var ReadingRepository
     */
    protected $readingRepository;

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
            if (!empty($exam_id)) {
                $query->where('collection_uuid', '=', $exam_id);
            }
            if (!empty($id)) {
                $query->where('uuid', '=', $id);
            }
        };
    }

    /**
     * 查询数据
     *
     * @param array $requestParams 请求参数
     * @return array 查询结果
     */
    public function serviceSelect(array $requestParams): array
    {
        return $this->readingRepository->repositorySelect(self::searchWhere($requestParams),
            (int)$requestParams['size'] ?? 20);
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
     * @return array
     */
    public function serviceFind(array $requestParams): array
    {
        return $this->readingRepository->repositoryFind(self::searchWhere($requestParams));
    }
}