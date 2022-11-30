<?php

declare (strict_types=1);
namespace App\Service\Api\Platform;

use App\Repository\Api\Platform\MenuRepository;
use App\Service\ApiServiceInterface;
use Hyperf\Di\Annotation\Inject;
/**
 * 用户端菜单
 *
 * Class MenuService
 * @package App\Service\Api\Platform
 */
class MenuService implements ApiServiceInterface
{
    use \Hyperf\Di\Aop\ProxyTrait;
    use \Hyperf\Di\Aop\PropertyHandlerTrait;
    /**
     * @Inject()
     * @var MenuRepository
     */
    protected $menuRepository;
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
            if (!empty($position)) {
                $query->where('position', '=', $position);
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
        return $this->menuRepository->repositorySelect(self::searchWhere($requestParams), (int) $requestParams['size'] ?? 20);
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
        // TODO: Implement serviceFind() method.
    }
}