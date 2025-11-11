@use('App\Enums\QuotationType')
<div class="grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-4">
    <!-- Left: Reference Card styled like vehicle-owner -->
    <div class="col-span-1 grid grid-cols-1 border-r border-neutral-900 dark:border-neutral-700">
        <div class="grid grid-cols-1 gap-6 border-b border-neutral-900 dark:border-neutral-700 p-6">
            <div class="flex items-center justify-between gap-6 text-neutral-800 dark:text-white">
                <div class="w-10">
                    @svg('phosphor-car', 'size-10 text-blue-500')
                </div>
                <span class="text-xl font-normal">{{ $quotationRequest->inspection->appointment->vehicle->year ?? '-' }}</span>
            </div>
            <span class="text-3xl font-extrabold">
                {{ $quotationRequest->inspection->appointment->vehicle->name ?? ($quotationRequest->inspection->appointment->vehicle->make . ' ' . $quotationRequest->inspection->appointment->vehicle->model) }}
            </span>
            <div class="flex flex-col">
                <span>{{ $quotationRequest->inspection->appointment->vehicle->vin ?? '-' }}</span>
                <span>{{ $quotationRequest->inspection->appointment->vehicle->engine_model ?? '-' }}</span>
                <span>{{ $quotationRequest->inspection->appointment->vehicle->fuel_type ?? '-' }}</span>
                <span>{{ $quotationRequest->inspection->appointment->vehicle->drive_type ?? '-' }}</span>
                <span>{{ $quotationRequest->inspection->appointment->vehicle->transmission_style ?? '-' }}</span>
                <span>{{ $quotationRequest->inspection->appointment->vehicle->vehicle_type ?? '-' }}</span>
            </div>
        </div>
        <div class="flex flex-col gap-6 lg:gap-8 p-6 bg-neutral-50">
            <div class="w-1 h-16 bg-neutral-950 dark:bg-white"></div>
            <div class="flex flex-col gap-2">
                <h2 class="text-3xl font-extrabold font-montserrat text-neutral-950 dark:text-white">
                    {{ $quotationRequest->type === QuotationType::REPAIR ? 'Repair' : 'Spare Parts' }} Quotation
                </h2>
                <p class="text-base text-neutral-800">
                    Provide your quotation details below. Review vehicle info on the left.
                </p>
            </div>
        </div>
    </div>

    <!-- Right: Form area -->
    <div class="col-span-3 grid grid-cols-1 gap-8 p-8">
        <div class="grid grid-cols-1 gap-4 content-start">
            <div class="col-span-1 flex items-center gap-2">
                @if ($quotationRequest->type === QuotationType::REPAIR)
                    @svg('phosphor-wrench', 'size-8 text-green-500')
                @else
                    @svg('phosphor-calculator', 'size-8 text-fuchsia-500')
                @endif
                <span class="text-2xl">
                    {{ $quotationRequest->type === QuotationType::REPAIR ? __('Provide Repair Quotation') : __('Provide Spare Parts Quotation') }}
                </span>
            </div>

            <div class="grid grid-cols-1 content-start pl-2">
                @if (session()->has('message'))
                    <div class="mb-4 rounded-xl border border-green-300/60 bg-green-50 px-4 py-3 text-green-800 dark:bg-green-500/10 dark:text-green-300">
                        {{ session('message') }}
                    </div>
                @endif

                @if ($quotationRequest->type === QuotationType::REPAIR)
                    @livewire('quotations.create-repair-quotation', ['quotationRequest' => $quotationRequest, 'inline' => true], key('repair-'.$quotationRequest->id))
                @else
                    @livewire('quotations.create-spareparts-quotation', ['quotationRequest' => $quotationRequest, 'inline' => true], key('sp-'.$quotationRequest->id))
                @endif
            </div>
        </div>
    </div>
</div>


