<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComprobanteConfig extends Model
{
    use HasFactory;
    protected $fillable = ['comprobante_id','serie','contador','numero_maximo','estado','estado_igv','valor_igv'];
}
