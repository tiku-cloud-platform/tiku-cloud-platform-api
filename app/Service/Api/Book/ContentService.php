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

    public function serviceFirst($requestParams): array
    {
        return (new ContentRepository())->repositoryFind(function ($query) use ($requestParams) {
            $query->where("store_book_uuid", "=", $requestParams["uuid"]);
        });
    }

    /**
     * 内容详情
     * @param array $requestParams
     * @return array
     */
    public function serviceFind(array $requestParams): array
    {
        $contentRepository = new ContentRepository();
        $bean              = $contentRepository->repositoryFind(self::searchWhere($requestParams));
        if (!empty($bean)) {
            $contentRepository->repositoryIncrement([
                ["uuid", "=", $bean["uuid"]]
            ], "read_number");
        }
        return $bean;
    }
}