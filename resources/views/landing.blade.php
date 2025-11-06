<div class="flex flex-col justify-between w-full h-full">
    <div class="grid grid-cols-1 gap-12">
        <div class="col-span-1 max-w-2xl">
            <h1 class="text-5xl text-neutral-800 dark:text-white font-bold">
                {{ __('Welcome to mafhoos') }}
            </h1>
            <p class="mt-4 text-lg text-neutral-600 dark:text-white/70">
                {{ __('Streamline vehicle inspections, quotations, and repairs — all in one place.') }}
            </p>
        </div>

        <div class="col-span-1 flex flex-col gap-4 max-w-xl">
            <a href="{{ route('register') }}" class="flex items-center gap-4 p-4 min-h-24 text-sm text-white bg-indigo-600 hover:bg-neutral-800 transition-all ease-in-out duration-300 cursor-pointer rounded-2xl" data-test="cta-register">
                <div class="flex flex-col w-full text-left">
                    <h4 class="text-2xl font-semibold">{{ __('Create your account') }}</h4>
                    <span class="text-neutral-400">{{ __('Get started with mafhoos in minutes') }}</span>
                </div>
                @svg('phosphor-arrow-right-light', 'size-10')
            </a>

            <a href="{{ route('login') }}" class="flex items-center gap-4 p-4 min-h-24 text-sm text-neutral-600 dark:text-white/80 bg-neutral-200 dark:bg-white/10 hover:text-green-500 hover:bg-white transition-all ease-in-out duration-300 cursor-pointer rounded-2xl" data-test="cta-login">
                @svg('phosphor-sign-in-light', 'size-10')
                <div class="flex flex-col w-full text-left">
                    <h4 class="text-2xl font-semibold text-neutral-800 dark:text-white">{{ __('Log in') }}</h4>
                    <span class="text-neutral-600 dark:text-white/80">{{ __('Already have an account? Continue here') }}</span>
                </div>
            </a>
        </div>
    </div>
</div>


