<?php
declare(strict_types = 1);

namespace App\Request\Api\Book;

use App\Request\Api\ApiBaseFormRequest;

/**
 * 教程编号验证
 */
class UuidValidate extends ApiBaseFormRequest
{
    public function rules(): array
    {
        return [
            "uuid" => "required|uuid|exists:store_book,uuid",
        ];
    }

    public function messages(): array
    {
        return [
            "uuid.required" => "教程编号不能为空",
            "uuid.uuid" => "教程编号格式不正确",
            "uuid.exists" => "教程编号不存在",
        ];
    }
}