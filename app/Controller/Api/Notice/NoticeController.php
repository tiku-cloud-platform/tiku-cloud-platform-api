<?php
declare(strict_types = 1);

namespace App\Controller\Api\Notice;

use App\Controller\ApiBaseController;
use App\Request\Api\Common\PageValidate;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Psr\Http\Message\ResponseInterface;

/**
 * @Controller(prefix="api/notice")
 */
class NoticeController extends ApiBaseController
{
    /**
     * @GetMapping(path="list")
     * @param PageValidate $pageValidate
     * @return ResponseInterface
     */
    public function list(PageValidate $pageValidate): ResponseInterface
    {
        return $this->httpResponse->success([
            "items" => [
                ["title" => "程序员面试题大全正式发布v1.0.0版本", "path" => "", "type" => ""],
                ["title" => "题库云开发赋能已全面发布", "path" => "", "type" => ""],
                ["title" => "更新最新Redis大厂面试题", "path" => "", "type" => ""],
            ],
            "page" => 1,
            "size" => 20,
            "total" => 10,
        ]);
    }
}