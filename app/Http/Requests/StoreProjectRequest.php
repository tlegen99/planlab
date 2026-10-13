<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // TODO: временно потом появится авторизация
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'lead_id' => ['nullable', 'integer', 'exists:users,id'],
            'code' => ['nullable', 'string', 'max:10', 'regex:/^[A-Z][A-Z0-9]*$/', Rule::unique('projects', 'code')],
            'name' => ['required', 'string', 'max:200'],
            'description' => ['nullable', 'string', 'max:10000'],
            'status' => ['integer', 'between:0,6'],
            'visibility' => ['integer', 'between:0,2'],
            'priority' => ['integer', 'between:0,2'],
            'starts_at' => ['nullable', 'date'],
            'ends_at' => ['nullable', 'date', 'after_or_equal:starts_at'],
        ];
    }
}
