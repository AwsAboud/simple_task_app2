<?php

namespace App\Http\Requests\Task;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
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
            'status_id' => ['required', 'exists:statuses,id'],
            'priority_id' => ['required', 'exists:priorities,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:5000'],
            'due_date' => ['nullable', 'date'],
            'assigned_users' => ['sometimes', 'array', 'min:1','max:10'],
            'assigned_users.*.user_id' => [
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
