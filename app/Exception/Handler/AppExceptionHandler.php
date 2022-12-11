<?php
declare(strict_types = 1);

namespace App\Exception\Handler;

use App\Constants\ErrorCode;
use App\Constants\HttpCode;
use Cassandra\Exception\ValidationException;
use Hyperf\Contract\StdoutLoggerInterface;
use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Psr\Http\Message\ResponseInterface;
use Throwable;

class AppExceptionHandler extends ExceptionHandler
{
    /**
     * @var StdoutLoggerInterface
     */
    protected $logger;

    public function __construct(StdoutLoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function handle(Throwable $throwable, ResponseInterface $response)
    {
        if ($throwable instanceof ValidationException) {
            echo $throwable->getMessage();
        }
        $this->logger->error(sprintf('%s[%s] in %s', $throwable->getMessage(), $throwable->getLine(), $throwable->getFile()));
        $this->logger->error($throwable->getTraceAsString());

        $data = json_encode([
            'code' => ErrorCode::REQUEST_ERROR,
            'message' => env('APP_ENV') == 'dev' ? $throwable->getMessage() . $throwable->getFile() . $throwable->getLine() : ErrorCode::getMessage(ErrorCode::REQUEST_ERROR),
            'data' => [],
        ]);
        return $response->withStatus(HttpCode::SERVER_ERROR)->withBody(new SwooleStream($data));
    }

    public function isValid(Throwable $throwable): bool
    {
        return true;
    }
}
