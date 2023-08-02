<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompraDetalle extends Model
{
    use HasFactory;
    protected $fillable = ['compra_id','producto_id','producto_unidad_id','precio','precio_compra','cantidad','stock','cantidad_unidad','stock_unidades','fecha_vencimiento','descuento','user_id'];
}
