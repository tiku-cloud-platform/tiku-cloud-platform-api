<?php
declare(strict_types = 1);

namespace App\Service\Api\Article;

use App\Mapping\Request\RequestApp;
use App\Mapping\Request\UserLoginInfo;
use App\Mapping\UUID;
use App\Repository\Api\Article\CollectionRepository;
use App\Service\ApiServiceInterface;
use Closure;

class CollectionService implements ApiServiceInterface
{

    public static function searchWhere(array $requestParams): Closure
    {
        return function () {
        };
    }

    public function serviceSelect(array $requestParams): array
    {
        return [];
    }

    public function serviceCreate(array $requestParams): bool
    {
        $requestParams["article_uuid"] = $requestParams["uuid"];
        $requestParams['uuid']         = UUID::getUUID();
        $requestParams['store_uuid']   = RequestApp::getStoreUuid();
        $requestParams['user_uuid']    = UserLoginInfo::getUserId();

        return (new CollectionRepository())->repositoryCreate($requestParams);
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