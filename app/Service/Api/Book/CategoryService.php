<?php
declare(strict_types = 1);

namespace App\Service\Api\Book;

use App\Repository\Api\Book\CategoryRepository;
use App\Service\ApiServiceInterface;
use Closure;

class CategoryService implements ApiServiceInterface
{
    public static function searchWhere(array $requestParams): Closure
    {
        return function ($query) use ($requestParams) {
            extract($requestParams);
            if (!empty($book_uuid)) {
                $query->where("store_book_uuid", "=", $book_uuid);
            }
        };
    }

    public function serviceAllSelect(array $requestParams): array
    {
        $requestParams["book_uuid"] = $requestParams["uuid"];
        unset($requestParams["uuid"]);
        return (new CategoryRepository())->repositoryAllSelect(self::searchWhere($requestParams));
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

    public function serviceFind(array $requestParams): array
    {
        // TODO: Implement serviceFind() method.
    }
}