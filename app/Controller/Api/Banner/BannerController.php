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
 *
 * @Controller(prefix="api/v1/banner")
 * Class BannerController
 * @package App\Controller\Api\Banner
 */
class BannerController extends ApiBaseController
{
    public function __construct(BannerService $bannerService)
    {
        $this->service = $bannerService;
        parent::__construct($bannerService);
    }

    /**
     * @GetMapping(path="list")
     * @return ResponseInterface
     */
    public function index()
    {
        $items = $this->service->serviceSelect($this->request->all());
        return $this->httpResponse->success($items);
    }
}