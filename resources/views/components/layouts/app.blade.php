<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        @livewireStyles
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="/js/chart.umd.min.js"></script>
        <script type="text/javascript" src="/js/currency.js"></script>
</head>
 
<body class="font-sans antialiased bg-base-200/50">
 
    {{-- The navbar with `sticky` and `full-width` --}}
    <x-nav sticky full-width>
 
        <x-slot:brand>
            {{-- Drawer toggle for "main-drawer" --}}
            <label for="main-drawer" class="lg:hidden mr-3">
                <x-icon name="o-bars-3" class="cursor-pointer" />
            </label>
 
            {{-- Brand --}}
            <div>BarStock</div>
        </x-slot:brand>
 
        {{-- Right side actions --}}
        <x-slot:actions>
            <x-button label="Notifications" icon="o-bell" link="###" class="btn-ghost btn-sm" responsive />
        </x-slot:actions>
    </x-nav>
 
    {{-- The main content with `full-width` --}}
    <x-main with-nav full-width>
 
        {{-- This is a sidebar that works also as a drawer on small screens --}}
        {{-- Notice the `main-drawer` reference here --}}
        <x-slot:sidebar drawer="main-drawer" collapsible class="bg-base-200">
 
            {{-- User --}}
            @if($user = auth()->user())
                <x-list-item :item="$user" value="name" sub-value="email" no-separator no-hover class="pt-2">
                    <x-slot:actions>
                        <x-button icon="o-power" class="btn-circle btn-ghost btn-xs" tooltip-left="logoff" no-wire-navigate link="/logout" />
                    </x-slot:actions>
                </x-list-item>
 
                <x-menu-separator />
            @endif
 
            {{-- Activates the menu item when a route matches the `link` property --}}
            <x-menu activate-by-route>
                <x-menu-item title="Home" icon="o-home" link="{{ route('home') }}" route="home"/>
                <x-menu-sub title="Products" icon="o-book-open">
                    <x-menu-item title="All products" icon="o-book-open" link="{{ route('products.index') }}" route="products.index"/>
                    <x-menu-item title="Add Product" icon="o-plus-circle" link="{{ route('products.add') }}" route="products.add"/>
                </x-menu-sub>
            </x-menu>
        </x-slot:sidebar>
 
        {{-- The `$slot` goes here --}}
        <x-slot:content>
            {{ $slot }}
        </x-slot:content>
    </x-main>
 
    {{--  TOAST area --}}
    <x-toast />
    @livewireScripts
</body>