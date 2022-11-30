<?php
declare(strict_types = 1);

namespace App\Model\Api;

/**
 * 轮播图
 *
 * Class StoreBanner
 * @package App\Model\Api
 */
class StoreBanner extends \App\Model\Common\StoreBanner
{
    public $searchFields = [
        'title',
        'file_uuid',
        'url',
        'type',
    ];
}