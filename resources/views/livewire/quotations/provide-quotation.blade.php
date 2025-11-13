@use('App\Enums\QuotationType')
<div class="grid grid-cols-1 content-start">
    @if (session()->has('message'))
        <div class="mb-4 rounded-xl border border-emerald-300/60 dark:border-emerald-500/20 bg-emerald-50 dark:bg-emerald-500/10 px-4 py-3 text-emerald-800 dark:text-emerald-300">
            {{ session('message') }}
        </div>
    @endif

    @if ($quotationRequest->type === QuotationType::REPAIR)
        @livewire('quotations.create-repair-quotation', ['quotationRequest' => $quotationRequest, 'inline' => true], key('repair-'.$quotationRequest->id))
    @else
        @livewire('quotations.create-spareparts-quotation', ['quotationRequest' => $quotationRequest, 'inline' => true], key('sp-'.$quotationRequest->id))
    @endif
</div>


