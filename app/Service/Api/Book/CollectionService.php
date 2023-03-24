<?php
declare(strict_types = 1);

namespace App\Service\Api\Book;

use App\Mapping\Request\RequestApp;
use App\Mapping\Request\UserLoginInfo;
use App\Mapping\UUID;
use App\Model\Api\StoreBookCollection;
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
            if (!empty($user_uuid)) {
                $query->where("user_uuid", "=", $user_uuid);
            }
        };
    }

    /**
     * 收藏总数
     * @return int
     */
    public function serviceCount(): int
    {
        return (new CollectionRepository())->repositoryCount(UserLoginInfo::getUserId());
    }

    public function serviceSelect(array $requestParams): array
    {
        $requestParams["user_uuid"] = UserLoginInfo::getUserId();
        return (new CollectionRepository())->repositorySelect(self::searchWhere($requestParams), (int)($requestParams["size"] ?? 20),
            ["book_uuid"]);
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
        if (!empty(UserLoginInfo::getUserId())) {
            $requestParams["user_uuid"] = UserLoginInfo::getUserId();
            return (new CollectionRepository())->repositoryFind(self::searchWhere($requestParams));
        }
        return [];
    }
}