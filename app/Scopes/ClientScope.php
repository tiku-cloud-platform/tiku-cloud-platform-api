<?php
declare(strict_types = 1);

namespace App\Scopes;

use App\Library\Encrypt\AesEncrypt;
use Hyperf\Database\Model\Builder;
use Hyperf\Database\Model\Model;
use Hyperf\Database\Model\Scope;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\Utils\Context;

/**
 * 客户端作用域
 *
 * Class ClientScope
 */
class ClientScope implements Scope
{
    /**
     * @Inject
     * @var RequestInterface
     */
    protected $request;

    public function apply(Builder $builder, Model $model)
    {
        $storeUuid = Context::get("app")["store_uuid"];
        $builder->where('store_uuid', '=', $storeUuid);
    }
}
