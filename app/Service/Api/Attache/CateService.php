<?php
declare(strict_types = 1);

namespace App\Service\Api\Attache;

use App\Repository\Api\Attache\CateRepository;
use App\Service\ApiServiceInterface;
use Closure;

/**
 * 附件分类
 */
class CateService implements ApiServiceInterface
{

    public static function searchWhere(array $requestParams): Closure
    {
        return function ($query) use ($requestParams) {
            extract($requestParams);
            $query->where("is_show", "=", 1);
        };
    }

    public function serviceSelect(array $requestParams): array
    {
        return (new CateRepository())->repositoryAll(self::searchWhere($requestParams));
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
        // TODO: Implement serviceFind() method.
    }
}