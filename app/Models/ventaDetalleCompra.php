<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ventaDetalleCompra extends Model
{
    use HasFactory;
    protected $fillable = ['venta_detalle_id','compra_detalle_id','cantidad','precio_compra'];
    protected $primaryKey = ['venta_detalle_id','compra_detalle_id'];
    public $incrementing = false;
}
