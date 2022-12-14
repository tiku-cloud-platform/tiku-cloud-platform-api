<?php
declare(strict_types=1);

namespace App\Controller\Api\User;

use App\Controller\ApiBaseController;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\PostMapping;
use Psr\Http\Message\ResponseInterface;

/**
 * 用户注册
 * @Controller(prefix="api/user/register")
 */
class RegisterController extends ApiBaseController
{
    /**
     * 微信小程序注册
     * @PostMapping(path="wechat_mini")
     * @return ResponseInterface
     */
    public function wechatMiNi(): ResponseInterface
    {
        return $this->httpResponse->success();
    }
}