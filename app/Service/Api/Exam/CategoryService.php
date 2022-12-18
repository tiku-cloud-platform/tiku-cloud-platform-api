<?php
declare(strict_types = 1);

namespace App\Service\Api\Exam;


use App\Mapping\DataFormatter;
use App\Mapping\RedisClient;
use App\Mapping\Request\RequestApp;
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
        $cacheKey      = "exam_category:" . (new RequestApp())->getStoreUuid();
        $categoryCache = RedisClient::getInstance()->get($cacheKey);
        if (!empty($categoryCache)) {
            return json_decode($categoryCache, true);
        }
        $items          = $this->categoryRepository->repositorySelect(self::searchWhere($requestParams),
            (int)$requestParams['size'] ?? 20);
        $items["items"] = self::recursionData($items["items"], "");
        RedisClient::getInstance()->set($cacheKey, json_encode($items, JSON_UNESCAPED_UNICODE));
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

    /**
     * 格式化数据
     * @param array $info
     * @param string $pid
     * @return array
     */
    private static function recursionData(array $info, string $pid = ""): array
    {
        $tree = [];
        foreach ($info as $value) {
            if ($value['parent_uuid'] == $pid) {
                $value['children'] = self::recursionData($info, (string)$value['uuid']);
                if ($value['children'] == null) {
                    unset($value['children']);
                }
                $value->big_img   = "";
                $value->small_img = "";
                if (!empty($value->bigImage)) {
                    $value->big_img = $value->bigImage->url . $value->bigImage->name;
                }
                if (!empty($value->smallImage)) {
                    $value->small_img = $value->smallImage->url . $value->smallImage->name;
                }
                $value->uid = $value->uuid;
                unset($value->bigImage, $value->smallImage, $value->uuid);
                $tree[] = $value;
            }
        }

        return $tree;
    }
}