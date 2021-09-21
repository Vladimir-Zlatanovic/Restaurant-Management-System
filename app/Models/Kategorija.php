<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategorija extends Model
{
    use HasFactory;

    protected $table = "kategorije";
    protected $primaryKey = 'id';

    protected $fillable =[
        'ime',
    ];

   
    public function potKategorije(){
        return $this->hasMany(Potkategorija::class, 'kategorija_id', 'id');
    }
    public function jela(){
        return $this->hasManyThrough(Jelovnik::class,Potkategorija::class,'kategorija_id','potkategorija_id','id','id');
    }

}
