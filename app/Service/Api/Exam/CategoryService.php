<?php
declare(strict_types = 1);

namespace App\Service\Api\Exam;


use App\Mapping\DataFormatter;
use App\Repository\Api\Exam\CategoryRepository;
use App\Service\ApiServiceInterface;
use Hyperf\Di\Annotation\Inject;

/**
 * 试题分类
 *
 * Class CategoryService
 * @package App\Service\Api\Exam
 */
class CategoryService implements ApiServiceInterface
{
    /**
     * @Inject()
     * @var CategoryRepository
     */
    protected $categoryRepository;

    public function __construct()
    {
    }

    /**
     * 格式化查询条件
     *
     * @param array $requestParams 请求参数
     * @return mixed 组装的查询条件
     */
    public static function searchWhere(array $requestParams)
    {
        return function () {
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
        $items = $this->categoryRepository->repositorySelect(self::searchWhere($requestParams),
            (int)$requestParams['size'] ?? 10000);

        $items['items'] = DataFormatter::recursionData((array)$items['items']);

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
     * 查询单条数据
     *
     * @param array $requestParams 请求参数
     * @return array
     */
    public function serviceFind(array $requestParams): array
    {
        // TODO: Implement serviceFind() method.
    }
}