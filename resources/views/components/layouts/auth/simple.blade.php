<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen font-montserrat bg-[#f2e9e4] antialiased dark:bg-linear-to-b dark:from-neutral-950 dark:to-neutral-900">
        <div class="flex min-h-svh w-full p-10 gap-10">
            <div class="relative flex w-2/3">
                <a href="{{ route('home') }}" class="absolute top-0 left-0" wire:navigate>
                    <span class="flex items-center gap-2">
                        <x-app-logo-icon />
                        <span class="text-3xl text-[#4A4E69] tracking-tighter font-light uppercase">mafhoos</span>
                    </span>
                    <span class="sr-only">{{ config('app.name', 'Laravel') }}</span>
                </a>
                <div class="flex w-full gap-6 mt-40">
                    {{ $slot }}
                </div>
            </div>
            <div class="flex w-1/3 items-center justify-center bg-[#22223b] text-white rounded-3xl">
                <span>Onboarding</span>
            </div>
        </div>
        
        @fluxScripts
    </body>
</html>
