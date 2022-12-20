<?php
declare(strict_types=1);

namespace App\Service\Api\User;

use App\Service\ApiServiceInterface;
use Closure;

/**
 * 用户注册
 */
class RegisterService implements ApiServiceInterface
{
    /**
     * @param array $requestParams
     * @return Closure
     */
    public static function searchWhere(array $requestParams): Closure
    {
        // TODO: Implement searchWhere() method.
    }

    public function serviceSelect(array $requestParams): array
    {
        // TODO: Implement serviceSelect() method.
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