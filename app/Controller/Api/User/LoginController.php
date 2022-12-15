<?php
declare(strict_types = 1);

namespace App\Controller\Api\User;

use App\Controller\ApiBaseController;
use App\Request\Api\User\Login\CodeValidate;
use App\Service\Api\User\LoginService;
use EasyWeChat\Kernel\Exceptions\InvalidConfigException;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\PostMapping;
use Psr\Http\Message\ResponseInterface;

/**
 * @Controller(prefix="api/user/login")
 */
class LoginController extends ApiBaseController
{
    public function __construct(LoginService $loginService)
    {
        parent::__construct($loginService);
    }

    /**
     * 微信code换取信息
     * @PostMapping(path="wechat_code")
     * @param CodeValidate $codeValidate
     * @return ResponseInterface
     * @throws InvalidConfigException
     */
    public function code(CodeValidate $codeValidate): ResponseInterface
    {
        $userInfo = (new LoginService())->serviceMiNiCodeAuth($this->request->all());
        return $this->httpResponse->success($userInfo);
    }
}