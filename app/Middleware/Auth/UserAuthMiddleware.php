<?php
declare(strict_types = 1);

namespace App\Middleware\Auth;

use App\Constants\ErrorCode;
use App\Constants\HttpCode;
use App\Mapping\HttpDataResponse;
use App\Mapping\UserInfo;
use Hyperf\Di\Annotation\Inject;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * 用户授权中间件.
 * Class UserAuthMiddleware
 */
class UserAuthMiddleware implements MiddlewareInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @Inject
     * @var HttpDataResponse
     */
    protected $httpResponse;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        return $handler->handle($request);
    }
}
