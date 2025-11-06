<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen font-montserrat text-neutral-800 dark:text-white bg-neutral-50 antialiased dark:bg-linear-to-b dark:from-neutral-950 dark:to-neutral-900">
        <div class="flex min-h-svh w-full p-10 gap-10">
            <div class="relative flex w-full">
                <a href="{{ route('home') }}" class="absolute top-0 left-0 text-neutral-900 hover:text-neutral-950 dark:hover:text-white transition-all ease-in-out duration-300" wire:navigate>
                    <span class="flex items-center gap-2">
                        <x-app-logo-icon />
                        <span class="text-3xl tracking-tighter font-light uppercase">mafhoos</span>
                    </span>
                    <span class="sr-only">{{ config('app.name', 'Laravel') }}</span>
                </a>
                <div class="flex w-full gap-6 mt-40">
                    {{ $slot }}
                </div>
            </div>
        </div>
        
        @fluxScripts
    </body>
</html>
