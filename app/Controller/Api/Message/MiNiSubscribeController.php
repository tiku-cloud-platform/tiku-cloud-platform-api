<?php
declare(strict_types = 1);

namespace App\Controller\Api\Message;

use App\Controller\ApiBaseController;
use App\Service\Api\Message\MiNiSubscribeService;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Psr\Http\Message\ResponseInterface;

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
     * 订阅消息列表
     * @GetMapping(path="templage_list")
     * @return ResponseInterface
     */
    public function index(): ResponseInterface
    {
        $items = $this->service->serviceSelect($this->request->all());
        return $this->httpResponse->success($items);
    }
}