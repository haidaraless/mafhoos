<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg border border-gray-200 p-6">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Spare Parts Supplier</h1>
                <p class="text-gray-600">Manage quotation requests for spare parts</p>
            </div>
        </div>
    </div>

    <!-- Quotation Requests Section -->
    @if($quotationRequests->count() > 0)
        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
            <div class="flex items-center justify-between p-6">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Spare Parts Quotation Requests</h3>
                        <p class="text-sm text-gray-600">Manage spare parts quotation requests</p>
                    </div>
                </div>
                <span class="bg-purple-100 text-purple-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                    {{ $quotationRequests->count() }} requests
                </span>
            </div>

            <div class="space-y-3">
                @foreach($quotationRequests as $request)
                    <div class="border-t border-gray-200 p-4 hover:bg-gray-50 transition-colors duration-200">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center space-x-3 mb-3">
                                    <h4 class="font-medium text-gray-900">Spare Parts Request #{{ substr($request->id, -8) }}</h4>
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        {{ ucfirst($request->status->value) }}
                                    </span>
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-3">
                                    <div class="space-y-2">
                                        <div class="flex items-center text-sm text-gray-600">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <span>{{ $request->created_at->diffForHumans() }}</span>
                                        </div>
                                        <div class="flex items-center text-sm text-gray-600">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            <span>{{ $request->inspection->appointment->vehicle->year }} {{ $request->inspection->appointment->vehicle->make }} {{ $request->inspection->appointment->vehicle->model }}</span>
                                        </div>
                                    </div>
                                    <div class="space-y-2">
                                        <div class="flex items-center text-sm text-gray-600">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                            <span>{{ $request->inspection->appointment->vehicle->user->name }}</span>
                                        </div>
                                        <div class="flex items-center text-sm text-gray-600">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            <span>Inspection #{{ $request->inspection->number }}</span>
                                        </div>
                                    </div>
                                </div>

                                @if($request->inspection->damageSpareparts->count() > 0)
                                    <div class="mb-3">
                                        <h5 class="text-sm font-medium text-gray-700 mb-2">Required Parts ({{ $request->inspection->damageSpareparts->count() }}):</h5>
                                        <div class="flex flex-wrap gap-1">
                                            @foreach($request->inspection->damageSpareparts->take(3) as $damageSparepart)
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    {{ $damageSparepart->sparepart->name }}
                                                </span>
                                            @endforeach
                                            @if($request->inspection->damageSpareparts->count() > 3)
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                    +{{ $request->inspection->damageSpareparts->count() - 3 }} more
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                @endif

                                @if($request->quotations->count() > 0)
                                    <div class="flex items-center space-x-4 text-sm">
                                        <div class="flex items-center text-green-600">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <span class="font-medium">Quote Provided: SAR {{ number_format($request->quotations->first()->total, 2) }}</span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="flex items-center space-x-2 ml-4">
                                <a href="{{ route('quotation-requests.view', $request->id) }}" 
                                   class="px-4 py-2 bg-purple-600 text-white text-sm font-medium rounded-lg hover:bg-purple-700 transition-colors duration-200">
                                    View Details
                                </a>
                                @if($request->quotations->count() === 0)
                                    <a href="{{ route('quotation-requests.provide-quote', $request->id) }}"
                                       class="px-4 py-2 bg-green-100 text-green-700 text-sm font-medium rounded-lg hover:bg-green-200 transition-colors duration-200">
                                        Provide Quote
                                    </a>
                                @else
                                    <span class="px-4 py-2 bg-blue-100 text-blue-700 text-sm font-medium rounded-lg">
                                        Quote Provided
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <!-- Empty State -->
        <div class="bg-white rounded-lg border border-gray-200 p-12 text-center">
            <svg class="w-16 h-16 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mt-4">No Quotation Requests</h3>
            <p class="text-gray-600 mt-2">You don't have any spare parts quotation requests yet.</p>
        </div>
    @endif

    <!-- Quotation Modal removed in favor of page-based quoting -->
</div>
