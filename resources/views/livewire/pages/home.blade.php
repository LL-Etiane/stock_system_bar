<div>
    <div class="grid lg:grid-cols-4 gap-5 lg:gap-8">
        <div class="bg-base-100 rounded-lg px-5 py-4 w-full shadow truncate text-ellipsis">
            <div class="flex items-center gap-3">
                <div class="text-primary">
                    <svg class="inline w-9 h-9" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z">
                        </path>
                    </svg>
                </div>
                <div class="text-left">
                    <div class="text-xs text-gray-500 whitespace-nowrap">Stock value</div>
                    <div class="font-black text-xl">{{ number_format($stock_value) }} XAF</div>
                </div>
            </div>
        </div>

        <div class="bg-base-100 rounded-lg px-5 py-4 w-full shadow">
            <div class="flex items-center gap-3">
                <div class="text-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8.25 7.5V6.108c0-1.135.845-2.098 1.976-2.192.373-.03.748-.057 1.123-.08M15.75 18H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08M15.75 18.75v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5A3.375 3.375 0 0 0 6.375 7.5H5.25m11.9-3.664A2.251 2.251 0 0 0 15 2.25h-1.5a2.251 2.251 0 0 0-2.15 1.586m5.8 0c.065.21.1.433.1.664v.75h-6V4.5c0-.231.035-.454.1-.664M6.75 7.5H4.875c-.621 0-1.125.504-1.125 1.125v12c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V16.5a9 9 0 0 0-9-9Z" />
                    </svg>

                </div>
                <div class="text-left">
                    <div class="text-xs text-gray-500 whitespace-nowrap">Total stock count</div>
                    <div class="font-black text-xl">{{ number_format($total_stock) }}</div>
                </div>
            </div>
        </div>

        <div class="bg-base-100 rounded-lg px-5 py-4 w-full shadow">
            <div class="flex items-center gap-3">
                <div class="text-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>

                </div>
                <div class="text-left">
                    <div class="text-xs text-gray-500 whitespace-nowrap">Stock in this week</div>
                    <div class="font-black text-xl">{{ number_format($entry_stock_this_week) }}</div>
                </div>
            </div>
        </div>

        <div class="bg-base-100 rounded-lg px-5 py-4 w-full shadow">
            <div class="flex items-center gap-3">
                <div class="!text-pink-500">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15 12H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>

                </div>
                <div class="text-left">
                    <div class="text-xs text-gray-500 whitespace-nowrap">Stock out this week</div>
                    <div class="font-black text-xl">{{ number_format($exit_stock_this_week) }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid lg:grid-cols-6 gap-8 mt-8">
        <div class="col-span-6 lg:col-span-4">
            <canvas id="weeklySalesChart"></canvas>
        </div>
        <div class="col-span-6 lg:col-span-2">
            <x-card title="Stock" separator>
                <x-chart wire:model="stockCharts" />
            </x-card>
        </div>

    </div>
</div>


<script>
    const weeklySalesChart = document.getElementById('weeklySalesChart');

    new Chart(weeklySalesChart, {
        type: 'line',
        data: {
            labels: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
            datasets: [{
                label: 'Sales',
                data: @json($sales_record_this_week),
                borderWidth: 1,
                backgroundColor: 'rgba(128, 90, 213, 0.2)', // Light purple fill
                borderColor: 'rgba(128, 90, 213, 1)', // Darker purple line
                borderWidth: 2,
                pointBackgroundColor: 'rgba(128, 90, 213, 1)', // Color of the data points
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                fill: true, // Fill the area under the line
                tension: 0.4, // Curved lines
            }]
        },
        options: {
            scales: {
                x: {
                    grid: {
                        display: false 
                    }
                },
                y: {
                    grid: {
                        display: false 
                    },
                    beginAtZero: true
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
</script>
