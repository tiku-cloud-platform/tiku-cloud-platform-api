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
     * @throws RedisException
     */
    public function get(): ResponseInterface
    {
        $redis = RedisClient::getInstance();
        $token = $redis->get(CacheKey::CLOUD_PLATFORM_FILE_TOKEN . env("FILE_A"));
        if (empty($token)) {
            $auth  = new Auth(env("FILE_A"), env("FILE_B"));
            $token = $auth->uploadToken(env("FILE_B"));
            $redis->set(CacheKey::CLOUD_PLATFORM_FILE_TOKEN . env("FILE_A"), $token, 7000);
        }
        return $this->httpResponse->success([
            "token" => $token,
        ]);
    }
}