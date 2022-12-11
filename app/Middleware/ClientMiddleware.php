<?php
declare(strict_types = 1);

namespace App\Middleware;

use App\Constants\CacheKey;
use App\Library\Encrypt\AesEncrypt;
use App\Mapping\HttpDataResponse;
use App\Mapping\RedisClient;
use App\Mapping\Request\RequestApp;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * 验证客户端中间件
 *
 * Class ClientMiddleware
 */
class ClientMiddleware implements MiddlewareInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @Inject
     * @var RequestInterface
     */
    protected $request;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    // {"uuid":"35c28259-9b55-e438-3830-dfc79f592709","appid":"cld_d1e7a97fdc","client":"wechat_miniprogram"}
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        // 参数是否存在与参数是否合法
        $appIdSecret = $this->request->header('App', '');
        if (empty($appIdSecret)) {
            return (new HttpDataResponse)->response('参数缺少');
        }
        $secretString = AesEncrypt::getInstance()->aesDecrypt($appIdSecret);
        if ($secretString === "") {
            return (new HttpDataResponse)->response("解密失败");
        }
        $configArray = json_decode($secretString, true);
        var_dump($configArray);
        if (empty($configArray)) {
            return (new HttpDataResponse)->response('参数不正确');
        }
        if (!in_array($configArray["client"], ["wechat_miniprogram", "wechat_office_count", "h5", "pc"])) {
            return (new HttpDataResponse)->response('客户端不存在');
        }
        // 参数是否正确
        $cacheConfig = RedisClient::getInstance()->hGetAll(CacheKey::STORE_DEVEL_CONFIG . (new RequestApp())->getStoreUuid());
        if (empty($cacheConfig)) {
            return (new HttpDataResponse)->response('参数不存在');
        }
        if ($cacheConfig["app_id"] !== $configArray["appid"]) {
            return (new HttpDataResponse)->response('appid错误');
        }

        return $handler->handle($request);
    }
}
