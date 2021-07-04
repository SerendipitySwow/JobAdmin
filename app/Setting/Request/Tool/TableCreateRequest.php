<?php


namespace App\Setting\Request\Tool;


use Hyperf\Validation\Request\FormRequest;
use Hyperf\Validation\Rule;

class TableCreateRequest extends FormRequest
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
            'name' => 'required|regex:/^[A-Za-z]{2,}$/i',
            'module' => 'required|regex:/^[A-Za-z]{2,}$/i',
            'pk' => 'required|regex:/^[A-Za-z]{2,}$/i',
            'engine' => ['required', Rule::in(['InnoDB', 'MyISAM'])],
            'comment' => 'required',
            'columns' => 'required|json',
            'description' => 'required|max:255',
            'autoTime' => 'required|boolean',
            'autoUser' => 'required|boolean',
            'softDelete' => 'required|boolean',
            'migrate' => 'required|boolean',
        ];
    }
}