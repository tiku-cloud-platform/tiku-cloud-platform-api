<?php
declare(strict_types = 1);

namespace App\Exception\Handler;

use App\Constants\ErrorCode;
use App\Mapping\RedisClient;
use App\Mapping\UUID;
use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\HttpMessage\Exception\MethodNotAllowedHttpException;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Hyperf\HttpServer\Contract\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Hyperf\Di\Annotation\Inject;
use Throwable;

/**
 * 请求方法不被允许异常.
 * Class NotFundHttpExceptionHandler
 */
class MethodNotAllowedHttpExceptionHandler extends ExceptionHandler
{
    public function handle(Throwable $throwable, ResponseInterface $response): ResponseInterface
    {
        if ($throwable instanceof MethodNotAllowedHttpException) {
            $data = json_encode([
                'code' => empty($throwable->getCode()) ? ErrorCode::REQUEST_ERROR : $throwable->getCode(),
                'message' => '请求方法不被允许',
                'data' => [],
                "request_id" => UUID::snowFlakeId(),
            ]);
            RedisClient::getInstance()->lPush("log_queue", $throwable->getFile() . $throwable->getLine() . $throwable->getMessage());
            $this->stopPropagation();
            return $response->withStatus(405)->withBody(new SwooleStream($data));
        }

        return $response;
    }

    public function isValid(Throwable $throwable): bool
    {
        return true;
    }
}
