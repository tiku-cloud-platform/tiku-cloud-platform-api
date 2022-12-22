<?php
declare(strict_types = 1);

namespace App\Controller\Api\Config;

use App\Controller\ApiBaseController;
use App\Service\Api\Config\ConstService;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Psr\Http\Message\ResponseInterface;

/**
 * 系统常量配置
 * Class ConstController
 * @Controller(prefix="api/config")
 * @package App\Controller\Api\Config
 */
class ConstController extends ApiBaseController
{
    public function __construct(ConstService $constService)
    {
        $this->service = $constService;
        parent::__construct($constService);
    }

    /**
     * 常量列表
     * @GetMapping(path="list")
     * @return ResponseInterface
     */
    public function index(): ResponseInterface
    {
        $items = $this->service->serviceSelect($this->request->all());
        return $this->httpResponse->success($items);
    }
}