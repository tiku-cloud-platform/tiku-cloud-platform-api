<?php

declare (strict_types=1);
namespace App\Service\Api\User;

use App\Repository\Api\User\StorePlatformApiGroupRepository;
use App\Service\ApiServiceInterface;
use Hyperf\Di\Annotation\Inject;
/**
 * 商户平台用户分组
 *
 * Class StorePlatformUserGroupService
 * @package App\Service\Api\Api
 */
class StorePlatformUserGroupService implements ApiServiceInterface
{
    use \Hyperf\Di\Aop\ProxyTrait;
    use \Hyperf\Di\Aop\PropertyHandlerTrait;
    function __construct()
    {
        $this->__handlePropertyHandler(__CLASS__);
    }
    /**
     * @Inject()
     * @var StorePlatformApiGroupRepository
     */
    protected $groupRepository;
    /**
     * @inheritDoc
     */
    public static function searchWhere(array $requestParams)
    {
        return function ($query) use($requestParams) {
            extract($requestParams);
            if (!empty($is_default)) {
                $query->where('is_default', '=', $is_default);
            }
        };
    }
    /**
     * @inheritDoc
     */
    public function serviceSelect(array $requestParams) : array
    {
        // TODO: Implement serviceSelect() method.
    }
    /**
     * @inheritDoc
     */
    public function serviceCreate(array $requestParams) : bool
    {
        // TODO: Implement serviceCreate() method.
    }
    /**
     * @inheritDoc
     */
    public function serviceUpdate(array $requestParams) : int
    {
        // TODO: Implement serviceUpdate() method.
    }
    /**
     * @inheritDoc
     */
    public function serviceDelete(array $requestParams) : int
    {
        // TODO: Implement serviceDelete() method.
    }
    /**
     * @inheritDoc
     */
    public function serviceFind(array $requestParams) : array
    {
        return $this->groupRepository->repositoryFind(self::searchWhere((array) $requestParams));
    }
}