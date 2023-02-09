<?php
declare(strict_types = 1);

namespace App\Service\Api\Platform;


use App\Repository\Api\Platform\BannerRepository;
use App\Service\ApiServiceInterface;
use Closure;
use Hyperf\Di\Annotation\Inject;

/**
 * 轮播图
 * Class BannerService
 * @package App\Service\Api\Platform
 */
class BannerService implements ApiServiceInterface
{
    public static function searchWhere(array $requestParams): Closure
    {
        return function ($query) use ($requestParams) {
            extract($requestParams);
            if (!empty($position)) {
                $query->where('position_position', '=', $position);
            }
            if (!empty($client)) {
                $query->where("client_position", "=", $client);
            }
        };
    }

    public function serviceSelect(array $requestParams): array
    {
        if (!isset($requestParams["client"]) || !isset($requestParams["position"])) {
            return [];
        }
        return (new BannerRepository)->repositorySelect(self::searchWhere($requestParams),
            (int)($requestParams['size'] ?? 20));
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