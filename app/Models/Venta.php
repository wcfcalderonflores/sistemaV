<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;
    protected $fillable = ['cliente_id','tipo_cliente_id','numero_comprobante','arqueo_id','comprobante_config_id','user_id','fecha','estado'];
}
