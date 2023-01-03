<?php
declare(strict_types = 1);

namespace App\Controller\Api\Exam;

use App\Controller\ApiBaseController;
use App\Middleware\Auth\UserAuthMiddleware;
use App\Request\Store\Common\UUIDValidate;
use App\Service\Api\Exam\ReadingService;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\Middlewares;
use Psr\Http\Message\ResponseInterface;

/**
 * 问答试题
 * @Middlewares({
 *     @Middleware(UserAuthMiddleware::class)
 *     })
 * @Controller(prefix="api/exam/reading")
 * Class ReadingController
 * @package App\Controller\Api\Exam
 */
class ReadingController extends ApiBaseController
{
    /**
     * 问答试题列表
     * @GetMapping(path="list")
     * @param UUIDValidate $validate
     * @return ResponseInterface
     */
    public function index(UUIDValidate $validate): ResponseInterface
    {
        $items = (new ReadingService)->serviceSelect($this->request->all());
        return $this->httpResponse->success($items);
    }

    /**
     * 问答试题详情
     * @GetMapping(path="detail")
     * @param UUIDValidate $validate
     * @return ResponseInterface
     */
    public function show(UUIDValidate $validate): ResponseInterface
    {
        $items = (new ReadingService)->serviceFind($this->request->all());
        return $this->httpResponse->success($items);
    }
}