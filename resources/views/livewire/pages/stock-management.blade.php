<div>
    <x-card title="Stock Management">
        <div class="my-3 border p-3 rounded-md">
            <h1>Filter by Date</h1>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-datepicker label="Start Date" wire:model="start_date" icon="o-calendar" />
                <x-datepicker label="End Date" wire:model="end_date" icon="o-calendar" />
            </div>
        </div>

        <x-slot:menu>
            <x-button label="record" icon="o-plus" link="{{ route('stock.record') }}" class="btn-circle btn-sm" />
        </x-slot:menu>

        <x-table :headers="$headers" :rows="$stocks" link="/products/{name}/view" />
    </x-card>
</div>
