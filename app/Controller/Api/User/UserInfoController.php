<?php
declare(strict_types=1);

namespace App\Controller\Api\User;

use App\Controller\ApiBaseController;
use App\Service\Api\User\UserInfoService;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\Middlewares;
use App\Middleware\Auth\UserAuthMiddleware;

/**
 * 用户信息
 * @Middlewares({
 *     @Middleware(UserAuthMiddleware::class)
 * })
 * @Controller(prefix="api/user/info")
 */
class UserInfoController extends ApiBaseController
{
    public function __construct(UserInfoService $infoService)
    {
        parent::__construct($infoService);
    }

    /**
     * @GetMapping(path="")
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function show()
    {
        return $this->httpResponse->success();
    }
}