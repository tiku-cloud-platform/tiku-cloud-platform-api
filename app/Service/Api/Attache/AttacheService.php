<?php
declare(strict_types = 1);

namespace App\Service\Api\Attache;

use App\Mapping\Request\UserLoginInfo;
use App\Repository\Api\Attache\AttacheRepository;
use App\Service\ApiServiceInterface;
use Closure;

/**
 * 附件管理
 */
class AttacheService implements ApiServiceInterface
{

    public static function searchWhere(array $requestParams): Closure
    {
        return function ($query) use ($requestParams) {
            extract($requestParams);
            $query->where("is_show", "=", 1);
            $query->where("cate_uuid", "=", $cate_uuid);
            if (!empty($uuid)) {
                $query->where("uuid", "=", $uuid);
            }
        };
    }

    public function serviceSelect(array $requestParams): array
    {
        return (new AttacheRepository())->repositorySelect(self::searchWhere($requestParams),
            (int)($requestParams["size"] ?? 20),
            ["uuid", "title", "type", "file_uuid", "download_number", "created_at"]);
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
        $userInfo = UserLoginInfo::getUserLoginInfo();
        if (isset($userInfo["email"]) && $userInfo["email"] != "") {
            return (new AttacheRepository())->repositoryFind(self::searchWhere($requestParams), ["content"]);
        }
        return ["bind_email" => 2];
    }
}