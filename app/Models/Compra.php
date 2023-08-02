<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    use HasFactory;
    protected $fillable = ['proveedor_id','comprobante_id','numero_comprobante','fecha_compra','forma_pago','estado','estado_igv','porcentaje_igv','user_id','arqueo_id'];
}
