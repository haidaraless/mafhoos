<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen flex flex-col font-montserrat text-neutral-800 bg-white antialiased dark:text-white dark:bg-neutral-950">
        <header class="container mx-auto flex items-center w-full h-36 px-10">
            <a href="{{ route('home') }}" wire:navigate>
                <span class="flex items-center gap-2 text-orange-600 font-medium uppercase">
                    <x-app-logo-icon />
                    <span class="text-2xl tracking-tighter font-medium uppercase">mafhoos</span>
                </span>
                <span class="sr-only">{{ config('app.name', 'Laravel') }}</span>
            </a>
        </header>
        <main class="container mx-auto flex-1 flex items-center justify-center p-8 bg-neutral-100 rounded-4xl">
            {{ $slot }}
        </main>
        <footer class="flex items-center mt-auto h-20">
            <div class="container mx-auto">
                <div class="flex items-center justify-between px-10">
                    <span class="text-base tracking-tighter font-light">Mafhoos &copy; {{ date('Y') }}</span>
                    <div class="flex items-center gap-4 text-base tracking-tighter font-light">
                        <a href="#" class="hover:text-orange-600 transition-all ease-in-out duration-300">About</a>
                        <a href="#" class="hover:text-orange-600 transition-all ease-in-out duration-300">Terms</a>
                        <a href="#" class="hover:text-orange-600 transition-all ease-in-out duration-300">Privacy</a>
                        @svg('phosphor-minus-light', 'size-5')
                        <a href="https://github.com/haidaraless/mafhoos" target="_blank" class="hover:text-orange-600 transition-all ease-in-out duration-300">v1.0.0</a>
                    </div>
                </div>
            </div>
        </footer>
        
        @fluxScripts
    </body>
</html>
