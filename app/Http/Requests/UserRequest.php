<?php

namespace App\Http\Requests;
use Closure;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UserRequest extends FormRequest
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
            'username' => ['required', 'string', 'unique:App\Models\User',
            function (string $attribute, mixed $value, Closure $fail) {
            if ($value == trim($value) && str_contains($value, ' ')) {
                $fail("The {$attribute} should not contains spaces.");
            }
        },],
            'phone_number' => ['required', 'string','unique:App\Models\User'],
            'password' => ['required', 'string', 'min:6', 'max:30'],
            'role_id' =>['required','exists:App\Models\Role,id'],
            'email' =>['nullable','email','unique:App\Models\User'],
            //'cgu'=>['accepted']
        ];
    }
}
