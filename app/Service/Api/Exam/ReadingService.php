<?php
declare(strict_types = 1);

namespace App\Service\Api\Exam;

use App\Constants\CacheKey;
use App\Mapping\RedisClient;
use App\Mapping\Request\RequestApp;
use App\Mapping\Request\User;
use App\Mapping\Request\UserLoginInfo;
use App\Repository\Api\Exam\ReadingRepository;
use App\Service\ApiServiceInterface;
use Closure;
use Throwable;

/**
 * 问答试题
 *
 * Class ReadingService
 * @package App\Service\Api\Exam
 */
class ReadingService implements ApiServiceInterface
{
    public static function searchWhere(array $requestParams): Closure
    {
        return function ($query) use ($requestParams) {
            extract($requestParams);
            if (!empty($collection_uuid)) {
                $query->where('collection_uuid', '=', $collection_uuid);
            }
            if (!empty($uuid)) {
                $query->where('uuid', '=', $uuid);
            }
        };
    }

    public function serviceSelect(array $requestParams): array
    {
        $requestParams["collection_uuid"] = $requestParams["uuid"];
        unset($requestParams["uuid"]);
        $items = (new ReadingRepository())->repositorySelect(self::searchWhere($requestParams),
            (int)$requestParams['size'] ?? 20);
        foreach ($items["items"] as $item) {
            unset($item->relationCollection);
        }
        return $items;
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
        $exam = (new ReadingRepository())->repositoryFind(self::searchWhere($requestParams));
        User::checkoutScore((float)$exam["expend_score"]);
        if (!empty($exam["income_score"]) || !empty($exam["expend_score"])) {
            RedisClient::getInstance()->lPush(CacheKey::EXAM_READING, json_encode([
                "exam_uuid" => $requestParams["uuid"],
                "income_score" => $exam["income_score"],
                "expend_score" => $exam["expend_score"],
                "client_type" => 1,
                "user_uuid" => UserLoginInfo::getUserId(),
                "store_uuid" => RequestApp::getStoreUuid(),
            ]));
        }

        return $exam;
    }
}