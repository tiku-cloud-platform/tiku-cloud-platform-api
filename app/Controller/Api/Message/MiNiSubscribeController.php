<?php
declare(strict_types = 1);

namespace App\Controller\Api\Message;

use App\Constants\ErrorCode;
use App\Constants\HttpCode;
use App\Controller\ApiBaseController;
use App\Request\Api\Subscribe\MiNiSubscribeValidate;
use App\Service\Api\Message\MiNiSubscribeService;
use App\Service\Api\Message\UserMiNiSubscribeService;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\PostMapping;
use Psr\Http\Message\ResponseInterface;
use App\Middleware\Auth\UserAuthMiddleware;

/**
 * 微信小程序订阅消息
 * Class ConfigController
 * @Controller(prefix="api/subscribe_wechat")
 * @package App\Controller\Api\Subscribe
 */
class MiNiSubscribeController extends ApiBaseController
{
    public function __construct(MiNiSubscribeService $configService)
    {
        $this->service = $configService;
        parent::__construct($configService);
    }

    /**
     * 微信订阅消息记录列表
     * @GetMapping(path="templage_list")
     * @return ResponseInterface
     */
    public function index(): ResponseInterface
    {
        $items = $this->service->serviceSelect($this->request->all());
        return $this->httpResponse->success($items);
    }

    /**
     * 微信订阅消息记录
     * @PostMapping(path="templage_subscribe")
     * @Middleware(UserAuthMiddleware::class)
     * @param MiNiSubscribeValidate $subscribeValidate
     * @return ResponseInterface
     */
    public function subscribe(MiNiSubscribeValidate $subscribeValidate): ResponseInterface
    {
        if ((new UserMiNiSubscribeService())->serviceCreate($this->request->all())) {
            return $this->httpResponse->success(["success" => ErrorCode::REQUEST_SUCCESS, "message" => "订阅成功"]);
        }
        return $this->httpResponse->error(["error" => ErrorCode::REQUEST_ERROR, "message" => "订阅失败"]);
    }
}