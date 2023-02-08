<?php
declare(strict_types = 1);

namespace App\Repository;

use Closure;

interface ApiRepositoryInterface
{
    public function repositorySelect(Closure $closure, int $perSize, array $searchFields = []): array;

    public function repositoryCreate(array $insertInfo): bool;

    public function repositoryAdd(array $addInfo): int;

    public function repositoryFind(Closure $closure, array $searchFields = []): array;

    public function repositoryUpdate(array $updateWhere, array $updateInfo): int;

    public function repositoryDelete(array $deleteWhere): int;

    public function repositoryWhereInDelete(array $deleteWhere, string $field): int;
}
