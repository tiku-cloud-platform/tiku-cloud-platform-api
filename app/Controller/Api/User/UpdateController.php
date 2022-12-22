<?php
declare(strict_types=1);

namespace App\Controller\Api\User;

use App\Controller\AbstractController;
use App\Controller\ApiBaseController;
use App\Request\Api\User\Update\MainValidate;
use App\Request\Api\User\Update\MiniValidate;
use App\Service\Api\User\PlatformUserService;
use App\Service\ApiServiceInterface;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\Middlewares;
use Hyperf\HttpServer\Annotation\Middleware;
use App\Middleware\Auth\UserAuthMiddleware;
use Hyperf\HttpServer\Annotation\PutMapping;
use Psr\Http\Message\ResponseInterface;

/**
 * 用户信息修改操作
 * @Middlewares({
 *     @Middleware(UserAuthMiddleware::class)
 * })
 * @Controller(prefix="api/user/update")
 */
class UpdateController extends ApiBaseController
{
    public function __construct(PlatformUserService $userService)
    {
        $this->service = $userService;
        parent::__construct($userService);
    }

    /**
     * 更新主表信息
     * @PutMapping(path="main_info")
     * @param MainValidate $mainValidate
     * @return ResponseInterface
     */
    public function updateInfo(MainValidate $mainValidate): ResponseInterface
    {
        $updateResult = $this->service->serviceUpdate($this->request->all());
        if ($updateResult > 0) {
            return $this->httpResponse->success();
        }
        return $this->httpResponse->error();
    }

    /**
     * 更新微信小程序信息
     * @PutMapping(path="mini_info")
     * @param MiniValidate $miniValidate
     * @return ResponseInterface
     */
    public function miniUpdate(MiniValidate $miniValidate): ResponseInterface
    {
        return $this->httpResponse->success();
    }
}