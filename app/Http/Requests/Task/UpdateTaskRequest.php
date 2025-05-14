<?php

namespace App\Http\Requests\Task;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'status_id' => ['required', 'required', 'exists:statuses,id'],
            'priority_id' => ['required', 'required', 'exists:priorities,id'],
            'title' => ['required', 'required', 'string', 'max:255'],
            'description' => ['required', 'required', 'string'],
            'due_date' => ['nullable', 'date'],
            'assigned_users' => ['sometimes', 'array', 'min:1', 'max:10'],
            'assigned_users.*.id' => [
                'required',
                'exists:users,id',
                'distinct'
            ],
            'assigned_users.*.role' => [
                'required',
                Rule::in(['assignee', 'reviewer', 'watcher'])
            ],
        ];
    }
}
