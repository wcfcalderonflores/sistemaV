<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    use HasFactory;
    protected $fillable = ['nombre','apellido_paterno','apellido_materno','tipo_documento','numero_documento','sexo','ubigeo_id','direccion','celular','correo'];

    public function cliente(){
        return $this->hasOne(Cliente::class);
        //return $this->hasOne(Cliente::class,'persona_id','persona_id'); // inversa belongsTo()
    }
}
