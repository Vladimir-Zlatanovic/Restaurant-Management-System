<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;
    protected $table = "order_details";
    protected $fillable = [
        'order_id',
        'jelovnik_id',
        'kolicina',
        'iznos',
    ];
    
    public function order(){
        return $this->belongsTo(Order::class,'order_id','id');
    }
    public function jelo(){
        return $this->belongsTo(Jelovnik::class,'jelovnik_id','id');
    }
    
}
