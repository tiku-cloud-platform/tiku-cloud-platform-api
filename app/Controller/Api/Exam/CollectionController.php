<?php
declare(strict_types = 1);

namespace App\Controller\Api\Exam;

use App\Controller\ApiBaseController;
use App\Request\Api\Common\PageValidate;
use App\Service\Api\Exam\CollectionService;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Psr\Http\Message\ResponseInterface;

/**
 * 试卷
 *
 * @Controller(prefix="api/exam/collection")
 * Class CollectionController
 * @package App\Controller\Api\Exam
 */
class CollectionController extends ApiBaseController
{
    /**
     * @GetMapping(path="list")
     * @param PageValidate $validate
     * @return ResponseInterface
     */
    public function index(PageValidate $validate): ResponseInterface
    {
        $items = (new CollectionService())->serviceSelect($this->request->all());
        return $this->httpResponse->success($items);
    }

    /**
     * @GetMapping(path="show")
     * @return ResponseInterface
     */
    public function show(): ResponseInterface
    {
        $bean = (new CollectionService())->serviceFind($this->request->all());
        return $this->httpResponse->success($bean);
    }
}