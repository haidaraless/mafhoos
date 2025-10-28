<div class="flex flex-col justify-between w-full h-full">
    <div class="grid grid-cols-1 gap-12">
        <div class="col-span-1 max-w-lg">
            <h1 class="text-5xl text-dark-lavender font-bold">
                {{ __('Create your new mafhoos account') }}
            </h1>
        </div>
        <!-- Session Status -->
        <x-auth-session-status :status="session('status')" />

        <form method="POST" wire:submit="register" class="col-span-1 flex flex-col gap-4">
            <label for="name" class="flex items-center gap-4 p-4 max-w-xl text-rose-quartz hover:text-green-500 bg-rose-quartz/10 hover:bg-white transition-all ease-in-out duration-300 cursor-pointer rounded-2xl">
                @svg('phosphor-identification-badge-light', 'size-10')
                <div class="flex flex-col w-full">
                    <h4 class="text-lg text-dark-lavender font-medium">Full Name</h4>
                    <input type="text" name="name" id="name" wire:model="name" autofocus required placeholder="Haidar Alessa" class="w-full text-2xl text-dark-lavender placeholder:text-pale-dogwood font-semibold focus:outline-none focus:ring-0 focus:border-none"/>
                    @error('name')
                        <span class="mt-0.5 text-xs text-rose-500">{{ $message }}</span>
                    @enderror
                </div>
            </label>
            <label for="email" class="flex items-center gap-4 p-4 max-w-xl text-rose-quartz hover:text-green-500 @error('email') text-rose-500 @enderror bg-rose-quartz/10 hover:bg-white transition-all ease-in-out duration-300 cursor-pointer rounded-2xl">
                @svg('phosphor-envelope-simple-light', 'size-10')
                <div class="flex flex-col w-full">
                    <h4 class="text-lg text-dark-lavender font-medium">Email Address</h4>
                    <input type="email" name="email" id="email" wire:model="email" required placeholder="example@example.com" class="w-full text-2xl text-dark-lavender placeholder:text-pale-dogwood font-semibold focus:outline-none focus:ring-0 focus:border-none"/>
                    @error('email')
                        <span class="mt-0.5 text-xs text-rose-500">{{ $message }}</span>
                    @enderror
                </div>
            </label>
            <label for="password" class="flex items-center gap-4 p-4 max-w-xl text-rose-quartz hover:text-green-500 error:text-rose-500 bg-rose-quartz/10 hover:bg-white transition-all ease-in-out duration-300 cursor-pointer rounded-2xl">
                @svg('phosphor-password-light', 'size-10')
                <div class="flex flex-col w-full">
                    <h4 class="text-lg text-dark-lavender font-medium">Password</h4>
                    <input type="password" name="password" id="password" wire:model="password" required placeholder="********" class="w-full text-2xl text-dark-lavender placeholder:text-pale-dogwood font-semibold focus:outline-none focus:ring-0 focus:border-none"/>
                    @error('password')
                        <span class="mt-0.5 text-xs text-rose-500">{{ $message }}</span>
                    @enderror
                </div>
            </label>
            <label for="password_confirmation" class="flex items-center gap-4 p-4 max-w-xl text-rose-quartz hover:text-green-500 bg-rose-quartz/10 hover:bg-white transition-all ease-in-out duration-300 cursor-pointer rounded-2xl">
                @svg('phosphor-password-light', 'size-10')
                <div class="flex flex-col w-full">
                    <h4 class="text-lg text-dark-lavender font-medium">Confirm Password</h4>
                    <input type="password" name="password_confirmation" id="password_confirmation" wire:model="password_confirmation" required placeholder="********" class="w-full text-2xl text-dark-lavender placeholder:text-pale-dogwood font-semibold focus:outline-none focus:ring-0 focus:border-none"/>
                    @error('password_confirmation')
                        <span class="mt-0.5text-xs text-rose-500">{{ $message }}</span>
                    @enderror
                </div>
            </label>
            <button type="submit" class="flex items-center gap-4 p-4 max-w-xl min-h-24 text-sm text-white bg-light-lavender hover:bg-dark-lavender transition-all ease-in-out duration-300 cursor-pointer rounded-2xl">
                <div class="flex flex-col w-full text-left">
                    <h4 class="text-2xl font-semibold">Create Account</h4>
                    <span wire:loading.remove wire:target="register" class="text-pale-dogwood">Create your new mafhoos account</span>
                    <span wire:loading wire:target="register" class="text-pale-dogwood">Creating...</span>
                </div>
                <span wire:loading wire:target="register">
                    <svg class="animate-spin size-10 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </span>
                <span wire:loading.remove wire:target="register">
                    @svg('phosphor-arrow-right-light', 'size-10')
                </span>
            </button>
        </form>
    </div>
    <div class="flex items-center gap-2">
        <span>{{ __('Already have an account?') }}</span>
        <flux:link :href="route('login')" wire:navigate>{{ __('Log in') }}</flux:link>
    </div>
</div>
