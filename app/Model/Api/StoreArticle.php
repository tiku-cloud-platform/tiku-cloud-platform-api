<?php
declare(strict_types = 1);

namespace App\Model\Api;


use App\Mapping\UserInfo;

/**
 * 文章
 *
 * Class StoreArticle
 * @package App\Model\Api
 */
class StoreArticle extends \App\Model\Common\StoreArticle
{
    /**
     * 详情查询字段
     *
     * @var array
     */
    public $searchFields = [
        'uuid',
        'article_category_uuid as category_uid',
        'title',
        'file_uuid',
        'content',
        'publish_date',
        'author',
        'source',
        'read_number',
        'click_number',
    ];

    /**
     * 列表查询字段
     *
     * @var array
     */
    public $listSearchFields = [
        'uuid as uid',
        'title',
        'file_uuid',
        'source',
        'read_number',
        'author',
        "article_category_uuid as category_uid",
        "click_number",
    ];

    protected $appends = [
        'is_click',
        'is_read'
    ];

    public function getIsClickAttribute($key)
    {
//        $userInfo = UserInfo::getWeChatUserInfo();
//        if (!empty($userInfo)) {
//            if (!empty(StoreArticleReadClick::query()->where([
//                ['article_uuid', '=', $this->attributes['uuid']],
//                ['user_uuid', '=', $userInfo['user_uuid']],
//                ['type', '=', 1]
//            ])->first(['uuid']))) {
//                return 1;
//            }
//            return 0;
//        }

        return 0;
    }

    public function getIsReadAttribute($key)
    {
//        $userInfo = UserInfo::getWeChatUserInfo();
//        if (!empty($userInfo)) {
//            if (!empty(StoreArticleReadClick::query()->where([
//                ['article_uuid', '=', $this->attributes['uuid']],
//                ['user_uuid', '=', $userInfo['user_uuid']],
//                ['type', '=', 2]
//            ])->first(['uuid']))) {
//                return 1;
//            }
//            return 0;
//        }

        return 0;
    }
}