<?php
declare(strict_types = 1);

namespace App\Middleware\Auth;

use App\Constants\CacheKey;
use App\Constants\ErrorCode;
use App\Constants\HttpCode;
use App\Mapping\HttpDataResponse;
use App\Mapping\RedisClient;
use App\Mapping\Request\RequestApp;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\Utils\Context;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * 用户授权中间件.
 * Class UserAuthMiddleware
 */
class UserAuthMiddleware implements MiddlewareInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;

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

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        // 先判断是否存在授权字段；接着获取客户端类型；根据客户端类型获取用户登录信息。
        $authentication = $request->getHeader("Authorization");
        if (!empty($authentication)) {
            $loginToken = trim(str_replace("Bearer", "", $authentication[0]));
            $userInfo   = "";
            if ((new RequestApp())->getClientType() === "wechat_miniprogram") {
                $userInfo = RedisClient::getInstance()->get(CacheKey::MINI_LOGIN_TOKEN . $loginToken);
            }
            if (!empty($userInfo)) {
                $userInfo = array_merge(json_decode($userInfo, true), ["login_token" => $loginToken]);
                // 验证登录的user_agent是否一致
                $userAgent = $this->request->header("user-agent", "");
                if ($userAgent != $userInfo["user_agent"]) {
                    return $this->httpResponse->error([], ErrorCode::REQUEST_ERROR, "请求不合法", HttpCode::NO_AUTH);
                }
                Context::set("login:info", $userInfo);
            } else {
                return $this->httpResponse->error([], ErrorCode::REQUEST_ERROR, "登录已失效", HttpCode::NO_AUTH);
            }
        } else {
            return $this->httpResponse->error([],
                ErrorCode::REQUEST_ERROR,
                HttpCode::getMessage(HttpCode::NO_AUTH),
                HttpCode::NO_AUTH
            );
        }
        return $handler->handle($request);
    }
}
