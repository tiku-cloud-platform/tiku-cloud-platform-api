<?php
declare(strict_types = 1);

namespace App\Controller\Api\File;

use App\Constants\CacheKey;
use App\Controller\ApiBaseController;
use App\Mapping\RedisClient;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\Middlewares;
use App\Middleware\Auth\UserAuthMiddleware;
use Psr\Http\Message\ResponseInterface;
use Qiniu\Auth;
use RedisException;

/**
 * 文件上传token
 * @Middlewares({
 *     @Middleware(UserAuthMiddleware::class)
 * })
 * @Controller(prefix="api/file")
 */
class UploadTokenController extends ApiBaseController
{
    /**
     * 文件上传token
     * @GetMapping(path="upload_token")
     * @return ResponseInterface
     */
    public function get(): ResponseInterface
    {
        $auth  = new Auth(env("FILE_A"), env("FILE_K"));
        $token = $auth->uploadToken(env("FILE_B"));

        return $this->response->json([
            "uptoken" => $token
        ]);
    }
}