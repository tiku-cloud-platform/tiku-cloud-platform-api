<?php
declare(strict_types = 1);

namespace App\Service\Api\Article;

use App\Mapping\Request\RequestApp;
use App\Mapping\Request\UserLoginInfo;
use App\Mapping\UUID;
use App\Repository\Api\Article\ArticleRepository;
use App\Repository\Api\Article\ReadRepository;
use App\Service\ApiServiceInterface;
use Closure;

/**
 * 阅读历史
 */
class ReadService implements ApiServiceInterface
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
        if (!empty(UserLoginInfo::getUserId())) {// 只有登录时才记录阅读历史
            $requestParams["article_uuid"] = $requestParams["uuid"];
            $requestParams['uuid']         = UUID::getUUID();
            $requestParams['store_uuid']   = RequestApp::getStoreUuid();
            $requestParams['user_uuid']    = UserLoginInfo::getUserId();
            (new ReadRepository())->repositoryCreate($requestParams);
        }
        return (new ArticleRepository())->repositoryUpdateReadNumber($requestParams["article_uuid"]) > 0;
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