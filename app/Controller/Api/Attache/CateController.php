<?php
declare(strict_types = 1);

namespace App\Controller\Api\Attache;

use App\Controller\ApiBaseController;
use App\Service\Api\Attache\CateService;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Psr\Http\Message\ResponseInterface;

/**
 * 附件分类
 * @Controller(prefix="api/attache_cate")
 * Class CateController
 * @package App\Controller\Api\Attache
 */
class CateController extends ApiBaseController
{
    /**
     * 附件分类
     * @GetMapping(path="list")
     * @return ResponseInterface
     */
    public function index(): ResponseInterface
    {
        return $this->httpResponse->success((new CateService())->serviceSelect($this->request->all()));
    }
}