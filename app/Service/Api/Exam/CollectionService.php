<?php
declare(strict_types=1);

namespace App\Service\Api\Exam;


use App\Repository\Api\Exam\CollectionRepository;
use App\Service\ApiServiceInterface;
use Closure;
use Hyperf\Di\Annotation\Inject;

/**
 * 试卷
 *
 * Class CollectionService
 * @package App\Service\Api\Exam
 */
class CollectionService implements ApiServiceInterface
{
    /**
     * @Inject()
     * @var CollectionRepository
     */
    protected $collectionRepository;

    public function __construct()
    {
    }

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
            if (!empty($is_recommend)) {
                $query->where('is_recommend', '=', 1);
            }
            if (!empty($uuid)) {
                $query->where('uuid', '=', $uuid);
            }
            if (!empty($category_uid)) {
                $query->where('exam_category_uuid', '=', $category_uid);
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
        $items = $this->collectionRepository->repositorySelect(self::searchWhere($requestParams),
            (int)$requestParams['size'] ?? 20);
        foreach ($items["items"] as $item) {
            $item->img = $item->image["url"] . $item->image["name"];
            $item->category_uuid = $item->exam_category_uuid;
            $item->publish_time = date("Y-m-d", strtotime((string)$item->created_at));
            unset($item->image);
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
     * 查询单条数据
     *
     * @param array $requestParams 请求参数
     * @return array
     */
    public function serviceFind(array $requestParams): array
    {
        $bean = $this->collectionRepository->repositoryFind(self::searchWhere($requestParams));
        $bean["img"] = $bean["image"]["url"] . $bean["image"]["name"];
        $bean["category_uuid"] = $bean["exam_category_uuid"];
        $bean["publish_time"] = date("Y-m-d", strtotime((string)$bean["created_at"]));
        unset($bean["image"]);
        return $bean;
    }
}