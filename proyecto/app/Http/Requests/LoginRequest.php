<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoginRequest extends FormRequest {
    protected $stopOnFirstFailure = true;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array {
        return [
            "usuario" => [
                "required"
            ],
            "pass" =>[
                "required"
            ] 
        ];
    }

    public function messages() {
        return [
            "usuario.required" => "No se ha proporcionado un nombre de usuario",
            "pass.required" => "No se ha proporcionado la contraseña",
        ];
    }

    protected function failedValidation(Validator $validator) {
        $respuesta = response()->view("alerta_auth", ["mensaje" => $validator->errors()->first()]);
        throw new HttpResponseException($respuesta);
    }


}
