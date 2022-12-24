<?php
declare(strict_types=1);

namespace App\Request\Api\Exam\Record;

use App\Request\Api\ApiBaseFormRequest;

/**
 * 问答试题验证
 */
class ReadingValidate extends ApiBaseFormRequest
{
    public function rules(): array
    {
        return [
            "uuid" => "required|uuid|exists:store_exam_reading,uuid"
        ];
    }

    public function messages(): array
    {
        return [
            "uuid.required" => "试题编号不能为空",
            "uuid.uuid" => "试题编号格式错误",
            "uuid.exists" => "试题编号不存在",
        ];
    }
}