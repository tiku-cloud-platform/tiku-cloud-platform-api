<?php
declare(strict_types = 1);

namespace App\Controller\Api\Exam;

use App\Controller\ApiBaseController;
use App\Service\Api\Exam\CategoryService;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Psr\Http\Message\ResponseInterface;

/**
 * 试题分类
 *
 * @Controller(prefix="api/v1/exam/category")
 * Class CategoryController
 * @package App\Controller\Api\Exam
 */
class CategoryController extends ApiBaseController
{
    public function __construct(CategoryService $categoryService)
    {
        $this->service = $categoryService;
        parent::__construct($categoryService);
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