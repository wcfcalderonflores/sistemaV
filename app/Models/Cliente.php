<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;
    protected $fillable = ['persona_id'];
    protected $primaryKey = 'persona_id';

    /*public function persona(){
        return $this->belongsTo(Persona::class,'persona_id','persona_id');
    }*/
}
