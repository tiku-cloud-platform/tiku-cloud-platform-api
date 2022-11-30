<?php
declare(strict_types = 1);

namespace App\Model\Api;


/**
 * 平台积分配置
 *
 * Class StorePlatformScore
 * @package App\Model\Api
 */
class StorePlatformScore extends \App\Model\Common\StorePlatformScore
{
    public $searchFields = [
        'score',
        'title',
        'uuid',
        'key',
    ];
}