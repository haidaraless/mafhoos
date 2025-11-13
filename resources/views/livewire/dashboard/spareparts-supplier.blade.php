<div class="grid grid-cols-4 content-start">
    <div class="col-span-1 grid grid-cols-1 border-r border-neutral-900 dark:border-neutral-700">
        <!-- Statistics Section -->
        <div class="grid grid-cols-1 gap-8 content-start p-8">
            <!-- Total Requests -->
            <div class="flex flex-col gap-2">
                <div class="flex items-center justify-between gap-2">
                    <span class="text-2xl">{{ __('Total Requests') }}</span>
                    @svg('phosphor-package', 'size-8 text-purple-500')
                </div>
                <span class="text-3xl font-extrabold text-neutral-800 dark:text-white">
                    {{ $quotationRequests->count() }}
                </span>
            </div>
            
            <!-- Status Statistics -->
            <div class="grid grid-cols-1 gap-4">
                <div class="flex items-center justify-between gap-2">
                    <span class="text-2xl">{{ __('Status') }}</span>
                    @svg('phosphor-chart-pie', 'size-8 text-blue-500')
                </div>  
                <div class="space-y-3">
                    @php
                        $statusCounts = [
                            'open' => $quotationRequests->where('status.value', 'open')->count(),
                            'pending' => $quotationRequests->where('status.value', 'pending')->count(),
                            'quoted' => $quotationRequests->where('status.value', 'quoted')->count(),
                        ];
                        $total = array_sum($statusCounts);
                    @endphp
                    @foreach(['open' => 'blue', 'pending' => 'yellow', 'quoted' => 'green'] as $status => $color)
                        @php
                            $count = $statusCounts[$status] ?? 0;
                            $percentage = $total > 0 ? ($count / $total) * 100 : 0;
                        @endphp
                        <div class="flex flex-col gap-1">
                            <div class="flex items-center justify-between text-xs">
                                <span class="text-neutral-600 dark:text-white/70 capitalize">{{ $status }}</span>
                                <span class="font-semibold text-neutral-800 dark:text-white">{{ $count }}</span>
                            </div>
                            <div class="w-full h-2 bg-neutral-200 dark:bg-white/10 rounded-full overflow-hidden">
                                <div 
                                    class="h-full rounded-full transition-all duration-500 {{ 
                                        $color === 'yellow' ? 'bg-yellow-500' : 
                                        ($color === 'blue' ? 'bg-blue-500' : 'bg-green-500')
                                    }}"
                                    style="width: {{ $percentage }}%"
                                ></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            
            <!-- Quick Stats -->
            <div class="grid grid-cols-1 gap-4">
                <!-- With Quotes -->
                <div class="flex items-center justify-between p-4 border border-neutral-300 dark:border-white/10 rounded-xl bg-white dark:bg-white/5">
                    <div class="flex items-center gap-3">
                        <span class="inline-flex items-center justify-center size-10 rounded-xl bg-green-500/10 text-green-600 dark:text-green-300">
                            @svg('phosphor-check-circle', 'size-5')
                        </span>
                        <div class="flex flex-col">
                            <span class="text-xs text-neutral-600 dark:text-white/70">With Quotes</span>
                            <span class="text-xl font-extrabold text-neutral-800 dark:text-white">{{ $quotationRequests->filter(fn($r) => $r->quotations->count() > 0)->count() }}</span>
                        </div>
                    </div>
                </div>
    
                <!-- Pending Quotes -->
                <div class="flex items-center justify-between p-4 border border-neutral-300 dark:border-white/10 rounded-xl bg-white dark:bg-white/5">
                    <div class="flex items-center gap-3">
                        <span class="inline-flex items-center justify-center size-10 rounded-xl bg-yellow-500/10 text-yellow-600 dark:text-yellow-300">
                            @svg('phosphor-clock', 'size-5')
                        </span>
                        <div class="flex flex-col">
                            <span class="text-xs text-neutral-600 dark:text-white/70">Pending Quotes</span>
                            <span class="text-xl font-extrabold text-neutral-800 dark:text-white">{{ $quotationRequests->filter(fn($r) => $r->quotations->count() === 0)->count() }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-span-3 grid grid-cols-1 content-start">
        <div class="col-span-1 flex items-center justify-between gap-2 p-8">
            <div class="flex items-center gap-1 text-neutral-500 dark:text-white/70">
                <span class="text-2xl text-neutral-900 dark:text-white font-medium">{{ now()->format('l, F j, Y') }}</span>
                @svg('phosphor-line-vertical', 'size-6')
                <span class="text-base font-normal">{{ __('Quotation Requests') }}</span>
            </div>
            @svg('phosphor-package', 'size-8 text-purple-500')
        </div>
        
        @if($quotationRequests->count() > 0)
            @foreach($quotationRequests as $request)
                <div class="col-span-1 flex items-center px-4 lg:px-8 min-h-16 border-b border-neutral-200 dark:border-neutral-700 last:border-b-0">
                    <div class="flex-1 grid grid-cols-1 gap-4 content-start">
                        <div class="grid grid-cols-5 gap-1 pl-4 items-center overflow-hidden bg-white dark:bg-white/5">
                            <div class="col-span-2 flex flex-col">
                                <span class="text-xl font-semibold text-neutral-800 dark:text-white">
                                    {{ $request->inspection->appointment->vehicle->year }} {{ $request->inspection->appointment->vehicle->make }} {{ $request->inspection->appointment->vehicle->model }}
                                </span>
                                <span class="text-sm text-neutral-500 dark:text-white/60 font-mono">
                                    Request #{{ substr($request->id, -8) }}
                                </span>
                            </div>

                            <div class="col-span-2 flex flex-col">
                                @if($request->inspection->appointment->vehicle->user)
                                    <span class="text-xl font-semibold text-neutral-800 dark:text-white">{{ $request->inspection->appointment->vehicle->user->name }}</span>
                                @endif
                                <span class="text-sm text-neutral-600 dark:text-white/70">Inspection #{{ $request->inspection->number }}</span>
                                @if($request->quotations->count() > 0)
                                    <span class="text-sm text-green-600 dark:text-green-300 font-semibold">SAR {{ number_format($request->quotations->first()->total, 2) }}</span>
                                @endif
                            </div>

                            <div class="flex justify-end gap-2">
                                <a href="{{ route('quotation-requests.view', $request->id) }}" 
                                   class="inline-flex items-center justify-between gap-3 px-4 py-3 bg-neutral-800 text-white text-base font-medium font-montserrat rounded-full hover:bg-neutral-900 transition-colors duration-200 cursor-pointer"
                                >
                                    <span>View</span>
                                    @svg('phosphor-arrow-right-light', 'size-5')
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="flex text-base text-neutral-500 dark:text-white/20">
                <span>{{ __('_________ No quotation requests yet') }}</span>
            </div>
        @endif
    </div>
</div>
