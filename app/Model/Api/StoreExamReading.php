<?php
declare(strict_types = 1);

namespace App\Model\Api;

/**
 * 问答试题
 *
 * Class StoreExamReading
 * @package App\Model\Api
 */
class StoreExamReading extends \App\Model\Common\StoreExamReading
{
    public $listSearchFields = [
        'uuid',
        'title',
        'content',
    ];

    public function relationCollection()
    {
        return $this->belongsTo(StoreExamReadingCollectionRelation::class, 'uuid', 'exam_uuid');
    }
}