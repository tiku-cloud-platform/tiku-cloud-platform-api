<?php
declare(strict_types = 1);

namespace App\Controller\Api\Subscribe;

use App\Controller\ApiBaseController;
use App\Library\WeChat\WeChatMiNi;
use App\Service\Api\Subscribe\ConfigService;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Psr\Http\Message\ResponseInterface;

/**
 * 微信订阅消息
 *
 * Class ConfigController
 * @Controller(prefix="api/subscribe")
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
     * @GetMapping(path="list")
     * @return ResponseInterface
     */
    public function index()
    {
        var_dump(WeChatMiNi::getInstance()->access_token->getToken());
        $items = $this->service->serviceSelect($this->request->all());
        return $this->httpResponse->success($items);
    }
}