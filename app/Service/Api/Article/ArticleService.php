<?php
declare(strict_types = 1);

namespace App\Service\Api\Article;

use App\Mapping\RedisClient;
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
        $items = (new ArticleRepository)->repositorySelect(self::searchWhere($requestParams),
            (int)$requestParams['size'] ?? 20);

        foreach ($items["items"] as $item) {
            $item->img = $item->image["url"] . $item->image["name"];
            unset($item->image);
        }
        return $items;
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
            try {
                RedisClient::getInstance()->lPush("article_queue", $bean["uuid"]);
            } catch (Throwable $throwable) {
                // TODO 抛出异常
            }
        }
        return $bean;
    }

    public function serviceClick(array $requestParams): int
    {
        if ((new ReadClickService())->serviceCreate(['article_uuid' => $requestParams['uuid'], 'type' => 1])) {
            return (new ArticleRepository)->repositoryUpdateClickNumber((string)$requestParams['uuid']);
        }
        return 0;
    }

    public function serviceCollection(array $requestParams): int
    {
        if ((new ReadClickService())->serviceCreate(['article_uuid' => $requestParams['uuid'], 'type' => 2])) {
            return (new ArticleRepository)->repositoryUpdateCollectionNumber((string)$requestParams['uuid']);
        }
        return 0;
    }
}