<div>
    <x-card>
        <x-form wire:submit="save">
            <x-input label="Name" wire:model="name" />
            
            <hr>

            <x-input type="number" label="Initial Stock" wire:model="initial_stock" />
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <x-input type="number" label="Purchase Price" wire:model="purchase_price" prefix="XAF" money hint="Unit puchase price of the product" />
                <x-input type="number" label="Sale Price" wire:model="selling_price" prefix="XAF" money hint="Stable unit sales price of the product" />
            </div>
         
            <x-slot:actions>
                <x-button label="Add" class="btn-primary" type="submit" spinner="save" />
            </x-slot:actions>
        </x-form>
    </x-card>
</div>
