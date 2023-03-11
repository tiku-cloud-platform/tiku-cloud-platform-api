<?php
declare(strict_types = 1);

namespace App\Controller\Api\User;

use App\Constants\ErrorCode;
use App\Controller\ApiBaseController;
use App\Request\Api\User\Update\MainValidate;
use App\Request\Api\User\Update\MiniValidate;
use App\Service\Api\User\PlatformUserService;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\Middlewares;
use Hyperf\HttpServer\Annotation\Middleware;
use App\Middleware\Auth\UserAuthMiddleware;
use Hyperf\HttpServer\Annotation\PutMapping;
use Psr\Http\Message\ResponseInterface;
use RedisException;

/**
 * 用户信息修改操作
 * @Middlewares({
 *     @Middleware(UserAuthMiddleware::class)
 * })
 * @Controller(prefix="api/user/update")
 */
class UpdateController extends ApiBaseController
{
    /**
     * 更新主表信息
     * @PutMapping(path="info")
     * @param MainValidate $mainValidate
     * @return ResponseInterface
     * @throws RedisException
     */
    public function updateInfo(MainValidate $mainValidate): ResponseInterface
    {
        $updateResult = (new PlatformUserService())->serviceUpdate($this->request->all());
        if ($updateResult === 100) {
            return $this->httpResponse->error(["error" => ErrorCode::REQUEST_ERROR, "message" => "邮箱已存在"]);
        } elseif ($updateResult > 0 && $updateResult !== 100) {
            return $this->httpResponse->success(["success" => ErrorCode::REQUEST_SUCCESS, "message" => "更新成功"]);
        }
        return $this->httpResponse->error(["error" => ErrorCode::REQUEST_ERROR, "message" => "更新失败"]);
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