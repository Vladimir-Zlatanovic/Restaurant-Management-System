<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Potkategorija extends Model
{
    use HasFactory;
    protected $table = 'potkategorije';
    protected $fillable = [
        'ime',
        'slug',
        'kategorija_id',


    ];
    public function kategorija(){
        return $this->belongsTo(Kategorija::class,'kategorija_id','id');
    }
    public function jela(){
        return $this->hasMany(Jelovnik::class,'potkategorija_id', 'id');
    }

}
