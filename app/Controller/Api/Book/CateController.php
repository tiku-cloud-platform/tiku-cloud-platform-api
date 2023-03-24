<?php
declare(strict_types = 1);

namespace App\Controller\Api\Book;

use App\Controller\ApiBaseController;
use App\Service\Api\Book\CateService;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Psr\Http\Message\ResponseInterface;

/**
 * 教程分类
 * @Controller(prefix="api/book/cate")
 */
class CateController extends ApiBaseController
{
    /**
     * 教程首页分类
     * @GetMapping(path="home")
     * @return ResponseInterface
     */
    public function home(): ResponseInterface
    {
        return $this->httpResponse->success((new CateService())->serviceAllSelect(["is_home" => 1, "is_second" => 1, "size" => 10]));
    }

    /**
     * 教程二级分类
     * @GetMapping(path="second")
     * @return ResponseInterface
     */
    public function second(): ResponseInterface
    {
        return $this->httpResponse->success((new CateService())->serviceAllSelect(["is_second" => 1]));
    }
}