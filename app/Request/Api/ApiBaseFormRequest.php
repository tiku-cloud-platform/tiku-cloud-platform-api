<?php
declare(strict_types=1);

namespace App\Request\Api;

use Hyperf\Validation\Request\FormRequest;

/**
 * 验证异常类
 */
class ApiBaseFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
}