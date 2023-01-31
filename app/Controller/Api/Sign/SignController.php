<?php
declare(strict_types = 1);

namespace App\Controller\Api\Sign;

use App\Controller\ApiBaseController;
use App\Service\Api\Sign\SignService;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middlewares;
use Hyperf\HttpServer\Annotation\PostMapping;
use Psr\Http\Message\ResponseInterface;
use Hyperf\HttpServer\Annotation\Middleware;
use App\Middleware\Auth\UserAuthMiddleware;

/**
 * @Middlewares({
 *     @Middleware(UserAuthMiddleware::class)
 * })
 * @Controller(prefix="api/sign")
 */
class SignController extends ApiBaseController
{
    /**
     * 获取本周的签到状态
     * @GetMapping(path="list")
     * @return ResponseInterface
     */
    public function list(): ResponseInterface
    {
        return $this->httpResponse->success((new SignService())->serviceSelect($this->request->all()));
    }

    /**
     * 签到状态
     * @GetMapping(path="status")
     * @return ResponseInterface
     * @throws \RedisException
     */
    public function status(): ResponseInterface
    {
        return $this->httpResponse->success((new SignService())->serviceStatus($this->request->all()));
    }

    /**
     * 提交签到信息
     * @PostMapping(path="sign")
     * @return ResponseInterface
     * @throws \RedisException
     */
    public function Sign(): ResponseInterface
    {
        return $this->httpResponse->success((new SignService())->serviceSign($this->request->all()));
    }
}