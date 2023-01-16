<?php
declare(strict_types = 1);

namespace App\Service\Api\Score;

use App\Mapping\Request\UserLoginInfo;
use App\Repository\Api\Score\HistoryRepository;
use App\Service\ApiServiceInterface;
use Closure;

/**
 * 积分历史
 */
class HistoryService implements ApiServiceInterface
{

    public static function searchWhere(array $requestParams): Closure
    {
        return function ($query) use ($requestParams) {
            extract($requestParams);
            $query->where("user_uuid", "=", UserLoginInfo::getUserId());
            if ((int)$type !== 0) {
                $query->where("type", "=", $type);
            }
        };
    }

    public function serviceSelect(array $requestParams): array
    {
        return (new HistoryRepository())->repositorySelect(self::searchWhere($requestParams),
            (int)($requestParams["size"] ?? 20));
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

    public function serviceFind(array $requestParams): array
    {
        return [];
    }
}