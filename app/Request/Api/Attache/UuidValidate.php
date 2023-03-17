<?php
declare(strict_types = 1);

namespace App\Request\Api\Attache;

use App\Request\Api\ApiBaseFormRequest;

class UuidValidate extends ApiBaseFormRequest
{
    public function rules(): array
    {
        return [
            "uuid" => "required|exists:store_attache,uuid"
        ];
    }

    public function messages(): array
    {
        return [
            "uuid.required" => "附件不存在",
            "uuid.exists" => "附件不存在",
        ];
    }
}