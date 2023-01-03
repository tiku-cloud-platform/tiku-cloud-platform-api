<?php
declare(strict_types = 1);

namespace App\Controller\Api\Rank;

use App\Controller\ApiBaseController;
use App\Request\Api\Rank\ExamNumberValidate;
use App\Service\Api\Rank\ExamService;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Psr\Http\Message\ResponseInterface;

/**
 * 答题排行榜
 *
 * @Controller(prefix="rank/exam")
 * Class ExamRankController
 * @package App\Controller\Api\Rank
 */
class ExamRankController extends ApiBaseController
{
    /**
     * @GetMapping(path="list")
     * @param ExamNumberValidate $numberValidate
     * @return ResponseInterface
     */
    public function index(ExamNumberValidate $numberValidate)
    {
        $items = (new ExamService)->serviceSelect($this->request->all());

        return $this->httpResponse->success($items);
    }
}