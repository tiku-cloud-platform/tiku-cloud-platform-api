<?php
declare(strict_types = 1);

namespace App\Exception\Handler;

use App\Constants\ErrorCode;
use App\Exception\ScoreException;
use App\Mapping\RedisClient;
use App\Mapping\UUID;
use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Psr\Http\Message\ResponseInterface;
use Throwable;

/**
 * 积分不足处理异常
 */
class ScoreExceptionHandler extends ExceptionHandler
{
    public function handle(Throwable $throwable, ResponseInterface $response): ResponseInterface
    {
        if ($throwable instanceof ScoreException) {
            $data = json_encode([
                'code' => empty($throwable->getCode()) ? ErrorCode::REQUEST_SUCCESS : $throwable->getCode(),
                'message' => '积分不足',
                'data' => [],
                "request_id" => UUID::snowFlakeId(),
            ]);
            RedisClient::getInstance()->lPush("log_queue", json_encode([
                "code" => 500,
                "desc" => "系统级别错误信息",
                "package" => "business_log",
                "span" => "business",
                "error_log_file" => $throwable->getFile(),
                "error_log_line" => $throwable->getLine(),
                "error_log_message" => $throwable->getMessage()
            ]));
            $this->stopPropagation();
            return $response->withStatus(302)->withBody(new SwooleStream($data));
        }
        return $response;
    }

    public function isValid(Throwable $throwable): bool
    {
        return true;
    }
}