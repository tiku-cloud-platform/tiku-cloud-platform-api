<?php
declare(strict_types = 1);

namespace App\Exception\Handler;

use App\Constants\ErrorCode;
use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\HttpMessage\Exception\NotFoundHttpException;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Hyperf\HttpServer\Contract\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Hyperf\Di\Annotation\Inject;
use Throwable;

/**
 * 请求地址不存在异常处理器.
 * Class NotFundHttpExceptionHandler
 */
class NotFundHttpExceptionHandler extends ExceptionHandler
{
    /**
     * @Inject
     * @var RequestInterface
     */
    protected $request;

    public function handle(Throwable $throwable, ResponseInterface $response)
    {
        if ($throwable instanceof NotFoundHttpException) {
            $data = json_encode([
                'code' => empty($throwable->getCode()) ? ErrorCode::REQUEST_ERROR : $throwable->getCode(),
                'message' => '请求地址不存在',
                'data' => [],
            ]);
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
