<div class="flex items-center justify-center w-full h-full">
    <div class="grid grid-cols-1 overflow-hidden border border-neutral-300 dark:border-white/10 rounded-2xl bg-white dark:bg-neutral-900">
        <div class="col-span-1 flex flex-col gap-6 p-3 md:p-6 bg-white dark:bg-neutral-900 border-b border-neutral-300 dark:border-white/10">
            @svg('phosphor-envelope-simple-light', 'size-10 md:size-12 text-orange-500')
            <div class="flex flex-col">
                <h1 class="text-2xl md:text-3xl text-neutral-800 dark:text-white font-bold">{{ __('Verify your email') }}</h1>
                <p class="text-neutral-600 dark:text-white/70">{{ __('We just sent you a verification link') }}</p>
            </div>      
        </div>

        <div class="col-span-1 flex flex-col gap-4">
            <div class="px-3 md:px-6 py-4 text-neutral-800 dark:text-white bg-white dark:bg-neutral-900">
                <p class="text-lg text-neutral-800 dark:text-white">
                    {{ __('Please verify your email address by clicking on the link we just emailed to you.') }}
                </p>
            </div>

            @if (session('status') == 'verification-link-sent')
                <div class="p-4 rounded-2xl bg-green-500/10 border border-green-500/30">
                    <p class="text-sm font-medium text-green-600 dark:text-green-300">
                        {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                    </p>
                </div>
            @endif

            <div class="flex flex-col sm:flex-row sm:items-center gap-3 md:gap-4 px-3 md:px-6 py-4 border-t border-neutral-300 dark:border-white/10">
                <button type="button" wire:click="sendVerification" class="flex items-center gap-8 md:gap-16 px-4 md:px-6 py-3 md:py-4 min-h-14 md:min-h-24 text-xs md:text-sm text-white bg-neutral-800 hover:bg-neutral-900 transition-all ease-in-out duration-300 cursor-pointer">
                    <span class="text-left">
                        <h4 class="text-lg md:text-2xl font-semibold">{{ __('Resend verification email') }}</h4>
                        <span wire:loading.remove wire:target="sendVerification" class="text-neutral-400 dark:text-white/60">{{ __('We will send another verification link') }}</span>
                        <span wire:loading wire:target="sendVerification" class="text-neutral-400 dark:text-white/60">{{ __('Sending...') }}</span>
                    </span>
                    <span wire:loading wire:target="sendVerification">
                        <svg class="animate-spin size-6 md:size-10 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </span>
                    <span wire:loading.remove wire:target="sendVerification">
                        @svg('phosphor-arrow-right-light', 'size-6 md:size-10')
                    </span>
                </button>
                <flux:link class="text-sm cursor-pointer text-neutral-700 dark:text-white/70 hover:text-neutral-900 dark:hover:text-white" wire:click="logout">
                    {{ __('Log out') }}
                </flux:link>
            </div>
        </div>
    </div>
</div>
