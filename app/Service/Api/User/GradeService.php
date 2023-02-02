<?php
declare(strict_types = 1);

namespace App\Service\Api\User;

use App\Repository\Api\User\GradeRepository;
use App\Service\ApiServiceInterface;
use Closure;

/**
 * 会员等级
 */
class GradeService implements ApiServiceInterface
{

    public static function searchWhere(array $requestParams): Closure
    {
        return function ($query) use ($requestParams) {
        };
    }

    public function serviceSelect(array $requestParams): array
    {
        return (new GradeRepository())->repositorySelect(self::searchWhere($requestParams),
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
        return (new GradeRepository())->repositoryFind(self::searchWhere($requestParams));
    }
}