<?php
declare(strict_types = 1);

namespace App\Service\Api\Score;

use App\Constants\CacheKey;
use App\Mapping\RedisClient;
use App\Mapping\Request\UserLoginInfo;
use App\Repository\Api\Score\CollectionRepository;
use App\Service\ApiServiceInterface;
use Closure;

/**
 * 积分汇总
 */
class CollectionService implements ApiServiceInterface
{

    public static function searchWhere(array $requestParams): Closure
    {
        return function ($query) use ($requestParams) {
            extract($requestParams);
            $query->where("user_uuid", "=", UserLoginInfo::getUserId());
        };
    }

    public function serviceSelect(array $requestParams): array
    {
        return [];
    }

    public function serviceCreate(array $requestParams): bool
    {
        return false;
    }

    public function serviceUpdate(array $requestParams): int
    {
        return 0;
    }

    public function serviceDelete(array $requestParams): int
    {
        return 0;
    }

    public function serviceFind(array $requestParams): array
    {
        $score = RedisClient::getInstance()->get(CacheKey::SCORE_TOTAL . UserLoginInfo::getUserId());
        if (empty($score)) {
            $score = (new CollectionRepository())->repositoryFind(self::searchWhere($requestParams));
            RedisClient::getInstance()->set(CacheKey::SCORE_TOTAL . UserLoginInfo::getUserId(), $score["score"]);
            $score = $score["score"];
        }
        return [
            "score" => number_format((float)$score, 2),
        ];
    }
}