<?php
declare(strict_types = 1);

namespace App\Service\Api\Article;


use App\Repository\Api\Article\CategoryRepository;
use App\Service\ApiServiceInterface;
use Closure;
use Hyperf\Di\Annotation\Inject;

/**
 * 文章分类
 *
 * Class CategoryService
 * @package App\Service\Api\Article]
 */
class CategoryService implements ApiServiceInterface
{
    public static function searchWhere(array $requestParams): Closure
    {
        return function ($query) use ($requestParams) {
            extract($requestParams);
            $query->where('uuid', '!=', '');
        };
    }

    public function serviceSelect(array $requestParams): array
    {
        // TODO 二级分类的场景待考虑
        return (new CategoryRepository)->repositorySelect(self::searchWhere($requestParams),
            (int)$requestParams['size'] ?? 20);
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