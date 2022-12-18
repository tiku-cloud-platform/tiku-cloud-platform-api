<?php
declare(strict_types = 1);

namespace App\Model\Api;

/**
 * 平台内容
 * Class StorePlatformContent
 * @package App\Model\Api
 */
class StorePlatformContent extends \App\Model\Common\StorePlatformContent
{
    public $searchFields = [
        'content',
        'title',
    ];
}