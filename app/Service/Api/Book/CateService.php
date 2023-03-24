<?php
declare(strict_types = 1);

namespace App\Service\Api\Book;

use App\Repository\Api\Book\CateRepository;
use App\Service\ApiServiceInterface;
use Closure;

/**
 * 教程分类
 */
class CateService implements ApiServiceInterface
{

    public static function searchWhere(array $requestParams): Closure
    {
        return function ($query) use ($requestParams) {
            extract($requestParams);
            $query->whereNull("parent_uuid");
            if (!empty($is_home)) {
                $query->where("is_home", "=", $is_home);
            }
        };
    }

    public function serviceAllSelect(array $requestParams): array
    {
        return (new CateRepository())->repositoryAll(self::searchWhere($requestParams),
            (int)($requestParams["size"] ?? 20), ["uuid", "title"]);
    }

    public function serviceSelect(array $requestParams): array
    {
        return [];
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