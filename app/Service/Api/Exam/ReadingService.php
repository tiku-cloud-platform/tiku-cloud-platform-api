<?php
declare(strict_types = 1);

namespace App\Service\Api\Exam;

use App\Mapping\RedisClient;
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
        try {
            RedisClient::getInstance()->lPush("exam_reading", $requestParams["uuid"]);
        } catch (Throwable $throwable) {
            // TODO 记录错误信息
        } finally {
            return (new ReadingRepository())->repositoryFind(self::searchWhere($requestParams));
        }
    }
}