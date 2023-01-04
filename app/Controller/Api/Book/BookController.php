<?php
declare(strict_types = 1);

namespace App\Controller\Api\Book;

use App\Controller\ApiBaseController;
use App\Request\Store\Common\UUIDValidate;
use App\Service\Api\Book\BookService;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Psr\Http\Message\ResponseInterface;

/**
 * @Controller(prefix="api/book")
 */
class BookController extends ApiBaseController
{
    /**
     * 书籍列表
     * @GetMapping(path="list")
     * @return ResponseInterface
     */
    public function index(): ResponseInterface
    {
        return $this->httpResponse->success((new BookService())->serviceSelect($this->request->all()));
    }

    /**
     * 书籍介绍
     * @GetMapping(path="show")
     * @param UUIDValidate $validate
     * @return ResponseInterface
     */
    public function show(UUIDValidate $validate): ResponseInterface
    {
        return $this->httpResponse->success((new BookService())->serviceFind($this->request->all()));
    }
}