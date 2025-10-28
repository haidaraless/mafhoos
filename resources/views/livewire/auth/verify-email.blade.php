<div class="flex flex-col justify-between w-full h-full">
    <div class="grid grid-cols-1 gap-12">
        <div class="col-span-1 max-w-lg">
            <h1 class="text-5xl text-dark-lavender font-bold">
                {{ __('Verify your email') }}
            </h1>
        </div>

        <div class="col-span-1 flex flex-col gap-4 max-w-xl">
            <div class="p-4 text-rose-quartz bg-rose-quartz/10 rounded-2xl">
                <p class="text-lg text-dark-lavender">
                    {{ __('Please verify your email address by clicking on the link we just emailed to you.') }}
                </p>
            </div>

            @if (session('status') == 'verification-link-sent')
                <div class="p-4 rounded-2xl bg-green-500/10">
                    <p class="text-sm font-medium text-green-600 dark:text-green-400">
                        {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                    </p>
                </div>
            @endif

            <div class="flex items-center gap-4">
                <button type="button" wire:click="sendVerification" class="flex items-center gap-4 p-4 min-h-20 text-sm text-white bg-light-lavender hover:bg-dark-lavender transition-all ease-in-out duration-300 cursor-pointer rounded-2xl">
                    <span class="text-left">
                        <h4 class="text-2xl font-semibold">{{ __('Resend verification email') }}</h4>
                        <span wire:loading.remove wire:target="sendVerification" class="text-pale-dogwood">{{ __('We will send another verification link') }}</span>
                        <span wire:loading wire:target="sendVerification" class="text-pale-dogwood">{{ __('Sending...') }}</span>
                    </span>
                    <span wire:loading wire:target="sendVerification">
                        <svg class="animate-spin size-10 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </span>
                    <span wire:loading.remove wire:target="sendVerification">
                        @svg('phosphor-arrow-right-light', 'size-10')
                    </span>
                </button>

                <flux:link class="text-sm cursor-pointer" wire:click="logout">
                    {{ __('Log out') }}
                </flux:link>
            </div>
        </div>
    </div>
</div>
