<?php
declare(strict_types = 1);

namespace App\Controller\Api\Banner;

use App\Controller\ApiBaseController;
use App\Service\Api\Platform\BannerService;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Psr\Http\Message\ResponseInterface;

/**
 * 轮播图
 * @Controller(prefix="api/banner")
 * Class BannerController
 * @package App\Controller\Api\Banner
 */
class BannerController extends ApiBaseController
{
    /**
     * 轮播图列表
     * @GetMapping(path="list")
     * @return ResponseInterface
     */
    public function index(): ResponseInterface
    {
        $items = (new BannerService)->serviceSelect($this->request->all());
        return $this->httpResponse->success($items);
    }
}