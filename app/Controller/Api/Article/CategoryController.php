<?php
declare(strict_types = 1);

namespace App\Controller\Api\Article;


use App\Controller\ApiBaseController;
use App\Service\Api\Article\CategoryService;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Psr\Http\Message\ResponseInterface;

/**
 * 文章分类
 * @Controller(prefix="api/article/category")
 * Class CategoryController
 * @package App\Controller\Api\Article
 */
class CategoryController extends ApiBaseController
{
    public function __construct(CategoryService $categoryService)
    {
        $this->service = $categoryService;
        parent::__construct($categoryService);
    }

    /**
     * 分类列表
     * @GetMapping(path="list")
     * @return ResponseInterface
     * @author kert
     */
    public function index(): ResponseInterface
    {
        $items = $this->service->serviceSelect($this->request->all());

        return $this->httpResponse->success($items);
    }
}