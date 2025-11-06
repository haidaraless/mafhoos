<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ env('APP_NAME') }}</title>

        <link rel="icon" href="/favicon.ico" sizes="any">
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png">

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
    <body class="min-h-screen font-montserrat text-dark-lavender bg-alabaster antialiased dark:bg-linear-to-b dark:from-neutral-950 dark:to-neutral-900">
        <div class="flex min-h-svh w-full p-10 gap-10">
            <div class="relative flex w-2/3">
                <a href="{{ route('home') }}" class="absolute top-0 left-0 text-rose-quartz hover:text-dark-lavender transition-all ease-in-out duration-300" wire:navigate>
                    <span class="flex items-center gap-2">
                        <x-app-logo-icon />
                        <span class="text-3xl tracking-tighter font-light uppercase">mafhoos</span>
                    </span>
                    <span class="sr-only">{{ config('app.name', 'Laravel') }}</span>
                </a>
                <div class="flex w-full gap-6 mt-40">
                    <div class="grid grid-cols-1 gap-12">
                        <div class="col-span-1 max-w-2xl">
                            <h1 class="text-5xl text-dark-lavender font-bold">
                                {{ __('Welcome to mafhoos') }}
                            </h1>
                            <p class="mt-4 text-lg text-rose-quartz">
                                {{ __('Streamline vehicle inspections, quotations, and repairs — all in one place.') }}
                            </p>
                        </div>

                        <div class="col-span-1 flex flex-col gap-4 max-w-xl">
                            <a href="{{ route('register') }}" class="flex items-center gap-4 p-4 min-h-24 text-sm text-white bg-light-lavender hover:bg-dark-lavender transition-all ease-in-out duration-300 cursor-pointer rounded-2xl" data-test="cta-register">
                                <div class="flex flex-col w-full text-left">
                                    <h4 class="text-2xl font-semibold">{{ __('Create your account') }}</h4>
                                    <span class="text-pale-dogwood">{{ __('Get started with mafhoos in minutes') }}</span>
                                </div>
                                @svg('phosphor-arrow-right-light', 'size-10')
                            </a>

                            <a href="{{ route('login') }}" class="flex items-center gap-4 p-4 min-h-24 text-sm text-rose-quartz bg-rose-quartz/10 hover:text-green-500 hover:bg-white transition-all ease-in-out duration-300 cursor-pointer rounded-2xl" data-test="cta-login">
                                @svg('phosphor-sign-in-light', 'size-10')
                                <div class="flex flex-col w-full text-left">
                                    <h4 class="text-2xl font-semibold text-dark-lavender">{{ __('Log in') }}</h4>
                                    <span class="text-rose-quartz">{{ __('Already have an account? Continue here') }}</span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex w-1/3 items-center justify-center bg-dark-lavender text-white rounded-3xl">
                <span>Onboarding Figure</span>
            </div>
        </div>
    </body>
</html>
