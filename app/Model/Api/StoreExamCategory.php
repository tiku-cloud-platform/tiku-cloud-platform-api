<?php
declare(strict_types = 1);

namespace App\Model\Api;

/**
 * 试卷分类
 *
 * Class StoreExamCategory
 * @package App\Model\Api
 */
class StoreExamCategory extends \App\Model\Common\StoreExamCategory
{
    public $listSearchFields = [
        'uuid as uid',
        'title',
        'file_uuid',
        'big_file_uuid',
        'parent_uuid',
    ];

    protected $hidden = [
        "big_file_uuid",
        "file_uuid",
        "parent_uuid",
    ];
}