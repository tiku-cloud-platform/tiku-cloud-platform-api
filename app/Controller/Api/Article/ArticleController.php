<?php
declare(strict_types = 1);

namespace App\Controller\Api\Article;


use App\Controller\ApiBaseController;
use App\Middleware\Auth\UserAuthMiddleware;
use App\Request\Store\Common\UUIDValidate;
use App\Service\Api\Article\ArticleService;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\PostMapping;
use Psr\Http\Message\ResponseInterface;

/**
 * 文章
 *
 * @Controller(prefix="api/article")
 * Class ArticleController
 * @package App\Controller\Api\Article
 */
class ArticleController extends ApiBaseController
{
    public function __construct(ArticleService $articleService)
    {
        $this->service = $articleService;
        parent::__construct($articleService);
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
        $bean = $this->service->serviceFind($this->request->all());
        return $this->httpResponse->success($bean);
    }

    /**
     * @Middleware(UserAuthMiddleware::class)
     * @PostMapping(path="click")
     * @param UUIDValidate $validate
     * @return ResponseInterface
     */
    public function click(UUIDValidate $validate)
    {
        $updateResult = $this->service->serviceClick($this->request->all());
        return $updateResult ? $this->httpResponse->success() : $this->httpResponse->error();
    }
}