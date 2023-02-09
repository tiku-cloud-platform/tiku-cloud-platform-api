<?php
declare(strict_types = 1);

namespace App\Service\Api\Article;

use App\Mapping\Request\RequestApp;
use App\Mapping\Request\UserLoginInfo;
use App\Mapping\UUID;
use App\Repository\Api\Article\ArticleRepository;
use App\Repository\Api\Article\ShareRepository;
use App\Service\ApiServiceInterface;
use Closure;

/**
 * 文章分享统计
 */
class ShareService implements ApiServiceInterface
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
        if (in_array($requestParams["share_type"] ?? 0, [1, 2])) {
            $requestParams['share_type'] = $requestParams["share_type"];
        }
        if (!empty($requestParams["user_uuid"])) {// 只有登录时才记录用户的分享信息
            (new ShareRepository())->repositoryCreate($requestParams);
        }
        if ((new ArticleRepository())->repositoryUpdateShareNumber($requestParams["article_uuid"])) {
            return true;
        }
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