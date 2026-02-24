<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Contracts\IAsignaturasRepository;
use App\Models\Mensaje;
use Closure;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use League\Config\Exception\ValidationException;

class CrearMensajeRequest extends FormRequest {
    protected $stopOnFirstFailure = true;

    protected $repositorioAsignaturas;

    public function __construct(IAsignaturasRepository $repositorioAsignaturas) {
        $this->repositorioAsignaturas = $repositorioAsignaturas;
    }


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
            "id_asignatura" => [
                "required",
                "integer"
            ],
            "mensaje" => [
                "required",
                function (string $attribute, mixed $value, Closure $fail) {
                    if(!Mensaje::tieneLongitudValida($value)) {
                        $fail("Longitud del mensaje no valida.");
                    }
                }
            ]
        ];
    }


    public function messages() {
        return [
            "id_asignatura.required" => "No se ha introducido una asignatura",
            "id_asignatura.integer" => "Asignatura no válida",
            "mensaje.required" => "No se ha introducido un mensaje",
        ];
    }

    protected function failedValidation(Validator $validator) {
        $respuesta = response()->view("error", [
            "mensaje" => $validator->errors()->first()
        ]);
        throw new HttpResponseException($respuesta);
    }


}
