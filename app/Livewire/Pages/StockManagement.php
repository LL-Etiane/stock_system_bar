<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Models\Product;

class StockManagement extends Component
{
    public $year;
    public $month;
    public $month_weeks = [];
    public $start_date;
    public $end_date;
    public $stocks = [];
    public $products;

    public $headers = [
        ['key' => 'name', 'label' => 'Name'],
        ['key' => 'mon', 'label' => 'Mon'],
        ['key' => 'tues', 'label' => 'Tues'],
        ['key' => 'wed', 'label' => 'Wed'],
        ['key' => 'thurs', 'label' => 'Thur'],
        ['key' => 'fri', 'label' => 'Fri'],
        ['key' => 'sat', 'label' => 'Sat'],
        ['key' => 'sun', 'label' => 'Sun'],
        ['key' => 'tol', 'label' => 'Tol'],
        ['key' => 'sold', 'label' => 'Sold'],
        ['key' => 'rem', 'label' => 'Rem'],
        ['key' => 'amt', 'label' => 'Amt'],
    ];

    public function mount(){
        $this->start_date = now()->startOfWeek();
        $this->end_date = now()->endOfWeek();

        $this->year = Carbon::parse($this->start_date)->year;
        $this->year = Carbon::parse($this->start_date)->month;
        
        $this->products = Product::select('id','name')->orderBy('created_at', 'desc')->get();

        $this->stocks = $this->products->toArray();

        $this->getStockCount();

        // dd($this->stocks);
    }

    public function getStockCount(){
        foreach($this->stocks as $index => $stock){
            $product = Product::find($stock['id']);

            $daysOfWeek = [
                'mon' => Carbon::MONDAY,
                'tues' => Carbon::TUESDAY,
                'wed' => Carbon::WEDNESDAY,
                'thurs' => Carbon::THURSDAY,
                'fri' => Carbon::FRIDAY,
                'sat' => Carbon::SATURDAY,
                'sun' => Carbon::SUNDAY,
            ];

            foreach ($daysOfWeek as $dayLabel => $dayOfWeek) {
                $dayDate = $this->getDayOfWeekInRange($this->year, $this->month, $this->start_date->day, $this->end_date->day, $dayOfWeek);

                // Check if the date was found for the desired day of the week
                if ($dayDate) {
                    // Fetch entries and exits for that day
                    $entries = $product->getEntriesAsAtDate($dayDate, $dayDate);
                    
                    // Save data in stocks array for each day
                    $this->stocks[$index][$dayLabel] = number_format($entries);
                } else {
                    $this->stocks[$index][$dayLabel] = 0;
                }
            }

            $this->stocks[$index]['tol'] = number_format($product->getEntriesAsAtDate($this->end_date, $this->start_date));
            $this->stocks[$index]['sold'] = number_format($product->getExitsAsAtDate($this->end_date, $this->start_date));
            $this->stocks[$index]['rem'] = number_format($product->getStockAsAtDate($this->end_date, $this->start_date));
            $this->stocks[$index]['amt'] = number_format($product->getStockAsAtDate($this->end_date, $this->start_date) * $product->sellingPrice);
        }
    }

    public function render()
    {
        return view('livewire.pages.stock-management');
    }


    function getDayOfWeekInRange($year, $month, $startOfWeek, $endOfWeek, $desiredDayOfWeek) {
        // Create a Carbon instance for the start of the week
        $startDate = Carbon::createFromDate($year, $month, $startOfWeek)->startOfDay();
        
        // Create a Carbon instance for the end of the week
        $endDate = Carbon::createFromDate($year, $month, $endOfWeek)->endOfDay();
        
        // Create a period from start to end of the week
        $period = CarbonPeriod::create($startDate, $endDate);
        
        // Loop through the period and find the desired day of the week
        foreach ($period as $date) {
            if ($date->isDayOfWeek($desiredDayOfWeek)) {
                return $date->toDateString(); // Return the date in 'Y-m-d' format
            }
        }
        
        return null; // Return null if the desired day of the week isn't found in the range
    }
}
