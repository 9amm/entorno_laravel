<?php

namespace App\Http\Requests;

use App\Models\Rol;
use Illuminate\Foundation\Http\FormRequest;
use App\Utils\Utils;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Closure;

class RegisterApiRequest extends RegisterRequest {

    protected function failedValidation(Validator $validator) {
        $error = $validator->errors()->first();
        $respuesta = response()->json([
            "error" => $error
        ], 400);
        throw new HttpResponseException($respuesta);
    }


}
