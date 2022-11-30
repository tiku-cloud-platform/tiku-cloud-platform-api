<?php
declare(strict_types = 1);

namespace App\Controller\Api\User;

use App\Controller\ApiBaseController;
use App\Service\Api\User\WeChatUserService;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\PostMapping;
use Psr\Http\Message\ResponseInterface;

/**
 * 用户登录
 *
 * @Controller(prefix="api/v1/user")
 * Class LoginController
 * @package App\Controller\Api\Api
 */
class LoginController extends ApiBaseController
{
    public function __construct(WeChatUserService $userService)
    {
        $this->service = $userService;
        parent::__construct($userService);
    }

    /**
     * code和userInfo一并登录
     *
     * @PostMapping(path="wechat/login")
     * @return ResponseInterface
     */
    public function weChatLogin()
    {
        $userInfo = $this->service->serviceWeChatLogin($this->request->all());
        if ($userInfo['code'] == 0) {
            return $this->httpResponse->success((array)$userInfo['data']);
        }
        return $this->httpResponse->error($userInfo);
    }

    /**
     * 静默授权登录
     *
     * @PostMapping(path="wechat/quite/login")
     * @return ResponseInterface
     * @deprecated
     */
    public function quiteWeChatLogin()
    {
        $userInfo = $this->service->serviceQuiteWeChatLogin($this->request->all());
        if ($userInfo['code'] == 0) {
            return $this->httpResponse->success((array)$userInfo['data']);
        }
        return $this->httpResponse->error((array)$userInfo);
    }
}