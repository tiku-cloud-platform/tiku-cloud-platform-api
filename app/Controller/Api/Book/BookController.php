<?php
declare(strict_types = 1);

namespace App\Controller\Api\Book;

use App\Controller\ApiBaseController;
use App\Request\Api\Book\UuidValidate;
use App\Request\Api\Common\PageValidate;
use App\Service\Api\Book\BookService;
use App\Service\Api\Book\ClickService;
use App\Service\Api\Book\CollectionService;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\PostMapping;
use Psr\Http\Message\ResponseInterface;
use App\Middleware\Auth\UserAuthMiddleware;

/**
 * 教程管理
 * @Controller(prefix="api/book")
 */
class BookController extends ApiBaseController
{
    /**
     * 教程列表
     * @GetMapping(path="list")
     * @return ResponseInterface
     */
    public function index(PageValidate $validate): ResponseInterface
    {
        return $this->httpResponse->success((new BookService())->serviceSelect($this->request->all()));
    }

    /**
     * 教程介绍
     * @GetMapping(path="show")
     * @param UuidValidate $validate
     * @return ResponseInterface
     */
    public function show(UuidValidate $validate): ResponseInterface
    {
        return $this->httpResponse->success((new BookService())->serviceFind($this->request->all()));
    }

    /**
     * @PostMapping("click")
     * @Middleware(UserAuthMiddleware::class)
     * @param UuidValidate $validate
     * @return ResponseInterface
     */
    public function click(UuidValidate $validate): ResponseInterface
    {
        if ((new ClickService())->serviceCreate($this->request->all())) {
            return $this->httpResponse->success();
        }
        return $this->httpResponse->error();
    }

    /**
     * @PostMapping("collection")
     * @Middleware(UserAuthMiddleware::class)
     * @param UuidValidate $validate
     * @return ResponseInterface
     */
    public function collection(UuidValidate $validate): ResponseInterface
    {
        if ((new CollectionService())->serviceCreate($this->request->all())) {
            return $this->httpResponse->success();
        }
        return $this->httpResponse->error();
    }

    /**
     * @GetMapping("get_click")
     * @Middleware(UserAuthMiddleware::class)
     * @param UuidValidate $validate
     * @return ResponseInterface
     */
    public function getClick(UuidValidate $validate): ResponseInterface
    {
        $bean = (new ClickService())->serviceFind($this->request->all());
        return $this->httpResponse->success($bean);
    }

    /**
     * @GetMapping("get_collection")
     * @Middleware(UserAuthMiddleware::class)
     * @param UuidValidate $validate
     * @return ResponseInterface
     */
    public function getCollection(UuidValidate $validate): ResponseInterface
    {
        $bean = (new CollectionService())->serviceFind($this->request->all());
        return $this->httpResponse->success($bean);
    }
}