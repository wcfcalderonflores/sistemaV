<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductoPrecioCliente extends Model
{
    use HasFactory;
    protected $fillable = ['producto_unidad_id','tipo_cliente_id','precio_compra','precio_venta','estado'];
}
