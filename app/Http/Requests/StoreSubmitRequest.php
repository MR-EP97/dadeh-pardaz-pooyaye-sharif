<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreSubmitRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'expense' => 'required|string|exists:App\Models\ExpenseCategory,name',
            'description' => 'required|string',
            'amount' => 'required|int',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'national_id' => 'required|digits:10|exists:App\Models\User,national_id',
            'iban' => 'required|string'
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'user_id' => User::query()->where('national_id', $this->input('national_id'))->value('id')
        ]);

    }

    protected function passedValidation(): void
    {
        $this->replace($this->except(['national_id']));
    }
}
