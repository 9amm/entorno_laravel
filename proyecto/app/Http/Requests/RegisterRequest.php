<?php

namespace App\Http\Requests;

use App\Models\Rol;
use Illuminate\Foundation\Http\FormRequest;
use App\Utils\Utils;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Closure;

class RegisterRequest extends FormRequest {
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
            "nombre" => [
                "required",
                function (string $attribute, mixed $value, Closure $fail) {
                    if (!Utils::nombreCumpleFormato($value)) {
                        $fail("Nombre de usuario no cumple formato");
                    }
                },
            ],
            "email" => [
                "required",
                function (string $attribute, mixed $value, Closure $fail) {
                    if (!Utils::emailCumpleFormato($value)) {
                        $fail("Email no válido");
                    }
                },
                
            ],
            "pass" => [
                "required",
                function (string $attribute, mixed $value, Closure $fail) {
                    if (!Utils::contrasenaHasheadaCumpleFormato($value)) {
                        $fail("La contraseña no cumple con el formato solicitado");
                    }
                },
            ],
            "rol" => [
                "required",
                function (string $attribute, mixed $value, Closure $fail) {
                    if(!Rol::existe($value)) {
                        $fail("Rol no válido");
                    }
                },
            ]
        ];
    }

    public function messages() {
        return [
            "nombre.required" => "Nombre obligatorio",
            "email.required" => "Email obligatorio",
            "pass.required" => "Contraseña obligatoria",
            "rol.required" => "Rol obligatorio"
        ];
    }

    protected function failedValidation(Validator $validator) {
        $respuesta = response()->view("alerta_auth", [
            "mensaje" => $validator->errors()->first()
        ]);
        throw new HttpResponseException($respuesta);
    }


}
