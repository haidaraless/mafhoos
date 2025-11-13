<div class="flex items-center justify-center w-full h-full">
    <div class="grid grid-cols-1 overflow-hidden border border-neutral-300 dark:border-white/10 rounded-2xl bg-white dark:bg-neutral-900">
        <div class="col-span-1 flex flex-col gap-6 p-3 md:p-6 bg-white dark:bg-neutral-900 border-b border-neutral-300 dark:border-white/10">
            @svg('phosphor-sign-in-light', 'size-10 md:size-12 text-orange-500')
            <div class="flex flex-col">
                <h1 class="text-2xl md:text-3xl text-neutral-800 dark:text-white font-bold">{{ __('Log in to mafhoos') }}</h1>
                <p class="text-neutral-600 dark:text-white/70">{{ __('Enter your email and password to continue') }}</p>
            </div>
        </div>
        <!-- Session Status -->
        <x-auth-session-status :status="session('status')" />
    
        <form method="POST" wire:submit="login" class="grid grid-cols-1 bg-white dark:bg-neutral-900">
            <label for="email" class="flex items-center gap-2 md:gap-4 px-3 md:px-6 py-4 hover:text-green-500 @error('email') text-rose-500 @enderror bg-white dark:bg-neutral-900 hover:bg-neutral-50 dark:hover:bg-neutral-800 transition-all ease-in-out duration-300 cursor-pointer">
                @svg('phosphor-envelope-simple-light', 'size-6 md:size-10')
                <div class="flex flex-col w-full">
                    <h4 class="text-base md:text-lg text-neutral-800 dark:text-white font-medium">{{ __('Email Address') }}</h4>
                    <input type="email" name="email" id="email" wire:model="email" required autofocus autocomplete="email" placeholder="example@example.com" class="w-full text-base md:text-2xl text-neutral-800 dark:text-white placeholder:text-neutral-400 dark:placeholder-white/40 font-semibold bg-transparent focus:outline-none focus:ring-0 focus:border-none"/>
                    @error('email')
                        <span class="mt-0.5 text-xs text-rose-500">{{ $message }}</span>
                    @enderror
                </div>
            </label>
    
            <label for="password" class="flex items-center gap-2 md:gap-4 px-3 md:px-6 py-4 hover:text-green-500 @error('password') text-rose-500 @enderror bg-white dark:bg-neutral-900 hover:bg-neutral-50 dark:hover:bg-neutral-800 border-t border-neutral-300 dark:border-white/10 transition-all ease-in-out duration-300 cursor-pointer">
                @svg('phosphor-password-light', 'size-6 md:size-10')
                <div class="flex flex-col w-full">
                    <div class="flex items-center justify-between">
                        <h4 class="text-base md:text-lg text-neutral-800 dark:text-white font-medium">{{ __('Password') }}</h4>
                        @if (Route::has('password.request'))
                            <flux:link class="text-xs md:text-sm" :href="route('password.request')" wire:navigate>
                                {{ __('Forgot password?') }}
                            </flux:link>
                        @endif
                    </div>
                    <input type="password" name="password" id="password" wire:model="password" required autocomplete="current-password" placeholder="********" class="w-full text-base md:text-2xl text-neutral-800 dark:text-white placeholder:text-neutral-400 dark:placeholder-white/40 font-semibold bg-transparent focus:outline-none focus:ring-0 focus:border-none"/>
                    @error('password')
                        <span class="mt-0.5 text-xs text-rose-500">{{ $message }}</span>
                    @enderror
                </div>
            </label>
    
            <button type="submit" class="flex items-center gap-8 md:gap-16 px-4 md:px-6 py-3 md:py-4 min-h-14 md:min-h-24 text-xs md:text-sm text-white bg-neutral-800 hover:bg-neutral-900 transition-all ease-in-out duration-300 cursor-pointer">
                <div class="flex flex-col w-full text-left">
                    <h4 class="text-lg md:text-2xl font-semibold">{{ __('Log in') }}</h4>
                    <span wire:loading.remove wire:target="login" class="text-neutral-400 dark:text-white/60">{{ __('Continue your journey with mafhoos') }}</span>
                    <span wire:loading wire:target="login" class="text-neutral-400 dark:text-white/60">{{ __('Logging in...') }}</span>
                </div>
                <span wire:loading wire:target="login">
                    <svg class="animate-spin size-6 md:size-10 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </span>
                <span wire:loading.remove wire:target="login">
                    @svg('phosphor-arrow-right-light', 'size-6 md:size-10')
                </span>
            </button>
        </form>
    </div>
</div>