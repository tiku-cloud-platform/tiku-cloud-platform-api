<?php
declare(strict_types = 1);

namespace App\Mapping;

use App\Constants\ErrorCode;
use Godruoyi\Snowflake\Snowflake;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Psr\Http\Message\ResponseInterface as Psr7ResponseInterface;

/**
 * 接口响应参数处理.
 *
 * Class HttpDataResponse
 */
class HttpDataResponse
{
    /**
     * @Inject
     * @var ResponseInterface
     */
    protected $response;

    /**
     * 成功时返回数据格式.
     *
     * @param array $data 业务数据
     * @param int $code 业务状态码
     * @param string $message 业务状态信息
     * @param int $httpCode 网络状态码
     * @return Psr7ResponseInterface
     */
    public function success(array $data = [], int $code = 0, string $message = '', int $httpCode = 200): Psr7ResponseInterface
    {
        return $this->response->json([
            'code' => empty($code) ? ErrorCode::REQUEST_SUCCESS : $code,
            'message' => empty($message) ? ErrorCode::getMessage(ErrorCode::REQUEST_SUCCESS) : $message,
            'data' => $data,
            "request_id" => UUID::snowFlakeId(),
        ])->withStatus($httpCode);
    }

    /**
     * 失败时返回数据格式.
     *
     * @param int $code 业务状态码
     * @param string $message 业务状态信息
     * @param array $data 业务数据
     * @param int $httpCode 网络状态码
     * @return Psr7ResponseInterface
     */
    public function error(array $data = [], int $code = 0, string $message = '', int $httpCode = 200): Psr7ResponseInterface
    {
        return $this->response->json([
            'code' => empty($code) ? ErrorCode::REQUEST_ERROR : $code,
            'message' => empty($message) ? ErrorCode::getMessage(ErrorCode::REQUEST_ERROR) : $message,
            'data' => $data,
            "request_id" => UUID::snowFlakeId(),
        ])->withStatus($httpCode);
    }

    /**
     * 自定义返回数据格式.
     *
     * @param string $message 业务状态信息
     * @param int $code 业务状态码
     * @param array $data 业务数据
     * @param int $httpCode 网络请求状态码
     * @return Psr7ResponseInterface
     */
    public function response(string $message, int $code = 0, array $data = [], int $httpCode = 500): Psr7ResponseInterface
    {
        return $this->response->json([
            'code' => empty($code) ? ErrorCode::REQUEST_ERROR : $code,
            'message' => $message,
            'data' => $data,
            "request_id" => UUID::snowFlakeId(),
        ])->withStatus($httpCode);
    }
}
