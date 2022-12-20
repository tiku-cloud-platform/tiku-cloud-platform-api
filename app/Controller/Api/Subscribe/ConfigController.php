<?php
declare(strict_types = 1);

namespace App\Controller\Api\Subscribe;

use App\Controller\ApiBaseController;
use App\Library\WeChat\WeChatMiNi;
use App\Service\Api\Subscribe\ConfigService;
use EasyWeChat\Kernel\Exceptions\HttpException;
use EasyWeChat\Kernel\Exceptions\InvalidArgumentException;
use EasyWeChat\Kernel\Exceptions\InvalidConfigException;
use EasyWeChat\Kernel\Exceptions\RuntimeException;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Psr\Http\Message\ResponseInterface;

/**
 * 微信订阅消息
 *
 * Class ConfigController
 * @Controller(prefix="api/subscribe_wechat")
 * @package App\Controller\Api\Subscribe
 */
class ConfigController extends ApiBaseController
{
    public function __construct(ConfigService $configService)
    {
        $this->service = $configService;
        parent::__construct($configService);
    }

    /**
     * @GetMapping(path="templage_list")
     * @return ResponseInterface
     */
    public function index(): ResponseInterface
    {
        $items = $this->service->serviceSelect($this->request->all());
        return $this->httpResponse->success($items);
    }
}