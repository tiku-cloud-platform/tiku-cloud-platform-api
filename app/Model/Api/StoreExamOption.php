<?php
declare(strict_types=1);

namespace App\Model\Api;

/**
 * 试题
 *
 * Class StoreExamOption
 * @package App\Model\Api
 */
class StoreExamOption extends \App\Model\Common\StoreExamOption
{
    public $listSearchFields = [
        'uuid as id',
        'title',
        'file_uuid',
        'answer',
        'analysis',
        'level',
    ];

    protected $appends = [
        'type',// 1单选题2多选题
    ];

    public function getTypeAttribute()
    {
        return count(explode(',', $this->attributes['answer'])) > 1 ? 1 : 2;
    }

    public function relationCollection()
    {
        return $this->belongsTo(StoreExamCollectionRelation::class, 'uuid', 'exam_uuid');
    }
}