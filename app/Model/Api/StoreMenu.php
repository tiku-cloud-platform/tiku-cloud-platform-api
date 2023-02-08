<?php
declare(strict_types = 1);

namespace App\Model\Api;

/**
 * 用户端菜单
 * Class StoreMenu
 * @package App\Model\Api
 */
class StoreMenu extends \App\Model\Common\StoreMenu
{
    protected $hidden = [
        "file_uuid",
    ];
}