<?php
declare(strict_types = 1);

namespace App\Controller\Api\Book;

use App\Controller\ApiBaseController;
use App\Service\Api\Book\CollectionService;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middlewares;
use App\Middleware\Auth\UserAuthMiddleware;
use Psr\Http\Message\ResponseInterface;
use Hyperf\HttpServer\Annotation\Middleware;

/**
 * 教程收藏
 * @Controller(prefix="api/book/collection")
 * @Middlewares({
 *     @Middleware(UserAuthMiddleware::class)
 * })
 */
class CollectionController extends ApiBaseController
{
    /**
     * 收藏总数
     * @GetMapping(path="count")
     * @return ResponseInterface
     */
    public function count(): ResponseInterface
    {
        return $this->httpResponse->success(["count" => (new CollectionService())->serviceCount()]);
    }

    /**
     * 收藏列表
     * @GetMapping(path="list")
     * @return ResponseInterface
     */
    public function list(): ResponseInterface
    {
        return $this->httpResponse->success((new CollectionService())->serviceSelect($this->request->all()));
    }
}