<?php

namespace App\Livewire\Pages\Products;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Mary\Traits\Toast;
use App\Models\Product;

class Add extends Component
{
    use Toast;

    #[Validate('required|unique:products,name')]
    public string $name;

    #[Validate('nullable|numeric|min:0')]
    public $initial_stock;

    #[Validate('nullable|numeric|min:0')]
    public $purchase_price;

    #[Validate('nullable|numeric|min:0')]
    public $selling_price;

    #[Title('Add Product')]
    public function render()
    {
        return view('livewire.pages.products.add');
    }

    public function save()
    {
        $this->validate();

        // Save to database
        $product = Product::create([
            'name' => $this->name
        ]);

        $stock = $product->stocks()->create([
            'quantity' => $this->initial_stock,
            'type' => 'entry'
        ]);

        $stock->price()->create([
            'product_id' => $product->id,
            'purchase_price' => $this->purchase_price,
            'selling_price' => $this->selling_price
        ]);

        $this->success('Product added successfully!');
        $this->reset();
        return redirect()->route('products.index');
    }
}
