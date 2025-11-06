<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="robots" content="index,follow">
        <meta name="author" content="{{ config('app.name') }} Team">
        <meta name="description" content="{{ __('Streamline vehicle inspections, quotations, and repairs — all in one place.') }}">

        <link rel="canonical" href="{{ url()->current() }}">

        <title>{{ config('app.name') }}</title>

        <link rel="icon" href="/favicon.ico" sizes="any">
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png">

        <meta name="theme-color" content="#111827" media="(prefers-color-scheme: dark)">
        <meta name="theme-color" content="#fafafa" media="(prefers-color-scheme: light)">

        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:title" content="{{ config('app.name') }}">
        <meta property="og:description" content="{{ __('Streamline vehicle inspections, quotations, and repairs — all in one place.') }}">
        <meta property="og:image" content="{{ asset('apple-touch-icon.png') }}">

        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="{{ config('app.name') }}">
        <meta name="twitter:description" content="{{ __('Streamline vehicle inspections, quotations, and repairs — all in one place.') }}">
        <meta name="twitter:image" content="{{ asset('apple-touch-icon.png') }}">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
        
        <style>
            .font-montserrat {
                font-family: "Montserrat", sans-serif;
                font-optical-sizing: auto;
                font-style: normal;
            }
        </style>
        
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen font-montserrat text-neutral-800 dark:text-white bg-neutral-50 antialiased dark:bg-linear-to-b dark:from-neutral-950 dark:to-neutral-900">
        <!-- Top Navigation -->
        <header class="w-full">
            <div class="mx-auto max-w-7xl px-6 py-6 flex items-center justify-between">
                <a href="{{ route('home') }}" class="text-neutral-900 hover:text-neutral-950 dark:hover:text-white transition-all ease-in-out duration-300" wire:navigate>
                    <span class="flex items-center gap-2">
                        <x-app-logo-icon />
                        <span class="text-2xl tracking-tighter font-light uppercase">mafhoos</span>
                    </span>
                    <span class="sr-only">{{ config('app.name', 'Laravel') }}</span>
                </a>
                <div class="hidden md:flex items-center gap-2">
                    <a href="{{ route('login') }}" class="inline-flex items-center gap-2 px-4 py-2 border border-neutral-300 dark:border-white/20 rounded-full text-sm text-neutral-800 dark:text-white hover:bg-white/60 dark:hover:bg-white/10 transition-all">
                        @svg('phosphor-sign-in-light', 'size-4')
                        <span>{{ __('Log in') }}</span>
                    </a>
                    <a href="{{ route('register') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-orange-600 hover:bg-neutral-800 text-white rounded-full text-sm transition-all">
                        <span>{{ __('Create account') }}</span>
                        @svg('phosphor-arrow-right-light', 'size-4')
                    </a>
                </div>
            </div>
        </header>

        <!-- Hero Section -->
        <section class="relative overflow-hidden">
            <div class="mx-auto max-w-7xl px-6 pt-8 pb-16 grid grid-cols-1 md:grid-cols-2 gap-10 items-center">
                <div class="flex flex-col gap-6">
                    <span class="inline-flex items-center gap-2 text-xs font-semibold px-3 py-1 rounded-full bg-orange-200 dark:bg-white/10 text-orange-700 dark:text-white w-max">
                        @svg('phosphor-calendar-check', 'size-4')
                        <span>{{ __('Inspections • Quotations • Repairs') }}</span>
                    </span>
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold tracking-tight text-neutral-900 dark:text-white">
                        {{ __('Everything you need to manage your vehicle — in one place') }}
                    </h1>
                    <p class="text-base md:text-lg text-neutral-600 dark:text-white/70 max-w-2xl">
                        {{ __('Book inspections, track reports, and request quotations from trusted providers. mafhoos simplifies every step.') }}
                    </p>
                    <div class="flex flex-col sm:flex-row gap-3 sm:gap-4">
                        <a href="{{ route('register') }}" class="inline-flex items-center justify-between gap-6 px-6 py-3 bg-orange-600 hover:bg-neutral-800 text-white text-base font-medium rounded-full">
                            <span>{{ __('Get started free') }}</span>
                            @svg('phosphor-arrow-right-light', 'size-6')
                        </a>
                        <a href="{{ route('login') }}" class="inline-flex items-center justify-between gap-3 px-6 py-3 border border-neutral-300 dark:border-white/20 text-neutral-800 dark:text-white text-base font-medium rounded-full hover:bg-white/70 dark:hover:bg-white/10 transition-all">
                            @svg('phosphor-play-circle', 'size-5 text-violet-500')
                            <span>{{ __('View my dashboard') }}</span>
                        </a>
                    </div>
                    <div class="flex items-center gap-6 pt-2">
                        <div class="flex items-center gap-2 text-sm text-neutral-600 dark:text-white/70">
                            @svg('phosphor-shield-check', 'size-5 text-green-500')
                            <span>{{ __('Secure & private by design') }}</span>
                        </div>
                        <div class="hidden sm:flex items-center gap-2 text-sm text-neutral-600 dark:text-white/70">
                            @svg('phosphor-sparkle', 'size-5 text-amber-500')
                            <span>{{ __('Built for speed and simplicity') }}</span>
                        </div>
                    </div>
                </div>
                <div class="relative">
                    <div class="aspect-[4/3] w-full rounded-3xl border border-neutral-300 dark:border-white/10 bg-white dark:bg-white/5 p-6 md:p-8 flex flex-col justify-between shadow-sm">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="grid grid-cols-1 gap-4 border border-neutral-200 dark:border-white/10 rounded-2xl p-4">
                                <div class="flex items-center gap-3 text-neutral-800 dark:text-white">
                                    @svg('phosphor-car', 'size-6 text-sky-500')
                                    <span class="font-semibold">{{ __('My Vehicles') }}</span>
                                </div>
                                <p class="text-3xl font-extrabold text-neutral-900 dark:text-white">2</p>
                            </div>
                            <div class="grid grid-cols-1 gap-4 border border-neutral-200 dark:border-white/10 rounded-2xl p-4">
                                <div class="flex items-center gap-3 text-neutral-800 dark:text-white">
                                    @svg('phosphor-calendar-dots', 'size-6 text-violet-500')
                                    <span class="font-semibold">{{ __('Upcoming') }}</span>
                                </div>
                                <p class="text-3xl font-extrabold text-neutral-900 dark:text-white">1</p>
                            </div>
                            <div class="grid grid-cols-1 gap-4 border border-neutral-200 dark:border-white/10 rounded-2xl p-4">
                                <div class="flex items-center gap-3 text-neutral-800 dark:text-white">
                                    @svg('phosphor-clock', 'size-6 text-blue-500')
                                    <span class="font-semibold">{{ __('Drafts') }}</span>
                                </div>
                                <p class="text-3xl font-extrabold text-neutral-900 dark:text-white">3</p>
                            </div>
                            <div class="grid grid-cols-1 gap-4 border border-neutral-200 dark:border-white/10 rounded-2xl p-4">
                                <div class="flex items-center gap-3 text-neutral-800 dark:text-white">
                                    @svg('phosphor-calendar-check', 'size-6 text-orange-500')
                                    <span class="font-semibold">{{ __('Completed') }}</span>
                                </div>
                                <p class="text-3xl font-extrabold text-neutral-900 dark:text-white">12</p>
                            </div>
                        </div>
                        <div class="mt-6">
                            <div class="inline-flex items-center justify-between w-full px-4 py-3 border border-neutral-300 dark:border-white/20 text-neutral-800 dark:text-white text-sm font-medium rounded-full">
                                <div class="flex items-center gap-2">
                                    @svg('phosphor-file-text', 'size-5 text-indigo-600')
                                    <span>{{ __('Inspection report ready in minutes') }}</span>
                                </div>
                                @svg('phosphor-arrow-right-light', 'size-6')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Feature Grid -->
        <section class="mx-auto max-w-7xl px-6 py-12">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="grid grid-cols-1 gap-4 border border-neutral-300 dark:border-white/10 p-6 rounded-2xl bg-white dark:bg-white/5">
                    <div class="flex items-center gap-3 text-neutral-800 dark:text-white">
                        <span class="inline-flex items-center justify-center size-10 rounded-xl bg-violet-500/10 text-violet-600 dark:text-violet-300">
                            @svg('phosphor-calendar-plus', 'size-6')
                        </span>
                        <span class="text-xl font-extrabold">{{ __('Book Inspections') }}</span>
                    </div>
                    <p class="text-sm text-neutral-600 dark:text-white/70">{{ __('Schedule with verified providers at times that suit you.') }}</p>
                </div>
                <div class="grid grid-cols-1 gap-4 border border-neutral-300 dark:border-white/10 p-6 rounded-2xl bg-white dark:bg-white/5">
                    <div class="flex items-center gap-3 text-neutral-800 dark:text-white">
                        <span class="inline-flex items-center justify-center size-10 rounded-xl bg-amber-500/10 text-amber-600 dark:text-amber-300">
                            @svg('phosphor-calculator', 'size-6')
                        </span>
                        <span class="text-xl font-extrabold">{{ __('Request Quotes') }}</span>
                    </div>
                    <p class="text-sm text-neutral-600 dark:text-white/70">{{ __('Get accurate quotations for parts and repairs—fast.') }}</p>
                </div>
                <div class="grid grid-cols-1 gap-4 border border-neutral-300 dark:border-white/10 p-6 rounded-2xl bg-white dark:bg-white/5">
                    <div class="flex items-center gap-3 text-neutral-800 dark:text-white">
                        <span class="inline-flex items-center justify-center size-10 rounded-xl bg-green-500/10 text-green-600 dark:text-green-300">
                            @svg('phosphor-wrench', 'size-6')
                        </span>
                        <span class="text-xl font-extrabold">{{ __('Repair with Confidence') }}</span>
                    </div>
                    <p class="text-sm text-neutral-600 dark:text-white/70">{{ __('Choose the best offer and track progress end‑to‑end.') }}</p>
                </div>
                <div class="grid grid-cols-1 gap-4 border border-neutral-300 dark:border-white/10 p-6 rounded-2xl bg-white dark:bg-white/5">
                    <div class="flex items-center gap-3 text-neutral-800 dark:text-white">
                        <span class="inline-flex items-center justify-center size-10 rounded-xl bg-sky-500/10 text-sky-600 dark:text-sky-300">
                            @svg('phosphor-bell', 'size-6')
                        </span>
                        <span class="text-xl font-extrabold">{{ __('Stay Notified') }}</span>
                    </div>
                    <p class="text-sm text-neutral-600 dark:text-white/70">{{ __('Real‑time updates and reminders at every step.') }}</p>
                </div>
            </div>
        </section>

        <div class="border-t border-neutral-300 dark:border-white/10"></div>

        <!-- How it works -->
        <section class="mx-auto max-w-7xl px-6 py-12">
            <h2 class="text-2xl md:text-3xl font-extrabold mb-6 text-neutral-800 dark:text-white">{{ __('How mafhoos works') }}</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="grid grid-cols-1 gap-4 border border-neutral-300 dark:border-white/10 rounded-2xl p-6 bg-white dark:bg-white/5">
                    <div class="flex items-center gap-3 text-neutral-800 dark:text-white">
                        @svg('phosphor-car', 'size-6 text-sky-500')
                        <span class="text-lg font-semibold">{{ __('Add your vehicle') }}</span>
                    </div>
                    <p class="text-sm text-neutral-600 dark:text-white/70">{{ __('Create your account and register your vehicle in minutes.') }}</p>
                </div>
                <div class="grid grid-cols-1 gap-4 border border-neutral-300 dark:border-white/10 rounded-2xl p-6 bg-white dark:bg-white/5">
                    <div class="flex items-center gap-3 text-neutral-800 dark:text-white">
                        @svg('phosphor-calendar-dots', 'size-6 text-violet-500')
                        <span class="text-lg font-semibold">{{ __('Book an inspection') }}</span>
                    </div>
                    <p class="text-sm text-neutral-600 dark:text-white/70">{{ __('Select a provider, inspection type, date and time that works.') }}</p>
                </div>
                <div class="grid grid-cols-1 gap-4 border border-neutral-300 dark:border-white/10 rounded-2xl p-6 bg-white dark:bg-white/5">
                    <div class="flex items-center gap-3 text-neutral-800 dark:text-white">
                        @svg('phosphor-wrench', 'size-6 text-green-500')
                        <span class="text-lg font-semibold">{{ __('Get quotes & repair') }}</span>
                    </div>
                    <p class="text-sm text-neutral-600 dark:text-white/70">{{ __('Receive quotations, compare options, and proceed with confidence.') }}</p>
                </div>
            </div>
        </section>

        <!-- Call to action banner -->
        <section class="mx-auto max-w-7xl px-6 pb-16">
            <div class="flex flex-col gap-6 lg:gap-8 p-6 lg:p-8 bg-orange-200 rounded-2xl">
                <div class="flex flex-col">
                    <h3 class="text-2xl md:text-3xl font-extrabold text-orange-950 dark:text-white">{{ __('Ready to get started?') }}</h3>
                    <p class="text-base text-orange-800">{{ __('Join mafhoos today and handle inspections, quotes, and repairs seamlessly.') }}</p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('register') }}" class="inline-flex items-center justify-between gap-16 px-6 py-3 bg-white text-neutral-800 dark:text-white text-base font-medium rounded-full">
                        <div class="flex items-center gap-2">
                            @svg('phosphor-user-plus', 'size-5 text-amber-500')
                            <span>{{ __('Create a free account') }}</span>
                        </div>
                        @svg('phosphor-arrow-right-light', 'size-6')
                    </a>
                    <a href="{{ route('login') }}" class="inline-flex items-center gap-2 px-6 py-3 border border-orange-900 dark:border-white/20 text-orange-900 dark:text-white text-base font-medium rounded-full">
                        @svg('phosphor-sign-in-light', 'size-5')
                        <span>{{ __('I already have an account') }}</span>
                    </a>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="mx-auto max-w-7xl px-6 pb-8">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-neutral-500">
                <span>&copy; {{ date('Y') }} {{ config('app.name', 'mafhoos') }}. {{ __('All rights reserved.') }}</span>
                <div class="flex items-center gap-4">
                    <a href="{{ route('login') }}" class="hover:text-neutral-900 dark:hover:text-white transition">{{ __('Log in') }}</a>
                    <a href="{{ route('register') }}" class="hover:text-neutral-900 dark:hover:text-white transition">{{ __('Register') }}</a>
                </div>
            </div>
        </footer>
    </body>
</html>
