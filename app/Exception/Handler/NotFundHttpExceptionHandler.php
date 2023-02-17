<?php
declare(strict_types = 1);

namespace App\Exception\Handler;

use App\Constants\ErrorCode;
use App\Mapping\RedisClient;
use App\Mapping\UUID;
use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\HttpMessage\Exception\NotFoundHttpException;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Psr\Http\Message\ResponseInterface;
use Throwable;

/**
 * 请求地址不存在异常处理器.
 * Class NotFundHttpExceptionHandler
 */
class NotFundHttpExceptionHandler extends ExceptionHandler
{
    public function handle(Throwable $throwable, ResponseInterface $response): ResponseInterface
    {
        if ($throwable instanceof NotFoundHttpException) {
            $data = json_encode([
                'code' => empty($throwable->getCode()) ? ErrorCode::REQUEST_ERROR : $throwable->getCode(),
                'message' => '请求地址不存在',
                'data' => [],
                "request_id" => UUID::snowFlakeId(),
            ]);
            RedisClient::getInstance()->lPush("log_queue", $throwable->getFile() . $throwable->getLine() . $throwable->getMessage());
            $this->stopPropagation();
            return $response->withStatus(404)->withBody(new SwooleStream($data));
        }
        return $response;
    }

    public function isValid(Throwable $throwable): bool
    {
        return true;
    }
}
