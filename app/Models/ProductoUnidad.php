<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductoUnidad extends Model
{
    use HasFactory;
    protected $fillable = ['producto_id','unidad_medida_id','cantidad_unidades','estado','stock'];
    
}
