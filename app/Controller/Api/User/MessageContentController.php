<?php
declare(strict_types = 1);

namespace App\Controller\Api\User;

use App\Controller\ApiBaseController;
use App\Middleware\Auth\UserAuthMiddleware;
use App\Request\Store\Common\UUIDValidate;
use App\Service\Api\User\MessageContentService;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\Middlewares;
use Psr\Http\Message\ResponseInterface;

/**
 * @Middlewares({
 *     @Middleware(UserAuthMiddleware::class)
 *     })
 * @Controller(prefix="api/v1/user/message/content")
 * Class MessageContentController
 * @package App\Controller\Api\Api
 */
class MessageContentController extends ApiBaseController
{
    public function __construct(MessageContentService $contentService)
    {
        $this->service = $contentService;
        parent::__construct($contentService);
    }

    /**
     * @GetMapping(path="list")
     * @return ResponseInterface
     */
    public function index()
    {
        $items = $this->service->serviceSelect($this->request->all());

        return $this->httpResponse->success($items);
    }

    /**
     * @GetMapping(path="show")
     * @param UUIDValidate $validate
     * @return ResponseInterface
     */
    public function show(UUIDValidate $validate)
    {
        $items = $this->service->serviceFind($this->request->all());

        return $this->httpResponse->success($items);
    }
}