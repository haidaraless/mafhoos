<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen flex flex-col font-montserrat text-neutral-800 bg-white antialiased dark:text-white dark:bg-neutral-950">
    <flux:header container class="h-36">
        <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

        <div class="flex items-center gap-8 max-lg:hidden">

            <a href="{{ route('dashboard') }}" wire:navigate>
                <span class="flex items-center gap-2 text-orange-600">
                    <x-app-logo-icon />
                    <span class="text-2xl tracking-tighter font-medium uppercase">mafhoos</span>
                </span>
                <span class="sr-only">{{ config('app.name', 'Laravel') }}</span>
            </a>
            @svg('phosphor-minus', 'size-6')
            <div class="flex items-center gap-8 text-base font-medium">
                @php
                    $currentAccount = Auth::user()->currentAccount;
                    $isVehicleInspectionCenter = $currentAccount->isProvider() 
                        && $currentAccount->accountable instanceof \App\Models\Provider
                        && $currentAccount->accountable->type === \App\Enums\ProviderType::VEHICLE_INSPECTION_CENTER;
                @endphp
                @if (!$isVehicleInspectionCenter)
                    <a href="{{ route('quotation-requests.browse') }}" wire:navigate class="text-neutral-900 hover:text-orange-600 transition-colors duration-200">Quotation Requests</a>
                @endif
                @if ($isVehicleInspectionCenter)
                    <a href="{{ route('appointments.index') }}" wire:navigate class="text-neutral-900 hover:text-orange-600 transition-colors duration-200">Appointments</a>
                    <a href="{{ route('providers.available-times.manage') }}" wire:navigate class="text-neutral-900 hover:text-orange-600 transition-colors duration-200">Available Times</a>
                @endif
            </div>
            {{-- @auth
                <div class="max-lg:hidden">
                    <livewire:account-switcher />
                </div>
            @endauth --}}

        </div>

        {{-- <flux:spacer /> --}}

        {{-- <flux:navbar class="max-lg:hidden">
            <flux:navbar.item :href="route('dashboard')" :current="request()->routeIs('dashboard')"
                wire:navigate>
                {{ __('Dashboard') }}
            </flux:navbar.item>
        </flux:navbar> --}}

        <flux:spacer />

        <!-- Desktop User Menu -->
        <div class="flex items-center gap-8">
            <livewire:notifications-menu />

            <flux:dropdown position="top" align="end">
                <flux:profile class="cursor-pointer" :initials="auth()->user()->initials()" />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Settings') }}
                        </flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </div>
    </flux:header>

    <!-- Mobile Menu -->
    <flux:sidebar stashable sticky
        class="lg:hidden border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
        <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

        <a href="{{ route('dashboard') }}" class="ms-1 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
            <x-app-logo />
        </a>

        <flux:navlist variant="outline">
            <flux:navlist.group :heading="__('Platform')">
                <flux:navlist.item icon="layout-grid" :href="route('dashboard')"
                    :current="request()->routeIs('dashboard')" wire:navigate>
                    {{ __('Dashboard') }}
                </flux:navlist.item>
                @if (Auth::user()->currentAccount->isProvider())
                    <flux:navlist.item icon="calendar" :href="route('appointments.index')"
                        :current="request()->routeIs('appointments.index')" wire:navigate>{{ __('My Appointments') }}
                    </flux:navlist.item>
                    <flux:navlist.item icon="clock" :href="route('providers.available-times.manage')"
                        :current="request()->routeIs('providers.available-times.manage')" wire:navigate>
                        {{ __('Manage Available Times') }}</flux:navlist.item>
                @endif
            </flux:navlist.group>
        </flux:navlist>

        <flux:spacer />

        {{-- <flux:navlist variant="outline">
            <flux:navlist.item icon="folder-git-2" href="https://github.com/laravel/livewire-starter-kit"
                target="_blank">
                {{ __('Repository') }}
            </flux:navlist.item>

            <flux:navlist.item icon="book-open-text" href="https://laravel.com/docs/starter-kits#livewire"
                target="_blank">
                {{ __('Documentation') }}
            </flux:navlist.item>
        </flux:navlist> --}}
    </flux:sidebar>

    <main class="container mx-auto flex-1 overflow-hidden border border-neutral-900 dark:border-neutral-700 rounded-4xl">
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
