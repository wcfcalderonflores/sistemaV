<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Arqueo extends Model
{
    use HasFactory;
    protected $fillable = ['caja_id','usuario_id','fecha_apertura','fecha_cierre','monto_apertura','monto_cierre','total_ventas','estado','estado_recibido','usuario_recibio'];
}
