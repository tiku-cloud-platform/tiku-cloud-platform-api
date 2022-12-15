<?php
declare(strict_types = 1);

namespace App\Service\Api\Exam;


use App\Repository\Api\Exam\OptionRepository;
use App\Service\ApiServiceInterface;
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
     * @Inject
     * @var OptionRepository
     */
    protected $optionRepository;

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
        return function ($query) use ($requestParams) {
            extract($requestParams);
            if (!empty($exam_id)) {
                $query->where('exam_collection_uuid', '=', $exam_id);
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
        $items = $this->optionRepository->repositorySelect(self::searchWhere($requestParams),
            (int)$requestParams['size'] ?? 20);
        foreach ($items["items"] as $item) {
            $item->img = $item->image["url"] . $item->image["name"];
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
        return $this->optionRepository->repositoryWhereId('uuid', $uuidArray);
    }
}