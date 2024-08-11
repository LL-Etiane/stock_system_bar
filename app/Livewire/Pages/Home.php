<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use Carbon\Carbon;
use App\Models\Product;
use App\Models\Stock;

class Home extends Component
{
    public $products;
    public $stock_value;
    public $total_stock;
    public $entry_stock_this_week;
    public $exit_stock_this_week;

    public array $sales_record_this_week = [0, 0, 0, 0, 0, 0, 0];
    public array $stockCharts = [];

    public function getDailySalesRecordForTheWeek()
    {
        $startOfWeek = now()->startOfWeek();
        $this->sales_record_this_week = [];

        // Loop through the days of the week
        for ($i = 0; $i < 7; $i++) {
            $date = $startOfWeek->copy()->addDays($i);

            // Get the total sales value for each day
            $totalSalesValue = Stock::where('type', 'exit')
                ->whereDate('created_at', $date)
                ->with('product') // Eager load product relationship
                ->get() // Execute the query
                ->sum(function ($stock) {
                    return $stock->quantity * $stock->product->selling_price;
                });

            // Add the total sales value for the day to the array
            $this->sales_record_this_week[] = $totalSalesValue;
        }
    }

    public function getStockschatData()
    {
        $this->stockCharts = [
            'type' => 'pie',
            'data' => [
                'labels' => $this->products->pluck('name')->toArray(),
                'datasets' => [
                    [
                        'label' => 'Stock',
                        'data' => $this->products->pluck('stock')->toArray(),
                    ],
                ],
            ],
            'options' => [
                'plugins' => [
                    'legend' => [
                        'display' => false,
                    ],
                ],
            ],
        ];
    }

    public function mount()
    {
        $this->products = Product::all();
        $this->total_stock = Stock::where('type', 'entry')->sum('quantity') - Stock::where('type', 'exit')->sum('quantity');
        $this->entry_stock_this_week = Stock::where('type', 'entry')
            ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->sum('quantity');
        $this->exit_stock_this_week = Stock::where('type', 'exit')
            ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->sum('quantity');
        $this->stock_value = Product::AllProductsStockValue();
        $this->getDailySalesRecordForTheWeek();
        $this->getStockschatData();
    }

    public function render()
    {
        return view('livewire.pages.home');
    }
}
