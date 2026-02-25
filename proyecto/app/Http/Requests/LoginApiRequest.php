<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoginApiRequest extends LoginRequest {
    protected function failedValidation(Validator $validator) {
        $error = $validator->errors()->first();
        $respuesta = response()->json([
            "error" => $error
        ], 400);
        throw new HttpResponseException($respuesta);
    }


}
