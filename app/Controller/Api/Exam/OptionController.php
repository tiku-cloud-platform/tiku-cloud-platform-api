<?php
declare(strict_types = 1);

namespace App\Controller\Api\Exam;

use App\Controller\ApiBaseController;
use App\Middleware\Auth\UserAuthMiddleware;
use App\Request\Api\Common\PageValidate;
use App\Service\Api\Exam\OptionService;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\Middlewares;
use Psr\Http\Message\ResponseInterface;

/**
 * 单选试题
 *
 * @Middlewares({
 *     @Middleware(UserAuthMiddleware::class)
 *     })
 * @Controller(prefix="api/exam/option")
 * Class OptionController
 * @package App\Controller\Api\Exam
 */
class OptionController extends ApiBaseController
{
    /**
     * @GetMapping(path="list")
     * @param PageValidate $pageValidate
     * @return ResponseInterface
     */
    public function index(PageValidate $pageValidate): ResponseInterface
    {
        $items = (new OptionService)->serviceSelect($this->request->all());
        return $this->httpResponse->success($items);
    }
}