<?php
declare (strict_types = 1);

namespace App\Model\Common;

use App\Model\Model;

/**
 * 微信注册设备信息
 * @property int $id
 * @property string $uuid
 * @property string $store_uuid
 * @property string $mini_user_uuid
 * @property string $device_type
 * @property string $device_brand
 * @property string $device_model
 * @property string $os_name
 * @property string $os_version
 * @property string $os_language
 * @property string $os_theme
 * @property string $uni_platform
 * @property string $uni_compile_version
 * @property string $uni_runtime_version
 * @property string $app_id
 * @property string $app_name
 * @property string $app_version
 * @property string $app_version_code
 * @property string $app_wgt_version
 * @property string $app_language
 * @property string $ua
 * @property string $rom_name
 * @property string $rom_version
 * @property string $deleted_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class StoreMiniUserDevice extends Model
{
    protected $table = 'store_mini_user_device';

    protected $fillable = [
        "id",
        "uuid",
        "store_uuid",
        "mini_user_uuid",
        "device_type",
        "device_brand",
        "device_model",
        "os_name",
        "os_version",
        "os_language",
        "os_theme",
        "uni_platform",
        "uni_compile_version",
        "uni_runtime_version",
        "app_id",
        "app_name",
        "app_version",
        "app_version_code",
        "app_wgt_version",
        "app_language",
        "ua",
        "rom_name",
        "rom_version",
        "sdk_version",
    ];

    protected $casts = [
        'id' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];
}