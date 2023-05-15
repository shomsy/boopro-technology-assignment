<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class IssueSearchScoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // TODO: let's assume we will authorize this request later in case user is logged in via GitHub API OAuth.
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
            'term' => 'required|string|max:255',
        ];
    }


    /**
     * @param  Validator  $validator
     * @return void
     */
    public function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(response()->json([
            'status' => 422,
            'title' => 'Unprocessable Entity',
            'detail' => $validator->errors()
        ]));
    }


    /**
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'term.required' => 'A term parameter is required. Example: /search?term=something',
        ];
    }
}
