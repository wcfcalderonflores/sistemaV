<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VentaDetalle extends Model
{
    use HasFactory;
    protected $fillable = ['venta_id','producto_id','producto_unidad_id','precio_registro','precio','precio_compra','cantidad','cantidad_unidad','descuento','user_id'];
}
