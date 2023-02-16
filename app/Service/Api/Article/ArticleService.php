<?php
declare(strict_types = 1);

namespace App\Service\Api\Article;

use App\Constants\CacheKey;
use App\Exception\ScoreException;
use App\Mapping\RedisClient;
use App\Mapping\Request\RequestApp;
use App\Mapping\Request\User;
use App\Mapping\Request\UserLoginInfo;
use App\Model\Common\StoreUser;
use App\Repository\Api\Article\ArticleRepository;
use App\Service\ApiServiceInterface;
use Closure;
use Throwable;

/**
 * 文章
 * Class ArticleService
 * @package App\Service\Api\Article
 */
class ArticleService implements ApiServiceInterface
{
    public static function searchWhere(array $requestParams): Closure
    {
        return function ($query) use ($requestParams) {
            extract($requestParams);
            if (!empty($uuid)) {
                $query->where('uuid', '=', $uuid);
            }
            if (!empty($category_uuid)) {
                $query->where('article_category_uuid', '=', $category_uuid);
            }
            if (!empty($is_top)) {
                $query->where('is_top', '=', 1);
            }
        };
    }

    public function serviceSelect(array $requestParams): array
    {
        return (new ArticleRepository)->repositorySelect(self::searchWhere($requestParams),
            (int)$requestParams['size'] ?? 20);
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
        $bean = (new ArticleRepository)->repositoryFind(self::searchWhere($requestParams));
        if (!empty($bean)) {
            if (!empty(UserLoginInfo::getUserId())) {
                User::checkoutScore((float)$bean["read_expend_score"]);
            }
            (new ReadService())->serviceCreate(["uuid" => $requestParams["uuid"]]);
        }
        return $bean;
    }
}