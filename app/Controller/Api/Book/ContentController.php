<?php
declare(strict_types = 1);

namespace App\Controller\Api\Book;

use App\Controller\ApiBaseController;
use App\Request\Api\Book\UuidValidate;
use App\Service\Api\Book\ContentService;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Psr\Http\Message\ResponseInterface;

/**
 * 教程管理
 * @Controller(prefix="api/book/content")
 */
class ContentController extends ApiBaseController
{
    /**
     * @GetMapping(path="first")
     * @param UuidValidate $validate
     * @return ResponseInterface
     */
    public function first(UuidValidate $validate): ResponseInterface
    {
        return $this->httpResponse->success((new ContentService())->serviceFirst($this->request->all()));
    }
}