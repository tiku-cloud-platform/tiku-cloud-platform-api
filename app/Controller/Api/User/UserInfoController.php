<?php
declare(strict_types = 1);

namespace App\Controller\Api\User;

use App\Controller\ApiBaseController;
use App\Mapping\Request\UserLoginInfo;
use App\Request\Api\User\BindPhoneValidate;
use App\Service\Api\User\PlatformUserService;
use App\Service\Api\User\UserInfoService;
use EasyWeChat\Kernel\Exceptions\InvalidConfigException;
use GuzzleHttp\Exception\GuzzleException;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middleware;
use App\Middleware\Auth\UserAuthMiddleware;
use Hyperf\HttpServer\Annotation\PostMapping;
use Psr\Http\Message\ResponseInterface;

/**
 * 用户信息
 * @Controller(prefix="api/user")
 */
class UserInfoController extends ApiBaseController
{
    /**
     * 获取用户基础信息
     * @Middleware(UserAuthMiddleware::class)
     * @GetMapping(path="info/basic")
     * @return ResponseInterface
     */
    public function show(): ResponseInterface
    {
        $cacheInfo = (new PlatformUserService)->serviceFind(["type" => "basic"]);
        return $this->httpResponse->success($cacheInfo);
    }

    /**
     * 获取用户全量信息
     * @Middleware(UserAuthMiddleware::class)
     * @GetMapping(path="info/all")
     * @return ResponseInterface
     */
    public function all(): ResponseInterface
    {
        $userAllInfo = (new PlatformUserService)->serviceFind(["type" => "all"]);
        return $this->httpResponse->success($userAllInfo);
    }

    /**
     * 绑定微信手机号
     * @Middleware(UserAuthMiddleware::class)
     * @PostMapping(path="bind_phone")
     * @param BindPhoneValidate $phoneValidate
     * @return ResponseInterface
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function bindPhone(BindPhoneValidate $phoneValidate): ResponseInterface
    {
        $result = (new UserInfoService())->bindPhone($this->request->all());
        if ($result["code"] === 1) {
            return $this->httpResponse->success($result);
        }
        return $this->httpResponse->error($result);
    }

    /**
     * 判断当前登录是否已经失效
     * 处于登录有效期，则返回用户的基础信息
     * 处于未登录状态，则返回直接返会空
     * @GetMapping("login_state")
     * @return ResponseInterface
     */
    public function loginState(): ResponseInterface
    {
        $loginInfo = (new UserLoginInfo())->checkoutUserLoginInfo();
        return $this->httpResponse->success($loginInfo);
    }
}