<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AjusteStock extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','tipo_ajuste','referencia','estado','arqueo_id'];
}
