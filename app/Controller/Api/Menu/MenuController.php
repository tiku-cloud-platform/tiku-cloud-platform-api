<?php
declare(strict_types = 1);

namespace App\Controller\Api\Menu;

use App\Controller\ApiBaseController;
use App\Service\Api\Platform\MenuService;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Psr\Http\Message\ResponseInterface;

/**
 * 轮播图
 *
 * @Controller(prefix="api/menu")
 * Class BannerController
 * @package App\Controller\Api\Menu
 */
class MenuController extends ApiBaseController
{
    public function __construct(MenuService $menuService)
    {
        $this->service = $menuService;
        parent::__construct($menuService);
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