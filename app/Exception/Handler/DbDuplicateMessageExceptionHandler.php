<?php
declare(strict_types = 1);

namespace App\Exception\Handler;

use App\Constants\ErrorCode;
use App\Exception\DbDuplicateMessageException;
use App\Mapping\RedisClient;
use App\Mapping\UUID;
use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Psr\Http\Message\ResponseInterface;
use Throwable;

/**
 * 数据库索引重复提示
 * Class DbDuplicateMessageExceptionHandler
 */
class DbDuplicateMessageExceptionHandler extends ExceptionHandler
{
    public function handle(Throwable $throwable, ResponseInterface $response)
    {
        if ($throwable instanceof DbDuplicateMessageException) {
            $data = json_encode([
                'code' => empty($throwable->getCode()) ? ErrorCode::REQUEST_ERROR : $throwable->getCode(),
                'message' => env('APP_ENV') == 'dev' ? $throwable->getMessage() . $throwable->getFile() . $throwable->getLine() : $throwable->getMessage(),
                'data' => [],
                "request_id" => UUID::snowFlakeId(),
            ]);
            RedisClient::getInstance()->lPush("log_queue", $throwable->getFile() . $throwable->getLine() . $throwable->getMessage());
            $this->stopPropagation();
            return $response->withStatus(200)->withBody(new SwooleStream($data));
        }

        return $response;
    }

    public function isValid(Throwable $throwable): bool
    {
        return true;
    }
}
