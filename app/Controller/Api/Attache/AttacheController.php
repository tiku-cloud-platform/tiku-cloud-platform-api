<?php
declare(strict_types = 1);

namespace App\Controller\Api\Attache;

use App\Controller\ApiBaseController;
use App\Request\Api\Attache\AttacheValidate;
use App\Request\Api\Attache\UuidValidate;
use App\Service\Api\Attache\AttacheService;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middleware;
use Psr\Http\Message\ResponseInterface;
use App\Middleware\Auth\UserAuthMiddleware;

/**
 * 附件管理
 * @Controller(prefix="api/attache")
 * Class CateController
 * @package App\Controller\Api\Attache
 */
class AttacheController extends ApiBaseController
{
    /**
     * @GetMapping(path="list")
     * @param AttacheValidate $validate
     * @return ResponseInterface
     */
    public function index(AttacheValidate $validate): ResponseInterface
    {
        return $this->httpResponse->success((new AttacheService())->serviceSelect($this->request->all()));
    }

    /**
     * @GetMapping(path="show")
     * @Middleware(UserAuthMiddleware::class)
     * @param UuidValidate $validate
     * @return ResponseInterface
     */
    public function show(UuidValidate $validate): ResponseInterface
    {
        return $this->httpResponse->success((new AttacheService())->serviceFind($this->request->all()));
    }
}