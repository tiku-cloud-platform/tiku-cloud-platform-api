<?php
declare(strict_types = 1);

namespace App\Scopes;

use App\Library\Encrypt\AesEncrypt;
use Hyperf\Database\Model\Builder;
use Hyperf\Database\Model\Model;
use Hyperf\Database\Model\Scope;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;

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
        $appIdSecret = $this->request->header('App', '');

        if (empty($appIdSecret)) {
            $builder->where('id', '=', 0);
        } else {
            $secretString = AesEncrypt::getInstance()->aesDecrypt($appIdSecret);
            $configArray  = json_decode($secretString, true);
            // {"uuid":"35c28259-9b55-e438-3830-dfc79f592709","appid":"cld_d1e7a97fdc","client":"wechat_miniprogram"}
            if (is_array($configArray)) {
                $builder->where('store_uuid', '=', $configArray["uuid"]);
            } else {
                $builder->where('id', '=', 0);
            }
        }
    }
}
