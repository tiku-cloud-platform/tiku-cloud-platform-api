<?php
declare(strict_types = 1);

namespace App\Service\Api\Book;

use App\Repository\Api\Book\EvaluateHistoryRepository;
use App\Service\ApiServiceInterface;
use Closure;

class EvaluateHistoryService implements ApiServiceInterface
{

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

    public function serviceFind(array $requestParams): array
    {
        // TODO: Implement serviceFind() method.
    }
}