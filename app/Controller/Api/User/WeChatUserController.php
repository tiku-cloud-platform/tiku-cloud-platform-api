<?php
declare(strict_types = 1);

namespace App\Controller\Api\User;

use App\Controller\ApiBaseController;
use App\Middleware\Auth\UserAuthMiddleware;
use App\Request\Api\User\UpdateInfoValidate;
use App\Service\Api\User\WeChatUserService;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Annotation\PutMapping;
use Psr\Http\Message\ResponseInterface;

/**
 * 用户中心
 *
 * @Controller(prefix="api/v1/user")
 * Class WeChatUserController
 * @package App\Controller\Api\Api
 */
class WeChatUserController extends ApiBaseController
{
    public function __construct(WeChatUserService $userService)
    {
        $this->service = $userService;
        parent::__construct($userService);
    }

    /**
     * @GetMapping(path="info")
     * @return ResponseInterface
     */
    public function show(): ResponseInterface
    {
        $userInfo = $this->service->serviceFind($this->request->all());

        return $this->httpResponse->success($userInfo);
    }

    /**
     * @Middleware(UserAuthMiddleware::class)
     * @PutMapping(path="update")
     * @param UpdateInfoValidate $validate
     * @return ResponseInterface
     */
    public function update(UpdateInfoValidate $validate): ResponseInterface
    {
        $updateResult = $this->service->serviceUpdate($validate->validated());

        return $updateResult ? $this->httpResponse->success() : $this->httpResponse->success();
    }

    /**
     * @Middleware(UserAuthMiddleware::class)
     * @PostMapping(path="check_login")
     * @return ResponseInterface
     */
    public function checkLogin(): ResponseInterface
    {
        return $this->httpResponse->success();
    }
}
