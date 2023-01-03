<?php
declare(strict_types = 1);

namespace App\Controller\Api\Rank;

use App\Controller\ApiBaseController;
use App\Service\Api\Rank\ScoreService;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Psr\Http\Message\ResponseInterface;

/**
 * 积分排行
 *
 * @Controller(prefix="api/v1/score")
 * Class ScoreRankController
 * @package App\Controller\Api\Rank
 */
class ScoreRankController extends ApiBaseController
{
    /**
     * @GetMapping(path="list")
     * @return ResponseInterface
     */
    public function index()
    {
        $items = (new ScoreService)->serviceGroup($this->request->all());
        return $this->httpResponse->success($items);
    }
}