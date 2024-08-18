<div>
    <x-tabs wire:model="selectedTab">
        <x-tab name="entry" label="Entry (Purchases)" icon="o-plus">
            <x-card title="Record Stock Entry">
                <x-form wire:submit="save">
                    <x-select label="Select Product" icon-right="o-book-open" :options="$products" wire:model.live="selectedProduct" />
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <x-input type="number" label="Quantity" wire:model="quantity" />
                        <x-datepicker label="Date" wire:model="date" icon="o-calendar" />
                        <x-input type="number" label="Purchase Price" wire:model="purchase_price" prefix="XAF" money hint="Unit puchase price of the product" />
                        <x-input type="number" label="Sale Price" wire:model="selling_price" prefix="XAF" money hint="Stable unit sales price of the product" />
                    </div>
                 
                    <x-slot:actions>
                        <x-button label="Record" class="btn-primary" type="submit" spinner="save" />
                    </x-slot:actions>
                </x-form>
            </x-card>
        </x-tab>
        <x-tab name="exit" label="Exits (Sales)" icon="o-minus">
            <x-card title="Record Stock Exit">
                <x-form wire:submit="save">
                    <x-select label="Select Product" icon-right="o-book-open" :options="$products" wire:model.live="selectedProduct" />
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <x-input type="number" label="Quantity" wire:model="quantity" />
                        <x-datepicker label="Date" wire:model="date" icon="o-calendar" />
                        <x-input type="number" label="Purchase Price" wire:model="purchase_price" prefix="XAF" money hint="Unit puchase price of the product" />
                        <x-input type="number" label="Sale Price" wire:model="selling_price" prefix="XAF" money hint="Stable unit sales price of the product" />
                    </div>
                 
                    <x-slot:actions>
                        <x-button label="Record" class="btn-primary" type="submit" spinner="save" />
                    </x-slot:actions>
                </x-form>
            </x-card>
        </x-tab>
    </x-tabs>
</div>
