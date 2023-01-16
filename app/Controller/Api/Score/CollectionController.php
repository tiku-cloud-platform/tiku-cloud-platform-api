<?php
declare(strict_types = 1);

namespace App\Controller\Api\Score;

use App\Controller\ApiBaseController;
use App\Service\Api\Score\CollectionService;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middlewares;
use Hyperf\HttpServer\Annotation\Middleware;
use App\Middleware\Auth\UserAuthMiddleware;
use Psr\Http\Message\ResponseInterface;

/**
 * 积分汇总
 * @Controller(prefix="api/score")
 * @Middlewares({
 *     @Middleware(UserAuthMiddleware::class)
 * })
 */
class CollectionController extends ApiBaseController
{
    /**
     * @GetMapping(path="collection")
     * @return ResponseInterface
     */
    public function show(): ResponseInterface
    {
        return $this->httpResponse->success((new CollectionService())->serviceFind($this->request->all()));
    }
}