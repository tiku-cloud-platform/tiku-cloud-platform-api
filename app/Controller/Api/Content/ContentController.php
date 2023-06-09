<?php
declare(strict_types = 1);

namespace App\Controller\Api\Content;

use App\Controller\ApiBaseController;
use App\Service\Api\Content\ContentService;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Psr\Http\Message\ResponseInterface;

/**
 * 平台内容
 * @Controller(prefix="api/content")
 * Class ContentController
 * @package App\Controller\Api\Common
 */
class ContentController extends ApiBaseController
{
    /**
     * 内容详情
     * @GetMapping(path="detail")
     * @return ResponseInterface
     */
    public function show(): ResponseInterface
    {
        $bean = (new ContentService)->serviceFind($this->request->all());
        return $this->httpResponse->success($bean);
    }
}