<?php
declare(strict_types = 1);

namespace App\Service\Api\Book;

use App\Mapping\Request\RequestApp;
use App\Mapping\Request\UserLoginInfo;
use App\Mapping\UUID;
use App\Repository\Api\Book\EvaluateHistoryRepository;
use App\Service\ApiServiceInterface;
use Closure;

/**
 * 教程评价
 */
class EvaluateHistoryService implements ApiServiceInterface
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

    /**
     * 评价列表
     * @param array $requestParams
     * @return array
     */
    public function serviceSelect(array $requestParams): array
    {
        $items = (new EvaluateHistoryRepository())->repositorySelect(self::searchWhere($requestParams),
            (int)($requestParams["size"] ?? 20), ["score", "content", "user_uuid"]);
        foreach ($items["items"] as $value) {
            unset($value->user->user_uuid);
        }

        return $items;
    }

    /**
     * 创建教程评价
     * @param array $requestParams
     * @return bool
     */
    public function serviceCreate(array $requestParams): bool
    {
        $requestParams["book_uuid"] = $requestParams["uuid"];
        unset($requestParams["uuid"]);
        $requestParams["user_uuid"]  = UserLoginInfo::getUserId();
        $requestParams["uuid"]       = UUID::getUUID();
        $requestParams["store_uuid"] = RequestApp::getStoreUuid();
        return (new EvaluateHistoryRepository())->repositoryCreate($requestParams);
    }

    public function serviceUpdate(array $requestParams): int
    {
        // TODO: Implement serviceUpdate() method.
    }

    public function serviceDelete(array $requestParams): int
    {
        // TODO: Implement serviceDelete() method.
    }

    /**
     * 评分汇总
     * @param array $requestParams
     * @return array
     */
    public function serviceCollection(array $requestParams): array
    {
        return (new EvaluateHistoryRepository())->repositoryCollection((string)$requestParams["uuid"]);
    }

    /**
     * 评价详情
     * @param array $requestParams
     * @return array
     */
    public function serviceFind(array $requestParams): array
    {

    }
}