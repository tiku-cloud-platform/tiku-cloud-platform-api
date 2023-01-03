<?php
declare(strict_types = 1);

namespace App\Controller;

use App\Mapping\HttpDataResponse;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\Middlewares;
use Hyperf\HttpServer\Contract\RequestInterface;
use App\Middleware\ClientMiddleware;

/**
 * 用户请求基类
 * @Middlewares({
 *     @Middleware(ClientMiddleware::class)
 *     })
 * Class BaseController
 */
class ApiBaseController extends AbstractController
{
    /**
     * @Inject
     * @var HttpDataResponse
     */
    protected $httpResponse;

    /**
     * @Inject
     * @var RequestInterface
     */
    protected $request;
}
