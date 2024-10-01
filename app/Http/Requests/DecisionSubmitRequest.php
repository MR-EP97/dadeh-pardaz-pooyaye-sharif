<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DecisionSubmitRequest extends FormRequest
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
            'requests_decision' => 'required|array',
            'requests_decision.*.id' => 'required|integer|exists:App\Models\SubmitRequest,id',
            'requests_decision.*.status' => 'required|in:approved,rejected',
            'requests_decision.*.reason' => 'required_if:requests_decision.*.status,rejected|string',
        ];
    }
}
