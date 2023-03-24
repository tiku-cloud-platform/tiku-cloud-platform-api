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
            if (!empty($cate_uuid)) {
                $query->where("cate_uuid", "=", $cate_uuid);
            }
            if (!empty($is_recommend)) {
                $query->where("is_recommend", "=", $is_recommend);
            }
            if (!empty($level)) {
                if ($level == 1) {
                    $query->whereBetween("level", [1, 3]);
                }
                if ($level == 2) {
                    $query->whereBetween("level", [3, 4]);
                }
                if ($level == 3) {
                    $query->whereBetween("level", [4, 3]);
                }
            }
            if (!empty($title)) {
                $query->where("title", "like", "%" . $title . "%");
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