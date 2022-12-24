<?php
declare(strict_types = 1);

namespace App\Service\Api\Exam;

use App\Repository\Api\Exam\ReadingRepository;
use App\Service\ApiServiceInterface;
use Closure;

/**
 * 问答试题
 *
 * Class ReadingService
 * @package App\Service\Api\Exam
 */
class ReadingService implements ApiServiceInterface
{
    /**
     * 格式化查询条件
     * @param array $requestParams 请求参数
     * @return Closure 组装的查询条件
     */
    public static function searchWhere(array $requestParams): Closure
    {
        return function ($query) use ($requestParams) {
            extract($requestParams);
            if (!empty($collection_uuid)) {
                $query->where('collection_uuid', '=', $collection_uuid);
            }
            if (!empty($uuid)) {
                $query->where('uuid', '=', $uuid);
            }
        };
    }

    /**
     * 问答试题列表
     * @param array $requestParams 请求参数
     * @return array 查询结果
     */
    public function serviceSelect(array $requestParams): array
    {
        $items = (new ReadingRepository())->repositorySelect(self::searchWhere($requestParams),
            (int)$requestParams['size'] ?? 20);
        foreach ($items["items"] as $item) {
            unset($item->relationCollection);
        }
        return $items;
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
     * 问答试题详情
     * @param array $requestParams 请求参数
     * @return array
     */
    public function serviceFind(array $requestParams): array
    {
        return (new ReadingRepository())->repositoryFind(self::searchWhere($requestParams));
    }
}