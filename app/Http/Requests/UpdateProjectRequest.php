<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProjectRequest extends FormRequest
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
            'lead_id' => ['sometimes', 'nullable', 'integer', 'exists:users,id'],
            'code' => [
                'sometimes',
                'nullable',
                'string',
                'max:10',
                'regex:/^[A-Z][A-Z0-9]*$/',
                Rule::unique('projects', 'code')->ignore($this->route('project')),
            ],
            'name' => ['sometimes', 'required', 'string', 'max:200'],
            'description' => ['sometimes', 'nullable', 'string', 'max:10000'],
            'status' => ['sometimes', 'integer', 'between:0,6'],
            'visibility' => ['sometimes', 'integer', 'between:0,2'],
            'priority' => ['sometimes', 'integer', 'between:0,2'],
            'starts_at' => ['sometimes', 'nullable', 'date'],
            'ends_at' => ['sometimes', 'nullable', 'date', 'after_or_equal:starts_at'],
        ];
    }
}
