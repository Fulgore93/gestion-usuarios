<?php

namespace App\Http\Requests\Api\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class AuthRequest extends FormRequest
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
			'email'     => ['required','email:filter','exists:users,email'],
            'password'  => ['required'],
        ];
    }
    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'email.required'    => 'Debe ingresar un correo',
            'email.email'       => 'El correo no tiene un formato email válido', 
            'email.exists'      => 'El correo ingresado no existe en el sistema',
            'password.required' => 'Debe ingresar una contraseña',
        ];
    }
    
    /**
     * Handle a failed validation attempt.
     *
     * @param \Illuminate\Contracts\Validation\Validator $validator
     * @return void
     *
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors()->toArray();

        $response = response()->json([
            'success' => false,
            'data' => $errors,
            'user_messagge' => 'Existen errores en los datos ingresados.',
            'dev_messagge' => 'Error en Request',
        ], 422);

        throw new HttpResponseException($response);
    }
}
