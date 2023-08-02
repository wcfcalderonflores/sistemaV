<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleAjusteStock extends Model
{
    use HasFactory;
    protected $fillable = ['ajuste_stock_id','producto_id','producto_unidad_id','cantidad','cantidad_unidad','precio_compra','cantidad_recuperada'];
}
