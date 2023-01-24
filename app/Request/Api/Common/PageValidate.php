<?php
declare(strict_types = 1);

namespace App\Request\Api\Common;

use App\Controller\ApiBaseController;

/**
 * 列表条数限制
 */
class PageValidate extends ApiBaseController
{
    public function rules(): array
    {
        return [
            "page" => "required|integer",
            "size" => "required|between:1,100|integer",
        ];
    }

    public function messages(): array
    {
        return [
            "page.required" => "当前页码不能为空",
            "page.integer" => "当前页码必须是数字",
            "size.required" => "分页大小不能为空",
            "size.between" => "分页大小只能是1-100之间",
            "size.integer" => "分页大小必须是数字",
        ];
    }
}