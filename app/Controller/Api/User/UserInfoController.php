<?php
declare(strict_types = 1);

namespace App\Controller\Api\User;

use App\Controller\ApiBaseController;
use App\Service\Api\User\UserInfoService;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\Middlewares;
use App\Middleware\Auth\UserAuthMiddleware;
use Psr\Http\Message\ResponseInterface;

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
        $this->service = $infoService;
        parent::__construct($infoService);
    }

    /**
     * 获取用户基础信息
     * @GetMapping(path="basic")
     * @return ResponseInterface
     */
    public function show()
    {
        $cacheInfo = $this->service->serviceFind(["type" => "basic"]);
        return $this->httpResponse->success($cacheInfo);
    }

    /**
     * 获取用户全量信息
     * @GetMapping(path="all")
     * @return ResponseInterface
     */
    public function all(): ResponseInterface
    {
        $userAllInfo = $this->service->serviceFind(["type" => "all"]);
        return $this->httpResponse->success($userAllInfo);
    }
}