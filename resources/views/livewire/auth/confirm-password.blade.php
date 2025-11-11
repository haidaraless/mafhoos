<div class="flex items-center justify-center w-full h-full">
    <div class="grid grid-cols-1 overflow-hidden border border-neutral-300 rounded-2xl">
        <div class="col-span-1 flex flex-col gap-6 p-3 md:p-6 bg-white border-b border-neutral-300">
            @svg('phosphor-shield-check-light', 'size-10 md:size-12 text-orange-500')
            <div class="flex flex-col">
                <h1 class="text-2xl md:text-3xl text-neutral-800 font-bold">{{ __('Confirm password') }}</h1>
                <p class="text-neutral-600">{{ __('Please confirm your password to continue') }}</p>
            </div>
        </div>
        <!-- Session Status -->
        <x-auth-session-status :status="session('status')" />

        <form method="POST" action="{{ route('password.confirm.store') }}" class="grid grid-cols-1">
            @csrf

            <label for="password" class="flex items-center gap-2 md:gap-4 px-3 md:px-6 py-4 hover:text-green-500 @error('password') text-rose-500 @enderror bg-white hover:bg-white transition-all ease-in-out duration-300 cursor-pointer">
                @svg('phosphor-password-light', 'size-6 md:size-10')
                <div class="flex flex-col w-full">
                    <h4 class="text-lg text-neutral-800 font-medium">{{ __('Password') }}</h4>
                    <input type="password" name="password" id="password" required autocomplete="current-password" placeholder="********" class="w-full text-base md:text-2xl text-neutral-800 placeholder:text-neutral-400 font-semibold focus:outline-none focus:ring-0 focus:border-none"/>
                    @error('password')
                        <span class="mt-0.5 text-xs text-rose-500">{{ $message }}</span>
                    @enderror
                </div>
            </label>

            <button type="submit" class="flex items-center gap-8 md:gap-16 px-4 md:px-6 py-3 md:py-4 min-h-14 md:min-h-24 text-sm text-white bg-neutral-800 hover:bg-neutral-900 transition-all ease-in-out duration-300 cursor-pointer" data-test="confirm-password-button">
                <div class="flex flex-col w-full text-left">
                    <h4 class="text-lg md:text-2xl font-semibold">{{ __('Confirm') }}</h4>
                    <span class="text-neutral-400">{{ __('Please confirm your password to continue') }}</span>
                </div>
                @svg('phosphor-arrow-right-light', 'size-6 md:size-10')
            </button>
        </form>
    </div>
</div>
