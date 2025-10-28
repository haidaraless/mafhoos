<div class="flex flex-col justify-between w-full h-full">
    <div class="grid grid-cols-1 gap-12">
        <div class="col-span-1 max-w-lg">
            <h1 class="text-5xl text-dark-lavender font-bold" x-show="!showRecoveryInput">
                {{ __('Two-factor authentication') }}
            </h1>
            <h1 class="text-5xl text-dark-lavender font-bold" x-show="showRecoveryInput">
                {{ __('Recovery Code') }}
            </h1>
        </div>

        <div
            class="relative w-full h-auto"
            x-cloak
            x-data="{
                showRecoveryInput: @js($errors->has('recovery_code')),
                code: '',
                recovery_code: '',
                toggleInput() {
                    this.showRecoveryInput = !this.showRecoveryInput;

                    this.code = '';
                    this.recovery_code = '';

                    $dispatch('clear-2fa-auth-code');

                    $nextTick(() => {
                        this.showRecoveryInput
                            ? this.$refs.recovery_code?.focus()
                            : $dispatch('focus-2fa-auth-code');
                    });
                },
            }"
        >
            <form method="POST" action="{{ route('two-factor.login.store') }}" class="col-span-1 flex flex-col gap-4">
                @csrf

                <div x-show="!showRecoveryInput" class="col-span-1 flex flex-col gap-4">
                    <label class="flex items-center gap-4 p-4 max-w-xl text-rose-quartz bg-rose-quartz/10 hover:text-green-500 hover:bg-white transition-all ease-in-out duration-300 cursor-pointer rounded-2xl">
                        @svg('phosphor-shield-check-light', 'size-10')
                        <div class="flex flex-col w-full">
                            <h4 class="text-lg text-dark-lavender font-medium">{{ __('Authentication Code') }}</h4>
                            <div class="flex items-center justify-center py-2">
                                <x-input-otp name="code" digits="6" autocomplete="one-time-code" x-model="code" />
                            </div>
                            @error('code')
                                <span class="mt-0.5 text-xs text-rose-500">{{ $message }}</span>
                            @enderror
                        </div>
                    </label>
                </div>

                <div x-show="showRecoveryInput" class="col-span-1 flex flex-col gap-4">
                    <label class="flex items-center gap-4 p-4 max-w-xl text-rose-quartz bg-rose-quartz/10 hover:text-green-500 hover:bg-white transition-all ease-in-out duration-300 cursor-pointer rounded-2xl">
                        @svg('phosphor-key-light', 'size-10')
                        <div class="flex flex-col w-full">
                            <h4 class="text-lg text-dark-lavender font-medium">{{ __('Recovery Code') }}</h4>
                            <input type="text" name="recovery_code" x-ref="recovery_code" x-bind:required="showRecoveryInput" autocomplete="one-time-code" x-model="recovery_code" class="w-full text-2xl text-dark-lavender placeholder:text-pale-dogwood font-semibold focus:outline-none focus:ring-0 focus:border-none" />
                            @error('recovery_code')
                                <span class="mt-0.5 text-xs text-rose-500">{{ $message }}</span>
                            @enderror
                        </div>
                    </label>
                </div>

                <button type="submit" class="flex items-center gap-4 p-4 max-w-xl min-h-24 text-sm text-white bg-light-lavender hover:bg-dark-lavender transition-all ease-in-out duration-300 cursor-pointer rounded-2xl">
                    <div class="flex flex-col w-full text-left">
                        <h4 class="text-2xl font-semibold">{{ __('Continue') }}</h4>
                        <span class="text-pale-dogwood" x-show="!showRecoveryInput">{{ __('Enter the code from your authenticator app') }}</span>
                        <span class="text-pale-dogwood" x-show="showRecoveryInput">{{ __('Enter one of your recovery codes') }}</span>
                    </div>
                    @svg('phosphor-arrow-right-light', 'size-10')
                </button>

                <div class="mt-5 space-x-0.5 text-sm leading-5">
                    <span class="opacity-50">{{ __('or you can') }}</span>
                    <span class="font-medium underline cursor-pointer opacity-80" @click="toggleInput()" x-show="!showRecoveryInput">{{ __('login using a recovery code') }}</span>
                    <span class="font-medium underline cursor-pointer opacity-80" @click="toggleInput()" x-show="showRecoveryInput">{{ __('login using an authentication code') }}</span>
                </div>
            </form>
        </div>
    </div>
</div>
