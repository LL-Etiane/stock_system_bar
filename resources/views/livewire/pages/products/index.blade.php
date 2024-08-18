<div>
    <x-card title="Products">
        <x-slot:actions>
            <x-button label="Add Product" icon="o-plus-circle" link="{{ route('products.add') }}" class="btn-primary" />
        </x-slot:actions>
        <x-table :headers="$headers" :rows="$products" link="/products/{name}/view"/>
    </x-card>
</div>
