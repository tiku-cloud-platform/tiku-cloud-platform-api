<?php
declare(strict_types = 1);

namespace App\Service\Api\Book;

use App\Repository\Api\Book\BookRepository;
use App\Service\ApiServiceInterface;
use Closure;

/**
 * 书籍查询
 */
class BookService implements ApiServiceInterface
{
    public static function searchWhere(array $requestParams): Closure
    {
        return function ($query) use ($requestParams) {
            extract($requestParams);
            if (!empty($uuid)) {
                $query->where("uuid", "=", $uuid);
            }
        };
    }

    /**
     * 列表查询
     * @param array $requestParams
     * @return array
     */
    public function serviceSelect(array $requestParams): array
    {
        return (new BookRepository)->repositorySelect(self::searchWhere($requestParams),
            (int)$requestParams["size"] ?? 20);
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

    public function serviceFind(array $requestParams): array
    {
        return (new BookRepository())->repositoryFind(self::searchWhere($requestParams));
    }
}