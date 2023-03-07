<?php
declare(strict_types = 1);

namespace App\Request\Api\User;

use App\Request\Api\ApiBaseFormRequest;

/**
 * 绑定手机号
 */
class BindPhoneValidate extends ApiBaseFormRequest
{
    public function rules(): array
    {
        return [
            "code" => "required",
        ];
    }

    public function messages(): array
    {
        return [
            "code.required" => "微信code不能为空",
        ];
    }
}