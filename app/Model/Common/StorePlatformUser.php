<?php

declare(strict_types = 1);
/**
 * This file is part of api.
 *
 * @link     https://www.qqdeveloper.io
 * @document https://www.qqdeveloper.wiki
 * @contact  2665274677@qq.com
 * @license  Apache2.0
 */

namespace App\Model\Common;

use App\Model\BaseModel;
use Hyperf\Database\Model\Relations\HasOne;

/**
 * 微信用户
 *
 * Class StoreWeChatUser
 */
class StorePlatformUser extends BaseModel
{
    protected $table = 'store_platform_user';

    protected $fillable = [
        'uuid',
        'real_name',
        'mobile',
        'store_uuid',
        'user_uuid',
        'is_show',
        'store_platform_user_group_uuid',
        "remark",
        "channel_uuid",
        "birthday",
        "gender",
        "email",
        "password",
        "age",
    ];

    protected $hidden = [
        "created_at",
        "deleted_at",
        "updated_at",
        "id",
    ];

    // 生日
    public function getBirthdayAttribute($key): string
    {
        if (!empty($key)) {
            $birthday = explode("-", $key);
            if (!empty((int)$birthday[0])) {
                return $key;
            }
        }
        return "";
    }

    // 真实姓名
    public function getRealNameAttribute($key): string
    {
        return !empty($key) ? $key : '';
    }

    // 手机号
    public function getMobileAttribute($key): string
    {
        return !empty($key) ? $key : '';
    }

    /**
     * 会员信息
     * @return HasOne
     */
    public function level(): HasOne
    {
        return $this->hasOne(StorePlatformUserGroup::class, "uuid",
            "store_platform_user_group_uuid");
    }

    /**
     * 微信小程序信息
     * @return HasOne
     */
    public function mini(): HasOne
    {
        return $this->hasOne(StoreMiNiWeChatUser::class, "user_uuid",
            "uuid");
    }
}
