<?php
declare(strict_types = 1);

namespace App\Exception\Handler;

use App\Constants\ErrorCode;
use App\Exception\DbDataMessageException;
use App\Mapping\RedisClient;
use App\Mapping\UUID;
use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Psr\Http\Message\ResponseInterface;
use Throwable;

/**
 * 数据库数据操作异常处理器.
 * Class DbDataMessageExceptionHandler
 */
class DbDataMessageExceptionHandler extends ExceptionHandler
{
    public function handle(Throwable $throwable, ResponseInterface $response)
    {
        if ($throwable instanceof DbDataMessageException) {
            $data = json_encode([
                'code' => empty($throwable->getCode()) ? ErrorCode::REQUEST_ERROR : $throwable->getCode(),
                'message' => env('APP_ENV') == 'dev' ? $throwable->getMessage() . $throwable->getFile() . $throwable->getLine() : ErrorCode::getMessage(ErrorCode::REQUEST_ERROR),
                'data' => [],
                "request_id" => UUID::snowFlakeId(),
            ]);
            RedisClient::getInstance()->lPush("log_queue", json_encode([
                "code" => 500,
                "desc" => "系统级别错误信息",
                "package" => "data_log",
                "span" => "data",
                "error_log_file" => $throwable->getFile(),
                "error_log_line" => $throwable->getLine(),
                "error_log_message" => $throwable->getMessage()
            ]));
            $this->stopPropagation();
            return $response->withStatus(500)->withBody(new SwooleStream($data));
        }

        return $response;
    }

    public function isValid(Throwable $throwable): bool
    {
        return true;
    }
}
