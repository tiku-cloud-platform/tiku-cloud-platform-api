<?php
declare(strict_types = 1);

namespace App\Request\Store\Common;

use Hyperf\Validation\Request\FormRequest;

/**
 * 详情传递uuid验证
 * Class UUIDValidate
 */
class UUIDValidate extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'uuid' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'uuid.required' => '数据编号不能为空',
        ];
    }
}
