<?php
declare(strict_types = 1);

namespace App\Controller\Api\Menu;

use App\Controller\ApiBaseController;
use App\Service\Api\Platform\MenuService;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Psr\Http\Message\ResponseInterface;

/**
 * 菜单配置
 * @Controller(prefix="api/menu")
 * Class BannerController
 * @package App\Controller\Api\Menu
 */
class MenuController extends ApiBaseController
{
    /**
     * 菜单列表
     * @GetMapping(path="list")
     * @return ResponseInterface
     */
    public function index(): ResponseInterface
    {
        $items = (new MenuService)->serviceSelect($this->request->all());
        return $this->httpResponse->success($items);
    }
}