<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class UpdatePermissionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('update permissions');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:permissions,name,' . $this->permission->id],
            'description' => ['nullable', 'string', 'max:255'],
            'resource_type' => ['nullable', 'string', 'max:255'],
            'resource_id' => ['nullable', 'integer'],
        ];
    }
}
