<div class="flex items-center justify-center w-full h-full">
    <div class="grid grid-cols-1 overflow-hidden border border-neutral-300 rounded-2xl">
        <div class="col-span-1 flex items-center justify-between gap-20 p-6 bg-neutral-50 border-b border-neutral-300">
            <div class="flex flex-col">
                <h1 class="text-3xl text-neutral-800 font-bold" x-show="!showRecoveryInput">{{ __('Two-factor authentication') }}</h1>
                <h1 class="text-3xl text-neutral-800 font-bold" x-show="showRecoveryInput">{{ __('Recovery Code') }}</h1>
                <p class="text-neutral-600" x-show="!showRecoveryInput">{{ __('Enter the code from your authenticator app') }}</p>
                <p class="text-neutral-600" x-show="showRecoveryInput">{{ __('Enter one of your recovery codes') }}</p>
            </div>
            @svg('phosphor-shield-check-light', 'size-12 text-orange-500')
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
            <form method="POST" action="{{ route('two-factor.login.store') }}" class="grid grid-cols-1">
                @csrf

                <div x-show="!showRecoveryInput" class="col-span-1 flex flex-col gap-4">
                    <label class="flex items-center gap-4 px-6 py-4 text-neutral-800 bg-white hover:text-green-500 hover:bg-white transition-all ease-in-out duration-300 cursor-pointer">
                        @svg('phosphor-shield-check-light', 'size-10')
                        <div class="flex flex-col w-full">
                            <h4 class="text-lg text-neutral-800 font-medium">{{ __('Authentication Code') }}</h4>
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
                    <label class="flex items-center gap-4 px-6 py-4 text-neutral-800 bg-white hover:text-green-500 hover:bg-white border-t border-neutral-300 transition-all ease-in-out duration-300 cursor-pointer">
                        @svg('phosphor-key-light', 'size-10')
                        <div class="flex flex-col w-full">
                            <h4 class="text-lg text-neutral-800 font-medium">{{ __('Recovery Code') }}</h4>
                            <input type="text" name="recovery_code" x-ref="recovery_code" x-bind:required="showRecoveryInput" autocomplete="one-time-code" x-model="recovery_code" class="w-full text-2xl text-neutral-800 placeholder:text-neutral-400 font-semibold focus:outline-none focus:ring-0 focus:border-none" />
                            @error('recovery_code')
                                <span class="mt-0.5 text-xs text-rose-500">{{ $message }}</span>
                            @enderror
                        </div>
                    </label>
                </div>

                <button type="submit" class="flex items-center gap-16 px-6 py-4 min-h-24 text-sm text-white bg-neutral-800 hover:bg-neutral-900 transition-all ease-in-out duration-300 cursor-pointer">
                    <div class="flex flex-col w-full text-left">
                        <h4 class="text-2xl font-semibold">{{ __('Continue') }}</h4>
                        <span class="text-neutral-400" x-show="!showRecoveryInput">{{ __('Enter the code from your authenticator app') }}</span>
                        <span class="text-neutral-400" x-show="showRecoveryInput">{{ __('Enter one of your recovery codes') }}</span>
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
