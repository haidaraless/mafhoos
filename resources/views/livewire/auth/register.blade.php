<div class="flex flex-col gap-12">
    <div class="w-96">
        <flux:heading size="xl">{{ __('How would like to enter your account?') }}</flux:heading>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form method="POST" wire:submit="register" class="flex flex-col gap-6">
        <div class="flex items-center gap-4 p-6 bg-white rounded-2xl">
            @svg('phosphor-whatsapp-logo-light', 'size-14 text-green-500')
            <div class="flex flex-col">
                <h4 class="text-xl font-semibold">WhatsApp Number</h4>
                <span class="text-sm text-[#9A8C98]">Receive a verification code to your WhatsApp number</span>
            </div>
        </div>
        <div class="flex items-center gap-4 p-6 bg-white rounded-2xl">
            @svg('phosphor-chat-text-light', 'size-14 text-orange-500')
            <div class="flex flex-col">
                <h4 class="text-xl font-semibold">SMS Number</h4>
                <span class="text-sm text-[#9A8C98]">Receive a verification code to your SMS number</span>
            </div>
        </div>
        <div class="flex items-center gap-4 p-6 bg-white rounded-2xl">
            @svg('phosphor-whatsapp-logo-light', 'size-14 text-green-500')
            <div class="flex flex-col">
                <h4 class="text-xl font-semibold">WhatsApp Number</h4>
                <span class="text-sm text-[#9A8C98]">Receive a verification code to your WhatsApp number</span>
            </div>
        </div>
        {{-- <!-- Name -->
        <flux:input
            wire:model="name"
            :label="__('Name')"
            type="text"
            required
            autofocus
            autocomplete="name"
            :placeholder="__('Full name')"
        />

        <!-- Email Address -->
        <flux:input
            wire:model="email"
            :label="__('Email address')"
            type="email"
            required
            autocomplete="email"
            placeholder="email@example.com"
        />

        <!-- Password -->
        <flux:input
            wire:model="password"
            :label="__('Password')"
            type="password"
            required
            autocomplete="new-password"
            :placeholder="__('Password')"
            viewable
        />

        <!-- Confirm Password -->
        <flux:input
            wire:model="password_confirmation"
            :label="__('Confirm password')"
            type="password"
            required
            autocomplete="new-password"
            :placeholder="__('Confirm password')"
            viewable
        />

        <div class="flex items-center justify-end">
            <flux:button type="submit" variant="primary" class="w-full">
                {{ __('Create account') }}
            </flux:button>
        </div> --}}
    </form>

    {{-- <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
        <span>{{ __('Already have an account?') }}</span>
        <flux:link :href="route('login')" wire:navigate>{{ __('Log in') }}</flux:link>
    </div> --}}
</div>
