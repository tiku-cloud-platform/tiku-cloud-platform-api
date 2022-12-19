<?php
declare(strict_types = 1);

namespace App\Mapping\Request;

use App\Library\Encrypt\AesEncrypt;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;

/**
 * 客户端请求信息
 */
class RequestApp
{
    /**
     * @Inject
     * @var RequestInterface
     */
    protected $request;

    /**
     * 根据客户端请求，获取商户信息
     * @return string
     */
    public static function getStoreUuid(): string
    {
        $appIdSecret  =(new self())->request->header('App', '');
        $secretString = AesEncrypt::getInstance()->aesDecrypt($appIdSecret);
        $configArray  = json_decode($secretString, true);
        return $configArray["uuid"];
    }

    /**
     * 获取客户端类型
     * @return string ["wechat_miniprogram", "wechat_office_count", "h5", "pc"]
     */
    public static function getClientType():string
    {
        $appIdSecret  = (new self())->request->header('App', '');
        $secretString = AesEncrypt::getInstance()->aesDecrypt($appIdSecret);
        $configArray  = json_decode($secretString, true);
        return $configArray["client"];
    }
}