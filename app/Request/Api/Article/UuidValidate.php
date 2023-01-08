<?php
declare(strict_types = 1);

namespace App\Request\Api\Article;

use App\Request\Api\ApiBaseFormRequest;

/**
 * 文章uuid验证
 */
class UuidValidate extends ApiBaseFormRequest
{
    public function rules(): array
    {
        return [
            "uuid" => "required|uuid|exists:store_article,uuid",
        ];
    }

    public function messages(): array
    {
        return [
            "uuid.required" => "文章编号不能为空",
            "uuid.uuid" => "文章编号格式不正确",
            "uuid.exists" => "文章编号不存在",
        ];
    }
}