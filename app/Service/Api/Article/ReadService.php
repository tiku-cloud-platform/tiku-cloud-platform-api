<?php
declare(strict_types = 1);

namespace App\Service\Api\Article;

use App\Constants\CacheKey;
use App\Mapping\RedisClient;
use App\Mapping\Request\RequestApp;
use App\Mapping\Request\UserLoginInfo;
use App\Mapping\UUID;
use App\Repository\Api\Article\ArticleRepository;
use App\Repository\Api\Article\ReadRepository;
use App\Service\ApiServiceInterface;
use Closure;

/**
 * 阅读历史
 */
class ReadService implements ApiServiceInterface
{

    public static function searchWhere(array $requestParams): Closure
    {
        return function () {
        };
    }

    public function serviceSelect(array $requestParams): array
    {
        return [];
    }

    public function serviceCreate(array $requestParams): bool
    {
        // 将数据写入Redis中，实现异步队列消费方式存储到数据库中
        $cacheArticle = [
            "article_uuid" => $requestParams["uuid"],
            "store_uuid" => RequestApp::getStoreUuid(),
            "user_uuid" => UserLoginInfo::getUserId(),
        ];
        $len          = RedisClient::getInstance()->lPush(CacheKey::ARTICLE_QUEUE, json_encode($cacheArticle, JSON_UNESCAPED_UNICODE));
        return is_integer($len);
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
        return [];
    }
}