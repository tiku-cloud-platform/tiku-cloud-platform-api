<?php
declare(strict_types=1);

namespace App\Controller\Api\Exam\Record;

use App\Controller\ApiBaseController;
use App\Request\Api\Exam\Record\ReadingValidate;
use App\Service\Api\Exam\Record\ReadingService;
use App\Service\ApiServiceInterface;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\Middlewares;
use Hyperf\HttpServer\Annotation\Middleware;
use App\Middleware\Auth\UserAuthMiddleware;
use Hyperf\HttpServer\Annotation\PostMapping;
use Psr\Http\Message\ResponseInterface;

/**
 * 问答试题记录
 * @Middlewares({
 *     @Middleware(UserAuthMiddleware::class)
 * })
 * @Controller(prefix="api/exam/record")
 */
class ReadingController extends ApiBaseController
{
    public function __construct(ReadingService $readingService)
    {
        $this->service = $readingService;
        parent::__construct($readingService);
    }

    /**
     * 添加阅读试题记录
     * @PostMapping(path="add")
     * @param ReadingValidate $validate
     * @return ResponseInterface
     */
    public function create(ReadingValidate $validate): ResponseInterface
    {
        if ($this->service->serviceCreate($this->request->all())) {
            return $this->httpResponse->success();
        }
        return $this->httpResponse->error();
    }
}