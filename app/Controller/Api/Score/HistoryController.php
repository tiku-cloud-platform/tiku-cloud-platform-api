<?php
declare(strict_types = 1);

namespace App\Controller\Api\Score;

use App\Controller\ApiBaseController;
use App\Request\Api\Common\PageValidate;
use App\Service\Api\Score\HistoryService;
use Hyperf\HttpServer\Annotation\Controller;
use App\Middleware\Auth\UserAuthMiddleware;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\Middlewares;
use Psr\Http\Message\ResponseInterface;

/**
 * 积分历史
 * @Controller(prefix="api/score/history")
 * @Middlewares({
 *     @Middleware(UserAuthMiddleware::class)
 * })
 */
class HistoryController extends ApiBaseController
{
    /**
     * @GetMapping(path="list")
     * @param PageValidate $pageValidate
     * @return ResponseInterface
     */
    public function index(PageValidate $pageValidate): ResponseInterface
    {
        return $this->httpResponse->success((new HistoryService())->serviceSelect($this->request->all()));
    }
}