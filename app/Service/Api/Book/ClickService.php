<?php
declare(strict_types = 1);

namespace App\Service\Api\Book;

use App\Mapping\Request\RequestApp;
use App\Mapping\Request\UserLoginInfo;
use App\Mapping\UUID;
use App\Repository\Api\Book\ClickRepository;
use App\Service\ApiServiceInterface;
use Closure;

class ClickService implements ApiServiceInterface
{
    public static function searchWhere(array $requestParams): Closure
    {
        return function ($query) use ($requestParams) {
            extract($requestParams);

            if (!empty($uuid)) {
                $query->where("book_uuid", "=", $uuid);
            }
            if (!empty($user_uuid)) {
                $query->where("user_uuid", "=", $user_uuid);
            }
        };
    }

    public function serviceSelect(array $requestParams): array
    {
        // TODO: Implement serviceSelect() method.
    }

    public function serviceCreate(array $requestParams): bool
    {
        if (RequestApp::getStoreUuid()) {
            return (new ClickRepository())->repositoryCreate([
                "book_uuid" => $requestParams["uuid"],
                "user_uuid" => UserLoginInfo::getUserId(),
                "store_uuid" => RequestApp::getStoreUuid(),
                "uuid" => UUID::getUUID(),
            ]);
        }
        return false;
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
        if (!empty(UserLoginInfo::getUserId())) {
            $requestParams["user_uuid"] = UserLoginInfo::getUserId();
            return (new ClickRepository())->repositoryFind(self::searchWhere($requestParams));
        }
        return [];
    }
}