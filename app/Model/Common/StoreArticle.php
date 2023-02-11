<?php
declare(strict_types = 1);

namespace App\Model\Common;


use App\Mapping\Request\UserLoginInfo;
use App\Model\BaseModel;
use Hyperf\Database\Model\Relations\BelongsTo;

/**
 * 文章管理
 *
 * Class StoreArticle
 * @package App\Model\Common
 */
class StoreArticle extends BaseModel
{
    protected $table = 'store_article';

    protected $fillable = [
        'uuid',
        'article_category_uuid',
        'store_uuid',
        'title',
        'file_uuid',
        'content',
        'publish_date',
        'author',
        'source',
        'read_number',
        'orders',
        'is_show',
        'is_top',
    ];

    protected $appends = [
        "is_click",
        "is_collection",
    ];

    public function getIsClickAttribute(): bool
    {
        if (!empty(UserLoginInfo::getUserId())) {
            if ((new StoreArticleClick())::query()->where([
                ["article_uuid", "=", $this->getAttribute("uuid")],
                ["user_uuid", "=", UserLoginInfo::getUserId()]
            ])->first(["id"])) {
                return true;
            }
        }

        return false;
    }

    public function getIsCollectionAttribute(): bool
    {
        if (!empty(UserLoginInfo::getUserId())) {
            if ((new StoreArticleCollection())::query()->where([
                ["article_uuid", "=", $this->getAttribute("uuid")],
                ["user_uuid", "=", UserLoginInfo::getUserId()]
            ])->first(["id"])) {
                return true;
            }
        }
        return false;
    }

    /**
     * 文章封面
     * @return BelongsTo
     * @author kert
     */
    public function image(): BelongsTo
    {
        return $this->belongsTo(StorePlatformFile::class, 'file_uuid', 'uuid');
    }

    /**
     * 文章分类
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(StoreArticleCategory::class, 'category_uid', 'uuid');
    }
}