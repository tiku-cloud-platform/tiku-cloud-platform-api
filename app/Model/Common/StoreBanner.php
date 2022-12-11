<?php
declare(strict_types = 1);

namespace App\Model\Common;


use App\Model\BaseModel;
use Hyperf\Database\Model\Relations\BelongsTo;

/**
 * 平台轮播图
 *
 * Class StoreBanner
 * @package App\Model\Common
 */
class StoreBanner extends BaseModel
{
    protected $table = 'store_banner';

    protected $fillable = [
        'uuid',
        'title',
        'file_uuid',
        'orders',
        'url',
        'position',
        'is_show',
        'store_uuid',
        'type',
        'client_position',
    ];


    protected $hidden = [
        "file_uuid",
    ];

    public function image(): BelongsTo
    {
        return $this->belongsTo(StorePlatformFile::class, 'file_uuid', 'uuid');
    }

    public function getTitleAttribute($key): string
    {
        return empty($key) ? '' : $key;
    }
}