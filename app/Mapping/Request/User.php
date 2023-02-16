<?php
declare(strict_types = 1);

namespace App\Mapping\Request;

use App\Exception\ScoreException;
use App\Service\Api\Score\CollectionService;

class User
{
    /**
     * 检查用户积分是否满足当前请求的积分配置
     * @param float $score 当前请求所需积分
     * @return void
     */
    public static function checkoutScore(float $score): void
    {
        $currentScore = (new CollectionService())->serviceFind([])["score"];
        $currentScore = str_replace(",", "", $currentScore);
        if ((float)$currentScore < $score) {
            throw new ScoreException("积分不足");
        }
    }
}