<?php

declare (strict_types=1);
/**
 * This file is part of api.
 *
 * @link     https://www.qqdeveloper.io
 * @document https://www.qqdeveloper.wiki
 * @contact  2665274677@qq.com
 * @license  Apache2.0
 */
namespace App\Middleware\Auth;

use App\Mapping\HttpDataResponse;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
/**
 * 用户端中间件.
 *
 * Class UserMiddleware
 */
class UserMiddleware implements MiddlewareInterface
{
    use \Hyperf\Di\Aop\ProxyTrait;
    use \Hyperf\Di\Aop\PropertyHandlerTrait;
    /**
     * @var ContainerInterface
     */
    protected $container;
    /**
     * @Inject
     * @var RequestInterface
     */
    protected $request;
    /**
     * @Inject
     * @var HttpDataResponse
     */
    protected $httpResponse;
    public function __construct(ContainerInterface $container)
    {
        $this->__handlePropertyHandler(__CLASS__);
        $this->container = $container;
    }
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler) : ResponseInterface
    {
        $clientType = $this->request->header('Client-Type', '');
        if (in_array($clientType, ['wechat'])) {
            return $handler->handle($request);
        }
        $this->httpResponse->response((string) '客户端类型错误');
    }
}