<div class="flex items-center justify-center w-full h-full">
    <div class="grid grid-cols-1 overflow-hidden border border-neutral-300 rounded-2xl">
        <div class="col-span-1 flex items-center justify-between gap-20 p-6 bg-neutral-50 border-b border-neutral-300">
            <div class="flex flex-col">
                <h1 class="text-2xl md:text-3xl text-neutral-800 font-bold">{{ __('Forgot password') }}</h1>
                <p class="text-neutral-600">{{ __('We will email you a reset link') }}</p>
            </div>
            @svg('phosphor-lock-key-open-light', 'size-12 text-orange-500')
        </div>
        <!-- Session Status -->
        <x-auth-session-status :status="session('status')" />

        <form method="POST" wire:submit="sendPasswordResetLink" class="grid grid-cols-1">
            <label for="email" class="flex items-center gap-4 px-6 py-4 text-neutral-800 hover:text-green-500 @error('email') text-rose-500 @enderror bg-white hover:bg-white transition-all ease-in-out duration-300 cursor-pointer">
                @svg('phosphor-envelope-simple-light', 'size-6 md:size-10')
                <div class="flex flex-col w-full">
                    <h4 class="text-lg text-neutral-800 font-medium">{{ __('Email Address') }}</h4>
                    <input type="email" name="email" id="email" wire:model="email" required autofocus placeholder="example@example.com" class="w-full text-base md:text-2xl text-neutral-800 placeholder:text-neutral-400 font-semibold focus:outline-none focus:ring-0 focus:border-none"/>
                    @error('email')
                        <span class="mt-0.5 text-xs text-rose-500">{{ $message }}</span>
                    @enderror
                </div>
            </label>

            <button type="submit" class="flex items-center gap-8 md:gap-16 px-4 md:px-6 py-3 md:py-4 min-h-14 md:min-h-24 text-sm text-white bg-neutral-800 hover:bg-neutral-900 transition-all ease-in-out duration-300 cursor-pointer">
                <div class="flex flex-col w-full text-left">
                    <h4 class="text-lg md:text-2xl font-semibold">{{ __('Email password reset link') }}</h4>
                    <span wire:loading.remove wire:target="sendPasswordResetLink" class="text-neutral-400">{{ __('We will send a reset link to your email') }}</span>
                    <span wire:loading wire:target="sendPasswordResetLink" class="text-neutral-400">{{ __('Sending...') }}</span>
                </div>
                <span wire:loading wire:target="sendPasswordResetLink">
                    <svg class="animate-spin size-6 md:size-10 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </span>
                <span wire:loading.remove wire:target="sendPasswordResetLink">
                    @svg('phosphor-arrow-right-light', 'size-6 md:size-10')
                </span>
            </button>
        </form>
    </div>
</div>
