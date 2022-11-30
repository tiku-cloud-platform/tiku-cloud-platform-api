<?php
declare(strict_types = 1);

namespace App\Model\Api;


/**
 * 用户积分汇总
 *
 * Class StoreUserSignCollection
 * @package App\Model\Api
 */
class StoreUserSignCollection extends \App\Model\Common\StoreUserSignCollection
{
    public $searchFields = [
        'uuid',
        'user_uuid',
        'sign_number',
    ];
}