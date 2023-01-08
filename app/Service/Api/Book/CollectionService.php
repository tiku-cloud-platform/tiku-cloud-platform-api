<?php
declare(strict_types = 1);

namespace App\Service\Api\Book;

use App\Mapping\Request\RequestApp;
use App\Mapping\Request\UserLoginInfo;
use App\Mapping\UUID;
use App\Repository\Api\Book\CollectionRepository;
use App\Service\ApiServiceInterface;
use Closure;

class CollectionService implements ApiServiceInterface
{
    public static function searchWhere(array $requestParams): Closure
    {
        return function ($query) use ($requestParams) {
            extract($requestParams);
            if (!empty($uuid)) {
                $query->where("book_uuid", "=", $uuid);
            }
        };
    }

    public function serviceSelect(array $requestParams): array
    {
        // TODO: Implement serviceSelect() method.
    }

    public function serviceCreate(array $requestParams): bool
    {
        return (new CollectionRepository())->repositoryCreate([
            "book_uuid" => $requestParams["uuid"],
            "user_uuid" => UserLoginInfo::getUserId(),
            "store_uuid" => RequestApp::getStoreUuid(),
            "uuid" => UUID::getUUID(),
        ]);
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
        return (new CollectionRepository())->repositoryFind(self::searchWhere($requestParams));
    }
}