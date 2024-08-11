<?php

namespace App\Livewire\Pages\Products;

use Livewire\Component;
use App\Models\Product;

class Index extends Component
{
    public $products;
    public $headers = [
        ['key' => 'id', 'label' => '#'],
        ['key' => 'name', 'label' => 'Name'],
        ['key' => 'stock', 'label' => 'Stock'],
        ['key' => 'selling_price', 'label' => 'Selling Price'],
        ['key' => 'purchase_price', 'label' => 'Purchase Price']
    ];

    public function mount()
    {
        $this->products = Product::orderBy('created_at', 'desc')->get();
    }
    
    public function render()
    {
        return view('livewire.pages.products.index');
    }
}
