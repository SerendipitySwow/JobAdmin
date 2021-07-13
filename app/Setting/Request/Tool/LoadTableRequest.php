<?php


namespace App\Setting\Request\Tool;


use Hyperf\Validation\Request\FormRequest;
use Hyperf\Validation\Rule;

class LoadTableRequest extends FormRequest
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
            'names' => 'required|array',
        ];
    }
}