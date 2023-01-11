<?php
declare(strict_types = 1);

namespace App\Controller\Api\Book;

use App\Controller\ApiBaseController;
use App\Request\Store\Common\UUIDValidate;
use App\Service\Api\Book\CategoryService;
use App\Service\Api\Book\ContentService;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Psr\Http\Message\ResponseInterface;
use App\Request\Api\Book\UuidValidate as BookUuidValidate;

/**
 * 数据章节管理
 * @Controller(prefix="api/book/catalog")
 */
class CatalogController extends ApiBaseController
{
    /**
     * 数据目录
     * @GetMapping(path="catalog")
     * @param UUIDValidate $validate
     * @return ResponseInterface
     */
    public function catalog(UUIDValidate $validate): ResponseInterface
    {
        return $this->httpResponse->success((new ContentService())->serviceCatalog($this->request->all()));
    }

    /**
     * 教程目录层级列表
     * @GetMapping(path="catalog_tree")
     * @param BookUuidValidate $uuidValidate
     * @return ResponseInterface
     */
    public function catalogTree(BookUuidValidate $uuidValidate): ResponseInterface
    {
        return $this->httpResponse->success((new CategoryService())->serviceAllSelect($this->request->all()));
    }

    /**
     * 内容详情
     * @GetMapping(path="show")
     * @param UUIDValidate $validate
     * @return ResponseInterface
     */
    public function show(UUIDValidate $validate): ResponseInterface
    {
        return $this->httpResponse->success((new ContentService())->serviceFind($this->request->all()));
    }
}