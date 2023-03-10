<?php
declare(strict_types = 1);

namespace App\Request\Api\Book;

use App\Request\Api\ApiBaseFormRequest;

/**
 * 教程评价
 */
class EvaluateValidate extends ApiBaseFormRequest
{
    public function rules(): array
    {
        return [
            "uuid" => "required|uuid|exists:store_book,uuid",
            "score" => "required|max:10.00|min:0.01",
            "content" => "required|min:10|max:200"
        ];
    }

    public function messages(): array
    {
        return [
            "uuid.required" => "教程编号不能为空",
            "uuid.uuid" => "教程编号格式不正确",
            "uuid.exists" => "教程编号不存在",
            "score.required" => "评分不能为空",
            "score.max" => "评分最大10",
            "score.min" => "评分最小0.01",
            "content.required" => "点评内容不能为空",
            "content.min" => "点评内容最大10字",
            "content.max" => "点评内容最大200字",
        ];
    }
}