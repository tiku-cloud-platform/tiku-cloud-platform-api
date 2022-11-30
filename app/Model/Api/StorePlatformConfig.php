<?php
declare(strict_types=1);

namespace App\Model\Api;

/**
 * 平台参数配置
 *
 * Class StorePlatformConfig
 * @package App\Model\Api
 */
class StorePlatformConfig extends \App\Model\Common\StorePlatformConfig
{
	public $searchFields = [
		'title',
		'type',
		'values',
		'store_uuid',
	];
}