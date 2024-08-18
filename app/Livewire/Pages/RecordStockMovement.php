<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Mary\Traits\Toast;
use App\Models\Product;
use Carbon\Carbon;

class RecordStockMovement extends Component
{
    use Toast;
    public $selectedTab = 'entry';
    public $products;
    public $selectedProduct = "";
    public $product;
    
    #[Validate('required|numeric|min:0')]
    public $quantity;
    #[Validate('required')]
    public $date;

    #[Validate('nullable|numeric|min:0')]
    public $purchase_price;

    #[Validate('nullable|numeric|min:0')]
    public $selling_price;

    public function getProductPrice($id){
        $this->product = Product::findOrFail($id);
        $this->purchase_price = $this->product->purchasePrice;
        $this->selling_price = $this->product->sellingPrice;
    }

    public function mount(){
        $this->date = now();
        $this->products = Product::select('id', 'name')->get();
        $this->selectedProduct = $this->products[0]->id;
        
        $this->getProductPrice($this->selectedProduct);
    }

    #[Title('Add Product')]
    public function render()
    {
        return view('livewire.pages.record-stock-movement');
    }

    public function updatedSelectedProduct($value){
        $this->getProductPrice($value);
    }

    public function save(){
        $this->validate();

        $date = Carbon::parse($this->date);

        $stock = $this->product->stocks()->create([
            'quantity' => $this->quantity,
            'type' => $this->selectedTab,
            'created_at' => $this->date
        ]);

        $stock->price()->create([
            'product_id' => $this->product->id,
            'purchase_price' => $this->purchase_price,
            'selling_price' => $this->selling_price
        ]);

        $this->success('Stock successfully!');
        $this->reset();
        return redirect()->route('stock.index');
    }
}
