<?php
declare(strict_types = 1);

namespace App\Service\Api\Book;

use App\Repository\Api\Book\ContentRepository;
use App\Service\ApiServiceInterface;
use Closure;

/**
 * 数据内容管理
 */
class ContentService implements ApiServiceInterface
{
    public static function searchWhere(array $requestParams): Closure
    {
        return function ($query) use ($requestParams) {
            extract($requestParams);
            if (!empty($book_uuid)) {
                $query->where("store_book_uuid", "=", $book_uuid);
            }
            if (!empty($uuid)) {
                $query->where("uuid", "=", $uuid);
            }
        };
    }

    /**
     * 书籍目录
     * @param $requestParams
     * @return array
     */
    public function serviceCatalog($requestParams): array
    {
        $requestParams["book_uuid"] = $requestParams["uuid"];
        unset($requestParams["uuid"]);
        return (new ContentRepository())->repositoryCatalog(self::searchWhere($requestParams),
            (int)$requestParams["size"] ?? 20);
    }

    public function serviceSelect(array $requestParams): array
    {
        // TODO: Implement serviceSelect() method.
    }

    public function serviceCreate(array $requestParams): bool
    {
        // TODO: Implement serviceCreate() method.
    }

    public function serviceUpdate(array $requestParams): int
    {
        // TODO: Implement serviceUpdate() method.
    }

    public function serviceDelete(array $requestParams): int
    {
        // TODO: Implement serviceDelete() method.
    }

    /**
     * 内容详情
     * @param array $requestParams
     * @return array
     */
    public function serviceFind(array $requestParams): array
    {
        return (new ContentRepository())->repositoryFind(self::searchWhere($requestParams));
    }
}