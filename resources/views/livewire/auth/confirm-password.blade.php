<div class="flex flex-col justify-between w-full h-full">
    <div class="grid grid-cols-1 gap-12">
        <div class="col-span-1 max-w-lg">
            <h1 class="text-5xl text-dark-lavender font-bold">
                {{ __('Confirm password') }}
            </h1>
        </div>
        <!-- Session Status -->
        <x-auth-session-status :status="session('status')" />

        <form method="POST" action="{{ route('password.confirm.store') }}" class="col-span-1 flex flex-col gap-4">
            @csrf

            <label for="password" class="flex items-center gap-4 p-4 max-w-xl text-rose-quartz hover:text-green-500 @error('password') text-rose-500 @enderror bg-rose-quartz/10 hover:bg-white transition-all ease-in-out duration-300 cursor-pointer rounded-2xl">
                @svg('phosphor-password-light', 'size-10')
                <div class="flex flex-col w-full">
                    <h4 class="text-lg text-dark-lavender font-medium">{{ __('Password') }}</h4>
                    <input type="password" name="password" id="password" required autocomplete="current-password" placeholder="********" class="w-full text-2xl text-dark-lavender placeholder:text-pale-dogwood font-semibold focus:outline-none focus:ring-0 focus:border-none"/>
                    @error('password')
                        <span class="mt-0.5 text-xs text-rose-500">{{ $message }}</span>
                    @enderror
                </div>
            </label>

            <button type="submit" class="flex items-center gap-4 p-4 max-w-xl min-h-24 text-sm text-white bg-light-lavender hover:bg-dark-lavender transition-all ease-in-out duration-300 cursor-pointer rounded-2xl" data-test="confirm-password-button">
                <div class="flex flex-col w-full text-left">
                    <h4 class="text-2xl font-semibold">{{ __('Confirm') }}</h4>
                    <span class="text-pale-dogwood">{{ __('Please confirm your password to continue') }}</span>
                </div>
                @svg('phosphor-arrow-right-light', 'size-10')
            </button>
        </form>
    </div>
</div>
