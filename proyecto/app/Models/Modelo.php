<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Modelo extends Model {
    protected $atributos = [];

    function getAttribute($key) {
        return $this->attributes[$this->atributos[$key] ?? null] ?? null;
    }

    //function setAttribute($key, $value) {
    //    return parent::setAttribute($key, $value);
    //}

}