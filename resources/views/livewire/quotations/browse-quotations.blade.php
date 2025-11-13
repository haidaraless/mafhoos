<div class="grid sm:grid-cols-1 lg:grid-cols-4 gap-8 content-start">
    <!-- Statistics -->
    <div class="lg:col-span-1 space-y-6">
        <div class="border border-neutral-300 dark:border-white/10 rounded-2xl p-6 bg-white dark:bg-white/5 shadow-sm">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-2">
                    @svg('phosphor-chart-bar', 'size-6 text-sky-500')
                    <span class="text-lg font-semibold text-neutral-900 dark:text-white">Quotation Insights</span>
                </div>
                <span class="text-xs uppercase tracking-wide text-neutral-500 dark:text-white/50">{{ now()->format('M Y') }}</span>
            </div>

            <div class="space-y-6">
                <!-- Total -->
                <div class="space-y-2">
                    <div class="flex items-center gap-2 text-xs uppercase tracking-wide text-neutral-500 dark:text-white/50">
                        @svg('phosphor-stack', 'size-4')
                        <span>Total Requests</span>
                    </div>
                    <div class="flex items-baseline gap-2">
                        <span class="text-4xl font-bold text-neutral-900 dark:text-white">{{ number_format($statistics['total']) }}</span>
                        <span class="text-sm text-neutral-500 dark:text-white/60">overall</span>
                    </div>
                </div>

                <!-- Status Breakdown -->
                <div class="space-y-3">
                    <div class="flex items-center gap-2 text-xs uppercase tracking-wide text-neutral-500 dark:text-white/50">
                        @svg('phosphor-traffic-signal', 'size-4')
                        <span>Status Breakdown</span>
                    </div>
                    <div class="space-y-2">
                        <div class="flex items-center justify-between p-2 rounded-lg bg-sky-50 dark:bg-sky-500/10 border border-sky-200 dark:border-sky-500/20">
                            <div class="flex items-center gap-2">
                                <div class="w-2 h-2 rounded-full bg-sky-500"></div>
                                <span class="text-sm font-medium text-neutral-700 dark:text-white/80">Open</span>
                            </div>
                            <span class="text-lg font-bold text-sky-700 dark:text-sky-300">{{ $statistics['statusCounts']['open'] }}</span>
                        </div>

                        <div class="flex items-center justify-between p-2 rounded-lg bg-yellow-50 dark:bg-yellow-500/10 border border-yellow-200 dark:border-yellow-500/20">
                            <div class="flex items-center gap-2">
                                <div class="w-2 h-2 rounded-full bg-yellow-500"></div>
                                <span class="text-sm font-medium text-neutral-700 dark:text-white/80">Pending</span>
                            </div>
                            <span class="text-lg font-bold text-yellow-700 dark:text-yellow-300">{{ $statistics['statusCounts']['pending'] }}</span>
                        </div>

                        <div class="flex items-center justify-between p-2 rounded-lg bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/20">
                            <div class="flex items-center gap-2">
                                <div class="w-2 h-2 rounded-full bg-emerald-500"></div>
                                <span class="text-sm font-medium text-neutral-700 dark:text-white/80">Quoted</span>
                            </div>
                            <span class="text-lg font-bold text-emerald-700 dark:text-emerald-300">{{ $statistics['statusCounts']['quoted'] }}</span>
                        </div>

                        @if($statistics['statusCounts']['cancelled'] > 0)
                            <div class="flex items-center justify-between p-2 rounded-lg bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-500/20">
                                <div class="flex items-center gap-2">
                                    <div class="w-2 h-2 rounded-full bg-red-500"></div>
                                    <span class="text-sm font-medium text-neutral-700 dark:text-white/80">Cancelled</span>
                                </div>
                                <span class="text-lg font-bold text-red-700 dark:text-red-300">{{ $statistics['statusCounts']['cancelled'] }}</span>
                            </div>
                        @endif

                        @if($statistics['statusCounts']['expired'] > 0)
                            <div class="flex items-center justify-between p-2 rounded-lg bg-neutral-50 dark:bg-white/5 border border-neutral-200 dark:border-white/10">
                                <div class="flex items-center gap-2">
                                    <div class="w-2 h-2 rounded-full bg-neutral-500"></div>
                                    <span class="text-sm font-medium text-neutral-700 dark:text-white/80">Expired</span>
                                </div>
                                <span class="text-lg font-bold text-neutral-700 dark:text-white/70">{{ $statistics['statusCounts']['expired'] }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Type Breakdown -->
                <div class="space-y-3 pt-4 border-t border-neutral-200 dark:border-neutral-700">
                    <div class="flex items-center gap-2 text-xs uppercase tracking-wide text-neutral-500 dark:text-white/50">
                        @svg('phosphor-engine', 'size-4')
                        <span>Type Breakdown</span>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div class="flex flex-col gap-1 p-3 rounded-xl bg-violet-50 dark:bg-violet-500/10 border border-violet-200 dark:border-violet-500/20">
                            <span class="text-xs uppercase tracking-wide text-violet-600 dark:text-violet-300">Repair</span>
                            <span class="text-2xl font-extrabold text-neutral-900 dark:text-white">{{ $statistics['typeCounts']['repair'] }}</span>
                        </div>
                        <div class="flex flex-col gap-1 p-3 rounded-xl bg-amber-50 dark:bg-amber-500/10 border border-amber-200 dark:border-amber-500/20">
                            <span class="text-xs uppercase tracking-wide text-amber-600 dark:text-amber-300">Spare Parts</span>
                            <span class="text-2xl font-extrabold text-neutral-900 dark:text-white">{{ $statistics['typeCounts']['spare-parts'] }}</span>
                        </div>
                    </div>
                </div>

                <!-- Monthly Completion Rate -->
                <div class="space-y-2 pt-4 border-t border-neutral-200 dark:border-neutral-700">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2 text-xs uppercase tracking-wide text-neutral-500 dark:text-white/50">
                            @svg('phosphor-gauge', 'size-4')
                            <span>Quote Conversion</span>
                        </div>
                        <span class="text-2xl font-bold text-neutral-900 dark:text-white">{{ $statistics['completionRate'] }}%</span>
                    </div>
                    <div class="w-full bg-neutral-200 dark:bg-neutral-700 rounded-full h-2 overflow-hidden">
                        <div
                            class="h-full bg-gradient-to-r from-emerald-500 to-green-500 transition-all duration-500"
                            style="width: {{ $statistics['completionRate'] }}%"
                        ></div>
                    </div>
                    <p class="text-xs text-neutral-500 dark:text-white/50">Quoted requests relative to your total submissions.</p>
                </div>

                <!-- Highlights -->
                <div class="grid grid-cols-1 gap-3">
                    <div class="space-y-2 p-4 rounded-xl bg-orange-50 dark:bg-orange-500/10 border border-orange-200 dark:border-orange-500/20">
                        <div class="flex items-center gap-2 text-xs uppercase tracking-wide text-orange-700 dark:text-orange-300">
                            @svg('phosphor-hourglass-medium', 'size-4')
                            <span>Awaiting Action</span>
                        </div>
                        <div class="flex items-baseline gap-2">
                            <span class="text-3xl font-bold text-orange-900 dark:text-orange-200">{{ $statistics['awaiting'] }}</span>
                            <span class="text-sm text-orange-700 dark:text-orange-300">open or pending</span>
                </div>
            </div>

                    <div class="space-y-1 p-4 rounded-xl bg-blue-50 dark:bg-blue-500/10 border border-blue-200 dark:border-blue-500/20">
                        <div class="flex items-center gap-2 text-xs uppercase tracking-wide text-blue-700 dark:text-blue-300">
                            @svg('phosphor-calendar-check', 'size-4')
                            <span>This Month</span>
                        </div>
                        <div class="flex items-baseline gap-2">
                            <span class="text-2xl font-bold text-blue-900 dark:text-blue-200">{{ $statistics['thisMonth'] }}</span>
                            <span class="text-sm text-blue-700 dark:text-blue-300">new requests</span>
                        </div>
                    </div>
                </div>

                @if($statistics['latest'])
                    <div class="space-y-2 p-4 rounded-xl bg-neutral-100 dark:bg-white/10 border border-neutral-200 dark:border-white/10">
                        <div class="flex items-center gap-2 text-xs uppercase tracking-wide text-neutral-600 dark:text-white/60">
                            @svg('phosphor-clock-clockwise', 'size-4')
                            <span>Latest Request</span>
                        </div>
                        <div class="space-y-1 text-sm text-neutral-700 dark:text-white/80">
                            <p class="font-semibold text-neutral-900 dark:text-white">
                                Request #{{ $statistics['latest']->number ?? substr($statistics['latest']->id, -8) }}
                            </p>
                            <p class="text-xs text-neutral-500 dark:text-white/60">
                                {{ $statistics['latest']->created_at->diffForHumans() }}
                                @if(optional($statistics['latest']->inspection->appointment->vehicle)->make)
                                    • {{ $statistics['latest']->inspection->appointment->vehicle->make }}
                                    {{ $statistics['latest']->inspection->appointment->vehicle->model }}
                                @endif
                            </p>
                        </div>
                </div>
            @endif
            </div>
        </div>
    </div>

    <!-- Quotation Requests -->
    <div class="lg:col-span-3 space-y-6">
        <div class="flex items-center gap-3 px-8 pt-8">
                @svg('phosphor-calculator', 'size-8 text-fuchsia-500')
            <h2 class="text-2xl font-normal text-neutral-950 dark:text-white">Quotation Requests</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
            @forelse($quotationRequests as $quotationRequest)
                <div
                    wire:key="quotation-request-{{ $quotationRequest->id }}"
                    class="group relative overflow-hidden border border-neutral-300 dark:border-white/10 rounded-2xl p-6 lg:p-8 bg-white dark:bg-white/5 shadow-sm transition-all duration-200 hover:-translate-y-1 hover:shadow-lg">
                    @php
                        $statusValue = $quotationRequest->status->value;
                        $statusStyles = [
                            'open' => 'bg-blue-100 text-blue-800 dark:bg-blue-500/20 dark:text-blue-300',
                            'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-500/20 dark:text-yellow-300',
                            'quoted' => 'bg-green-100 text-green-800 dark:bg-green-500/20 dark:text-green-300',
                            'cancelled' => 'bg-red-100 text-red-800 dark:bg-red-500/20 dark:text-red-300',
                            'expired' => 'bg-gray-100 text-gray-800 dark:bg-white/10 dark:text-white',
                        ];
                        $statusClass = $statusStyles[$statusValue] ?? 'bg-gray-100 text-gray-800 dark:bg-white/10 dark:text-white';
                    @endphp
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex items-center gap-3">
                            @if($quotationRequest->type->value === 'spare-parts')
                                <span class="inline-flex items-center justify-center size-12 rounded-2xl bg-amber-500/10 text-amber-600 dark:text-amber-300">
                                    @svg('phosphor-calculator', 'size-6')
                                </span>
                            @else
                                <span class="inline-flex items-center justify-center size-12 rounded-2xl bg-green-500/10 text-green-600 dark:text-green-300">
                                    @svg('phosphor-wrench', 'size-6')
                                </span>
                            @endif

                            <div class="space-y-1">
                                <span class="text-xs font-semibold uppercase tracking-wide text-neutral-500 dark:text-white/50">Request #{{ $quotationRequest->number ?? substr($quotationRequest->id, -8) }}</span>
                                <h3 class="text-xl md:text-2xl font-extrabold text-neutral-900 dark:text-white">
                                    {{ ucfirst(str_replace('-', ' ', $quotationRequest->type->value)) }} Request
                                </h3>
                            </div>
                        </div>

                        <span class="inline-flex items-center px-2.5 py-1.5 rounded-full text-xs font-semibold {{ $statusClass }}">
                            {{ ucfirst($quotationRequest->status->value) }}
                        </span>
                    </div>

                    <div class="mt-6 space-y-3 text-sm text-neutral-600 dark:text-white/70">
                        <div class="flex items-center gap-2">
                            @svg('phosphor-car', 'size-4 text-sky-500')
                            <span>
                                {{ $quotationRequest->inspection->appointment->vehicle->year }}
                                {{ $quotationRequest->inspection->appointment->vehicle->make }}
                                {{ $quotationRequest->inspection->appointment->vehicle->model }}
                            </span>
                        </div>
                        <div class="flex items-center gap-2">
                            @svg('phosphor-qr-code', 'size-4 text-neutral-500')
                            <span class="font-mono text-xs md:text-sm">
                                {{ $quotationRequest->inspection->appointment->vehicle->vin }}
                            </span>
                        </div>
                        <div class="flex items-center gap-2">
                            @svg('phosphor-calendar-dots', 'size-4 text-violet-500')
                            <span>Requested {{ $quotationRequest->created_at->format('M d, Y \\a\\t H:i') }}</span>
                        </div>
                    </div>

                    <div class="mt-6 rounded-2xl bg-neutral-50 dark:bg-white/5 px-4 py-3">
                        <div class="flex items-center justify-between text-sm text-neutral-700 dark:text-white">
                            <span class="font-semibold">Quotations</span>
                            <span>{{ $quotationRequest->quotations->count() }}</span>
                        </div>

                        @if($quotationRequest->quotations->count() > 0)
                            <div class="mt-3 grid grid-cols-2 gap-3 text-xs uppercase tracking-wide text-neutral-500 dark:text-white/50">
                                <div>
                                    <span>Lowest</span>
                                    <div class="mt-1 text-sm font-semibold text-green-600 dark:text-green-300">
                                        SAR {{ number_format($quotationRequest->quotations->min('total'), 2) }}
                                    </div>
                                </div>
                                <div>
                                    <span>Highest</span>
                                    <div class="mt-1 text-sm font-semibold text-red-600 dark:text-red-300">
                                        SAR {{ number_format($quotationRequest->quotations->max('total'), 2) }}
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="mt-3 text-xs uppercase tracking-wide text-neutral-500 dark:text-white/50">
                                Awaiting first quote
                            </div>
                        @endif
                    </div>

                    <div class="mt-6">
                        <button
                            type="button"
                            wire:click="viewQuotationRequest('{{ $quotationRequest->id }}')"
                            class="w-full inline-flex items-center justify-between gap-6 px-6 py-3 border border-neutral-300 dark:border-white/20 text-neutral-800 dark:text-white text-base font-medium font-montserrat rounded-full hover:bg-neutral-50 dark:hover:bg-white/10 transition-colors focus:outline-none focus:ring-2 focus:ring-violet-500">
                            <span class="flex items-center gap-2">
                                @svg('phosphor-file-text', 'size-5 text-indigo-600')
                                View Details
                            </span>
                            @svg('phosphor-arrow-right-light', 'size-6')
                        </button>
                    </div>
                </div>
            @empty
                <div class="flex text-base text-neutral-500 dark:text-white/20">
                    <span>{{ __('_________ No quotation requests yet') }}</span>
                </div>
            @endforelse
        </div>

        @if($quotationRequests->hasPages())
            <div class="pt-2">
                {{ $quotationRequests->links() }}
            </div>
        @endif
    </div>
</div>
