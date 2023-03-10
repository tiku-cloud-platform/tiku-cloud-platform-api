<?php
declare(strict_types = 1);

namespace App\Controller\Api\Book;

use App\Controller\ApiBaseController;
use App\Request\Api\Book\EvaluateValidate;
use App\Request\Api\Book\UuidValidate;
use App\Request\Api\Common\PageValidate;
use App\Service\Api\Book\EvaluateHistoryService;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
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
            return $this->httpResponse->success(["msg" => "点评成功"]);
        }
        return $this->httpResponse->error(["msg" => "点评失败"]);
    }

    /**
     * 评价列表
     * @GetMapping(path="list")
     * @param UuidValidate $validate
     * @param PageValidate $pageValidate
     * @return ResponseInterface
     */
    public function list(UuidValidate $validate, PageValidate $pageValidate): ResponseInterface
    {
        return $this->httpResponse->success((new EvaluateHistoryService())->serviceSelect($this->request->all()));
    }

    /**
     * 评价详情
     * @GetMapping(path="show")
     * @param UuidValidate $validate
     * @return ResponseInterface
     */
    public function show(UuidValidate $validate): ResponseInterface
    {
        return $this->httpResponse->success((new EvaluateHistoryService())->serviceCollection($this->request->all()));
    }
}