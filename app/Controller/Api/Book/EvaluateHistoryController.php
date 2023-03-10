<?php
declare(strict_types = 1);

namespace App\Controller\Api\Book;

use App\Controller\ApiBaseController;
use App\Request\Api\Book\EvaluateValidate;
use App\Service\Api\Book\EvaluateHistoryService;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\Middleware;
use App\Middleware\Auth\UserAuthMiddleware;
use Hyperf\HttpServer\Annotation\PostMapping;
use Psr\Http\Message\ResponseInterface;

/**
 * 教程评价
 * @Controller(prefix="api/book/evaluate")
 */
class EvaluateHistoryController extends ApiBaseController
{
    /**
     * 教程评价提交
     * @Middleware(UserAuthMiddleware::class)
     * @PostMapping(path="submit")
     * @param EvaluateValidate $validate
     * @return ResponseInterface
     */
    public function create(EvaluateValidate $validate): ResponseInterface
    {
        if ((new EvaluateHistoryService())->serviceCreate($this->request->all())) {
            return $this->httpResponse->success(["msg" => "评价成功"]);
        }
        return $this->httpResponse->error(["msg" => "评价失败"]);
    }
}