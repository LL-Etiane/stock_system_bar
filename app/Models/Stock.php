<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'quantity', 'type'];

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function price(){
        return $this->hasOne(Price::class);
    }

    public static function AvailableStocks(){}
}
