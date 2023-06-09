<?php
declare(strict_types = 1);

namespace App\Model\Api;

use Hyperf\Database\Model\Relations\BelongsTo;

/**
 * 问答试题
 * Class StoreExamReading
 * @package App\Model\Api
 */
class StoreExamReading extends \App\Model\Common\StoreExamReading
{
    /**
     * 试卷信息
     * @return BelongsTo
     */
    public function relationCollection(): BelongsTo
    {
        return $this->belongsTo(StoreExamReadingCollectionRelation::class, 'uuid', 'exam_uuid');
    }
}