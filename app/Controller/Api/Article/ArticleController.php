<?php
declare(strict_types = 1);

namespace App\Controller\Api\Article;


use App\Controller\ApiBaseController;
use App\Middleware\Auth\UserAuthMiddleware;
use App\Request\Api\Article\UuidValidate;
use App\Request\Api\Common\PageValidate;
use App\Service\Api\Article\ArticleService;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\PostMapping;
use Psr\Http\Message\ResponseInterface;
use App\Middleware\Auth\UserEmptyAuthMiddleware;

/**
 * 文章管理
 * @Controller(prefix="api/article")
 * Class ArticleController
 * @package App\Controller\Api\Article
 */
class ArticleController extends ApiBaseController
{
    /**
     * 文章列表
     * @GetMapping(path="list")
     * @param PageValidate $validate
     * @return ResponseInterface
     */
    public function index(PageValidate $validate): ResponseInterface
    {
        $items = (new ArticleService)->serviceSelect($this->request->all());
        return $this->httpResponse->success($items);
    }

    /**
     * 文章详情
     * @GetMapping(path="detail")
     * @Middleware(UserEmptyAuthMiddleware::class)
     * @param UuidValidate $validate
     * @return ResponseInterface
     */
    public function show(UuidValidate $validate): ResponseInterface
    {
        $bean = (new ArticleService)->serviceFind($this->request->all());
        return $this->httpResponse->success($bean);
    }

    /**
     * 文章点赞
     * @Middleware(UserAuthMiddleware::class)
     * @PostMapping(path="click")
     * @param UuidValidate $validate
     * @return ResponseInterface
     */
    public function click(UuidValidate $validate): ResponseInterface
    {
        $updateResult = (new ArticleService)->serviceClick($this->request->all());
        return $updateResult ? $this->httpResponse->success() : $this->httpResponse->error();
    }

    /**
     * 文章收藏
     * @Middleware(UserAuthMiddleware::class)
     * @PostMapping(path="collection")
     * @param UuidValidate $validate
     * @return ResponseInterface
     */
    public function collection(UuidValidate $validate): ResponseInterface
    {
        $collectionResult = (new ArticleService)->serviceClick($this->request->all());
        if ($collectionResult) {
            return $this->httpResponse->success();
        }
        return $this->httpResponse->error();
    }
}