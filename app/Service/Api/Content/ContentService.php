<?php
declare(strict_types = 1);

namespace App\Service\Api\Content;


use App\Repository\Api\Platform\ContentRepository;
use App\Service\ApiServiceInterface;
use Closure;
use Hyperf\Di\Annotation\Inject;
use function Swoole\Coroutine\Http\request;

/**
 * 平台内容
 * Class ContentService
 * @package App\Service\Api\Platform
 */
class ContentService implements ApiServiceInterface
{
    public static function searchWhere(array $requestParams): Closure
    {
        return function ($query) use ($requestParams) {
            extract($requestParams);
            if (!empty($uuid)) {
                $query->where('uuid', '=', $uuid);
            }
        };
    }

    public function serviceSelect(array $requestParams): array
    {
        return [];
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
        if (empty($requestParams["uuid"])) {
            return [];
        }
        return (new ContentRepository)->repositoryFind(self::searchWhere($requestParams));
    }
}