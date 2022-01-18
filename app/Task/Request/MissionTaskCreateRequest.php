<?php

namespace App\Task\Request;

use Hyperf\Validation\Request\FormRequest;

/**
 * 任务列表验证数据类 (Create)
 */
class MissionTaskCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            
        ];
    }
}