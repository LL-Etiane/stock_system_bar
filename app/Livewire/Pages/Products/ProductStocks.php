<?php

namespace App\Livewire\Pages\Products;

use Livewire\Component;
use App\Models\Product;
use Mary\Traits\Toast;
use Livewire\Attributes\Title;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class ProductStocks extends Component
{
    use Toast;
    public $product;
    public $year;
    public $month;
    public $calendar = [];

    public $selectedTab = 'entry';

    public $stockSummary = [
        "opening_balance" => 0,
        "opening_balance_value" => 0,
        "entries" => 0,
        'exits' => 0,
        'balance' => 0,
        'entry_value' => 0,
        'exit_value' => 0,
        'balance_value' => 0,
        'profit' => 0,
    ];

    public function mount($product){
        $this->product = Product::whereRaw('LOWER(name) = ?', [strtolower($product)])->first();

        if(!$this->product){
            $this->error("Invalid Product");
            return redirect()->route('stock.index');
        }

        $this->year = now()->year;
        $this->month = now()->month;

        $this->generateCalendar();
        $this->getFinancialSummary();
    }

    #[Title('Products Details')]
    public function render()
    {
        return view('livewire.pages.products.product-stocks');
    }

    public function getFinancialSummary(){
        $start_of_month_date = Carbon::createFromDate($this->year, $this->month, 1);
        $end_of_month_date = $start_of_month_date->copy()->endOfMonth();
        $last_months_last_date = $start_of_month_date->copy()->subDay();

        $this->stockSummary['opening_balance'] = $this->product->getStockAsAtDate($last_months_last_date);
        $this->stockSummary['entries'] = $this->product->getEntriesAsAtDate($end_of_month_date, $start_of_month_date);
        $this->stockSummary['exits'] = $this->product->getExitsAsAtDate($end_of_month_date, $start_of_month_date);
        $this->stockSummary['balance'] = $this->product->getStockAsAtDate($end_of_month_date, $start_of_month_date);

        $this->stockSummary['opening_balance_value'] = $this->product->getStockAsAtDate($last_months_last_date) * $this->product->purchase_price;
        $this->stockSummary['entry_value'] = $this->product->getEntriesAsAtDate($end_of_month_date, $start_of_month_date) * $this->product->purchase_price;
        $this->stockSummary['exit_value'] = $this->product->getExitsAsAtDate($end_of_month_date, $start_of_month_date) * $this->product->selling_price;
        $this->stockSummary['balance_value'] = $this->product->getStockAsAtDate($end_of_month_date, $start_of_month_date) * $this->product->purchase_price;

        $this->stockSummary['profit'] = ($this->product->getExitsAsAtDate($end_of_month_date, $start_of_month_date) * $this->product->selling_price) - $this->product->getExitsAsAtDate($end_of_month_date, $start_of_month_date) * $this->product->purchase_price;
    }

    public function generateCalendar(){
        // Get the first day of the month
        $firstDayOfMonth = Carbon::createFromDate($this->year, $this->month, 1);
        
        // Get the last day of the month
        $lastDayOfMonth = $firstDayOfMonth->copy()->endOfMonth();

        // Create a CarbonPeriod for the month
        $period = CarbonPeriod::create($firstDayOfMonth, $lastDayOfMonth);

        // Initialize an array for each week
        $weeks = [];
        $week = array_fill(0, 7, null); // Initialize the week array with null values

        foreach ($period as $date) {
            // Get the stock for this date
            if($this->selectedTab == "entry"){
                $stock = $this->product->getEntriesAsAtDate($date, $date);
            }else if($this->selectedTab == "exit"){
                $stock = $this->product->getExitsAsAtDate($date, $date);
            }else if($this->selectedTab == "balance"){
                $stock = $this->product->getStockAsAtDate($date, $date);
            }
            
            // Add the day and stock data
            $week[$date->dayOfWeek] = ['day' => $date->format('d'), 'stock' => $stock];

            // If the week is complete (Sunday is day 0), start a new week
            if ($date->isSunday()) {
                $weeks[] = $week;
                $week = array_fill(0, 7, null); // Reset the week array
            }
        }

        // Add the last week if not already added
        if (!empty(array_filter($week))) {
            $weeks[] = $week;
        }

        // Set the weeks array to the calendar
        $this->calendar = $weeks;
    }

    public function updatedMonth(){
        $this->month = (int)$this->month;
        $this->year = (int)$this->year;
        $this->generateCalendar();
        $this->getFinancialSummary();
    }

    public function updateTab($tab){
        $this->selectedTab = $tab;
        $this->generateCalendar();
    }
}
