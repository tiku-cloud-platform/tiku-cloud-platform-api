<?php

declare (strict_types=1);
namespace App\Service\Api\Article;

use App\Mapping\UserInfo;
use App\Mapping\UUID;
use App\Repository\Api\Article\ReadClickRepository;
use App\Service\ApiServiceInterface;
use Hyperf\Di\Annotation\Inject;
/**
 * 文章阅读点赞记录
 *
 * Class ReadClickService
 * @package App\Service\Api\Article
 */
class ReadClickService implements ApiServiceInterface
{
    use \Hyperf\Di\Aop\ProxyTrait;
    use \Hyperf\Di\Aop\PropertyHandlerTrait;
    /**
     * @Inject()
     * @var ReadClickRepository
     */
    protected $readClickRepository;
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
        // TODO: Implement searchWhere() method.
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
        $userInfo = UserInfo::getWeChatUserInfo();
        if (!empty($userInfo)) {
            $requestParams['uuid'] = UUID::getUUID();
            $requestParams['store_uuid'] = $userInfo['store_uuid'];
            $requestParams['user_uuid'] = $userInfo['user_uuid'];
            return $this->readClickRepository->repositoryCreate($requestParams);
        }
        return false;
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