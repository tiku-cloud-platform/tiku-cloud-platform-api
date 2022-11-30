<?php

declare (strict_types=1);
namespace App\Service\Api\User;

use App\Repository\Api\User\SignCollectionRepository;
use App\Service\ApiServiceInterface;
use Hyperf\Di\Annotation\Inject;
/**
 * 签到汇总
 *
 * Class SignCollectionService
 * @package App\Service\Api\Api
 */
class SignCollectionService implements ApiServiceInterface
{
    use \Hyperf\Di\Aop\ProxyTrait;
    use \Hyperf\Di\Aop\PropertyHandlerTrait;
    /**
     * @Inject()
     * @var SignCollectionRepository
     */
    protected $signCollectionRepository;
    public function __construct()
    {
        $this->__handlePropertyHandler(__CLASS__);
    }
    /**
     * 格式化查询条件
     *
     * @param array $requestParams 请求参数
     * @return mixed 组装的查询条件
     */
    public static function searchWhere(array $requestParams)
    {
        return function ($query) use($requestParams) {
            extract($requestParams);
            if (!empty($user_uuid)) {
                return $query->where('user_uuid', '=', $user_uuid);
            }
        };
    }
    /**
     * 查询数据
     *
     * @param array $requestParams 请求参数
     * @return array 查询结果
     */
    public function serviceSelect(array $requestParams) : array
    {
        // TODO: Implement serviceSelect() method.
    }
    /**
     * 创建数据
     *
     * @param array $requestParams 请求参数
     * @return bool true|false
     */
    public function serviceCreate(array $requestParams) : bool
    {
        // TODO: Implement serviceCreate() method.
    }
    /**
     * 更新数据
     *
     * @param array $requestParams 请求参数
     * @return int 更新行数
     */
    public function serviceUpdate(array $requestParams) : int
    {
        // TODO: Implement serviceUpdate() method.
    }
    /**
     * 删除数据
     *
     * @param array $requestParams 请求参数
     * @return int 删除行数
     */
    public function serviceDelete(array $requestParams) : int
    {
        // TODO: Implement serviceDelete() method.
    }
    /**
     * 查询单条数据
     *
     * @param array $requestParams 请求参数
     * @return array 删除行数
     */
    public function serviceFind(array $requestParams) : array
    {
        return $this->signCollectionRepository->repositoryFind(self::searchWhere((array) $requestParams));
    }
}