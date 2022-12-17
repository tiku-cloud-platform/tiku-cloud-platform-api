<?php
declare(strict_types = 1);

namespace App\Exception\Handler;

use App\Constants\ErrorCode;
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
    /**
     * @Inject
     * @var RequestInterface
     */
    protected $request;

    public function handle(Throwable $throwable, ResponseInterface $response)
    {
        if ($throwable instanceof MethodNotAllowedHttpException) {
            $data = json_encode([
                'code' => empty($throwable->getCode()) ? ErrorCode::REQUEST_ERROR : $throwable->getCode(),
                'message' => '请求方法不被允许',
                'data' => [],
            ]);
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
