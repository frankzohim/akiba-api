<?php

namespace App\Http\Requests;
use Closure;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;

class StoreStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

     /**
     * Failed validation disable redirect
     *
     * @param Validator $validator
     */

    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(response()->json($validator->errors(), 400));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' =>['required','string','unique:App\Models\Store'],
            'phone_number' => ['required', 'string'],
            'state' => ['required', 'boolean'],
            'description' =>['required','string'],
            'email' =>['required','email'],
            'user_id' =>['required','exists:App\Models\User,id'],
        ];
    }
}
