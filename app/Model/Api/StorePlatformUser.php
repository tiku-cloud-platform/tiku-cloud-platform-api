<?php
declare(strict_types = 1);

namespace App\Model\Api;

use App\Model\Common\StorePlatformUser as StorePlatformUserModel;

/**
 * 微信用户.
 *
 * Class StorePlatformUser
 */
class StorePlatformUser extends StorePlatformUserModel
{
    public $searchFields = [
        'uuid',
        'openid',
        'nickname',
        'avatar_url',
        'gender',
        'country',
        'province',
        'city',
        'is_forbidden',
        'language',
        'real_name',
        'mobile',
        'address',
        'birthday',
        'login_token',
        'store_uuid',
        "remark",
    ];
}
