<div>
    <x-card title="{{ ucfirst($product->name) }} Stock {{ ucfirst($selectedTab) }} records for {{ \Carbon\Carbon::create()->month($month)->format('F') }} {{ $year }}">
        <div class="flex justify-between items-center">
            <div class="">
                <x-button label="Entries" icon="o-plus" wire:click="updateTab('entry')" class="font-bold" @class(['btn-md bg-primary text-white' => $selectedTab == 'entry']) />
                <x-button label="Exits" icon="o-minus" wire:click="updateTab('exit')" class="btn-md" @class(['btn-md bg-primary text-white' => $selectedTab == 'exit'])/>
                <x-button label="Balance" icon="o-book-open" wire:click="updateTab('balance')" class="btn-md" @class(['btn-md bg-primary text-white' => $selectedTab == 'balance'])/>
            </div>
            <div class="flex gap-5 items-center mb-4">
                <div>
                    <label for="year" class="block text-sm font-medium text-gray-700">Year</label>
                    <select id="year" wire:model.live="year" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        @for($y = now()->year - 5; $y <= now()->year; $y++)
                            <option value="{{ $y }}">{{ $y }}</option>
                        @endfor
                    </select>
                </div>
                <div>
                    <label for="month" class="block text-sm font-medium text-gray-700">Month</label>
                    <select id="month" wire:model.live="month" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        @foreach(range(1, 12) as $m)
                            <option value="{{ $m }}">{{ \Carbon\Carbon::create()->month($m)->format('F') }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <table class="table-auto w-full">
            <thead>
                <tr class="text-primary">
                    <th>Mon</th>
                    <th>Tues</th>
                    <th>Wed</th>
                    <th>Thurs</th>
                    <th>Fri</th>
                    <th>Sat</th>
                    <th>Sun</th>
                </tr>
            </thead>
            <tbody>
                @foreach($calendar as $week)
                    <tr>
                        @for($i = 1; $i <= 7; $i++)
                            <td class="border px-4 py-2">
                                @if(isset($week[$i % 7]))
                                    <div class="text-blue-500">{{ $week[$i % 7]['day'] }}</div>
                                    <div class="font-bold">{{ $week[$i % 7]['stock'] }}</div>
                                @else
                                    <div></div>
                                @endif
                            </td>
                        @endfor
                    </tr>
                @endforeach
            </tbody>
        </table>
        
        <div class="my-5 border border-gray-300 p-5 rounded-lg shadow-md bg-white">
            <h1 class="text-2xl font-bold mb-4 text-gray-700 text-center">Financial Summary</h1>
        
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-600">
                <!-- Opening Balance -->
                <div class="p-3 border border-gray-200 rounded-md shadow-sm">
                    <p class="text-lg font-semibold text-gray-700">Opening Balance:</p>
                    <p class="text-xl">{{ number_format($stockSummary['opening_balance']) }}</p>
                    <p class="text-sm text-gray-500">Amount: {{ number_format($stockSummary['opening_balance_value']) }}</p>
                </div>
        
                <!-- Total Stock Entries -->
                <div class="p-3 border border-gray-200 rounded-md shadow-sm">
                    <p class="text-lg font-semibold text-gray-700">Total Stock Entries:</p>
                    <p class="text-xl">{{ number_format($stockSummary['entries']) }}</p>
                    <p class="text-sm text-gray-500">Amount: {{ number_format($stockSummary['entry_value']) }}</p>
                </div>
        
                <!-- Total Stock Exits -->
                <div class="p-3 border border-gray-200 rounded-md shadow-sm">
                    <p class="text-lg font-semibold text-gray-700">Total Stock Exits:</p>
                    <p class="text-xl">{{ number_format($stockSummary['exits']) }}</p>
                    <p class="text-sm text-gray-500">Amount Sold: {{ number_format($stockSummary['exit_value']) }}</p>
                </div>
        
                <!-- Total Stock Balance -->
                <div class="p-3 border border-gray-200 rounded-md shadow-sm">
                    <p class="text-lg font-semibold text-gray-700">Total Stock Balance:</p>
                    <p class="text-xl">{{ number_format($stockSummary['balance']) }}</p>
                    <p class="text-sm text-gray-500">Amount: {{ number_format($stockSummary['balance_value']) }}</p>
                </div>
        
                <!-- Months Profit -->
                <div class="p-3 border border-gray-200 rounded-md shadow-sm sm:col-span-2">
                    <p class="text-lg font-semibold text-gray-700">Month's Profit:</p>
                    <p class="text-xl text-green-500">{{ number_format($stockSummary['profit']) }}</p>
                </div>
            </div>
        </div>
        
    </x-card>
</div>