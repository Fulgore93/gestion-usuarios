<?php

namespace App\Http\Requests\Api\User;

use App\Rules\ValidateCustomPassword;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserStoreRequest extends FormRequest
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
			'name'      => ['required','string','min:3','max:60','regex:/^[a-zA-ZñÑáéíóú\s]+$/u'],
			'email'     => ['required','email:filter','unique:users,email'],
            'password'  => ['required', 'string', 'min:8', 'max:12', new ValidateCustomPassword],
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
            'name.required'     => 'El campo nombre es obligatorio',
            'name.string'       => 'El campo nombre debe ser una cadena de texto',
            'name.min'          => 'El campo nombre necesita como mínimo 3 caracteres',
            'name.max'          => 'El campo nombre no debe superar los 60 caracteres',
            'name.regex'        => 'El campo nombre solo permite letras minúsculas, mayúsculas, espacios y vocales con tildes.',
            'email.required'    => 'El correo es obligatorio',
            'email.email'       => 'El correo no tiene un formato email válido', 
            'email.unique'      => 'El correo ingresado ya se encuentra registrado en el sistema',
            'password.required' => 'La contraseña es obligatoria',
            'password.string'   => 'La contraseña debe ser una cadena de texto',
            'password.min'      => 'La contraseña debe ser como mínimo de 8 caracteres',
            'password.max'      => 'La contraseña no debe superar los 12 caracteres',
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
