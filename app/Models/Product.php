<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function stocks(){
        return $this->hasMany(Stock::class);
    }

    public function prices(){
        return $this->hasMany(Price::class);
    }

    public function getStockAttribute(){
        // get total stocks of type entry
        $entry = $this->stocks()->where('type', 'entry')->sum('quantity');
        // get total stocks of type exit
        $exit = $this->stocks()->where('type', 'exit')->sum('quantity');
        return $entry - $exit;
    }

    public function getPurchasePriceAttribute(){
        return $this->prices()->latest()->first()->purchase_price;
    }

    public function getSellingPriceAttribute(){
        return $this->prices()->latest()->first()->selling_price;
    }

    public static function AllProductsStockValue(){
        $products = Product::all();
        $total = 0;
        foreach ($products as $product) {
            $total += $product->stock * $product->purchase_price;
        }
        return $total;
    }
}
