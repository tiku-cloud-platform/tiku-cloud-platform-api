<?php
declare(strict_types = 1);

namespace App\Model\Api;

/**
 * 用户端菜单
 *
 * Class StoreMenu
 * @package App\Model\Api
 */
class StoreMenu extends \App\Model\Common\StoreMenu
{
    public $searchFields = [
        'title',
        'file_uuid',
        'url',
        'type',
    ];

    protected $hidden = [
        "file_uuid",
    ];
}