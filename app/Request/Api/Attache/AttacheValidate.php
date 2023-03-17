<?php
declare(strict_types = 1);

namespace App\Request\Api\Attache;

use App\Request\Api\ApiBaseFormRequest;

/**
 * 附件验证
 */
class AttacheValidate extends ApiBaseFormRequest
{
    public function rules(): array
    {
        return [
            "size" => "required|max:20",
            "cate_uuid" => "required|exists:store_attache_cate,uuid"
        ];
    }

    public function messages(): array
    {
        return [
            "size.required" => "分页大小不能为空",
            "size.max" => "分页错误",
            "cate_uuid.required" => "分类不存在",
            "cate_uuid.exists" => "分类不存在",
        ];
    }
}