<?php
declare(strict_types = 1);

namespace App\Request\Api\User\Login;

use Hyperf\Validation\Request\FormRequest;

/**
 * 微信登录code验证
 */
class CodeValidate extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "code" => "required",
        ];
    }

    public function messages(): array
    {
        return [
            "code.required" => "登录code不能为空"
        ];
    }
}