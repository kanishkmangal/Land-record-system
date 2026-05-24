@extends('layouts.app')

@section('content')
<main class="max-w-md mx-auto px-4 pt-md space-y-md mb-24">
    <!-- Quick Status Indicator -->
    <div class="flex items-center justify-between py-xs px-sm {{ $record->status == 'active' ? 'bg-secondary-container/30 border-secondary-container' : 'bg-error-container/30 border-error-container' }} border rounded-lg">
        <div class="flex items-center gap-2">
            <span class="material-symbols-outlined {{ $record->status == 'active' ? 'text-secondary' : 'text-error' }}" style="font-variation-settings: 'FILL' 1;">{{ $record->status == 'active' ? 'verified_user' : 'warning' }}</span>
            <span class="font-label-md {{ $record->status == 'active' ? 'text-on-secondary-container' : 'text-on-error-container' }}">{{ ucfirst($record->status) }} Record</span>
        </div>
        <span class="font-label-sm text-on-surface-variant">Last updated: {{ $record->updated_at->format('M d, Y') }}</span>
    </div>

    <!-- Section: Owner Details -->
    <section class="space-y-sm">
        <div class="flex items-center gap-2 pb-xs border-b border-outline-variant">
            <span class="material-symbols-outlined text-primary-container" data-icon="person">person</span>
            <h2 class="font-h3 text-primary-container uppercase tracking-tight text-sm">Owner Details</h2>
        </div>
        <div class="grid grid-cols-1 gap-y-4 pt-base">
            <div>
                <p class="font-label-sm text-on-surface-variant uppercase tracking-widest text-[10px]">Primary Owner Name</p>
                <p class="font-body-lg font-semibold text-primary">{{ $record->owner->name }}</p>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="font-label-sm text-on-surface-variant uppercase tracking-widest text-[10px]">Record ID</p>
                    <p class="font-body-md font-medium">{{ $record->record_number }}</p>
                </div>
                <div>
                    <p class="font-label-sm text-on-surface-variant uppercase tracking-widest text-[10px]">Registry Status</p>
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-secondary-fixed text-on-secondary-fixed-variant text-[10px] font-bold">{{ strtoupper($record->status) }}</span>
                </div>
            </div>
            <div>
                <p class="font-label-sm text-on-surface-variant uppercase tracking-widest text-[10px]">Property Address</p>
                <p class="font-body-md leading-relaxed">{{ $record->location }}, {{ $record->district }}, {{ $record->state }}</p>
            </div>
        </div>
    </section>

    <!-- Section: Property Info -->
    <section class="space-y-sm pt-4">
        <div class="flex items-center gap-2 pb-xs border-b border-outline-variant">
            <span class="material-symbols-outlined text-primary-container" data-icon="location_on">location_on</span>
            <h2 class="font-h3 text-primary-container uppercase tracking-tight text-sm">Property Info</h2>
        </div>
        <div class="grid grid-cols-2 gap-4 pt-base">
            <div class="bg-surface-container-lowest p-4 border border-outline-variant rounded-lg col-span-2">
                <p class="font-label-sm text-on-surface-variant uppercase tracking-widest text-[10px] mb-1">Land Area</p>
                <div class="flex items-baseline gap-2">
                    <span class="text-h2 text-primary">{{ number_format($record->area_sqft) }}</span>
                    <span class="font-body-sm text-on-surface-variant">Square Feet</span>
                </div>
            </div>
            <div class="bg-surface-container-lowest p-4 border border-outline-variant rounded-lg">
                <p class="font-label-sm text-on-surface-variant uppercase tracking-widest text-[10px] mb-1">Land Type</p>
                <p class="font-body-md font-semibold text-primary">{{ ucfirst($record->land_type) }}</p>
            </div>
            <div class="bg-surface-container-lowest p-4 border border-outline-variant rounded-lg">
                <p class="font-label-sm text-on-surface-variant uppercase tracking-widest text-[10px] mb-1">Survey / Plot No.</p>
                <p class="font-body-md font-semibold text-primary">{{ $record->survey_number }} / {{ $record->plot_number }}</p>
            </div>
        </div>
    </section>

    <!-- Section: Tax Summary -->
    @php
        $latestTax = $record->propertyTaxes()->latest()->first();
    @endphp
    <section class="space-y-sm pt-4">
        <div class="flex items-center gap-2 pb-xs border-b border-outline-variant">
            <span class="material-symbols-outlined text-primary-container" data-icon="payments">payments</span>
            <h2 class="font-h3 text-primary-container uppercase tracking-tight text-sm">Tax Summary</h2>
        </div>
        @if($latestTax)
            <div class="grid grid-cols-5 gap-3 pt-base">
                <div class="col-span-3 {{ $latestTax->status == 'pending' ? 'bg-primary-container' : 'bg-secondary' }} text-white p-4 rounded-lg flex flex-col justify-between">
                    <div>
                        <p class="font-label-sm text-white/70 uppercase tracking-widest text-[10px] mb-2">{{ $latestTax->status == 'pending' ? 'Current Due' : 'Balance' }}</p>
                        <p class="font-h2">${{ number_format($latestTax->total_amount, 2) }}</p>
                        <p class="text-[10px] mt-2 opacity-80">Financial Year: {{ $latestTax->financial_year }}</p>
                    </div>
                    @if($latestTax->status == 'pending')
                        <a href="{{ route('citizen.tax.payment', $latestTax->id) }}" class="mt-3 bg-white text-primary-container text-center font-label-sm py-1.5 rounded-lg hover:bg-surface-container transition-colors">
                            Pay Tax Now
                        </a>
                    @endif
                </div>
                <div class="col-span-2 bg-surface-container-high p-4 rounded-lg flex flex-col justify-between">
                    <div>
                        <p class="font-label-sm text-on-surface-variant uppercase tracking-widest text-[10px] mb-1">Status</p>
                        <p class="font-label-md text-primary">{{ strtoupper($latestTax->status) }}</p>
                    </div>
                    <p class="text-[10px] text-on-surface-variant">Due: {{ $latestTax->due_date }}</p>
                </div>
            </div>
        @else
            <div class="pt-base">
                <p class="font-body-sm text-on-surface-variant italic">No tax records found for this property.</p>
            </div>
        @endif
    </section>

    <!-- Bottom Actions -->
    <div class="pt-lg flex flex-col gap-3">
        @if($record->document_path)
            <a href="{{ asset('storage/' . $record->document_path) }}" target="_blank" class="w-full h-11 bg-primary-container text-white font-label-md flex items-center justify-center gap-2 rounded-lg hover:bg-primary transition-colors">
                <span class="material-symbols-outlined text-[20px]" data-icon="download">download</span>
                Download Digital Title Deed
            </a>
        @endif
        
        <a href="{{ route('citizen.land-records.transfer', $record->id) }}" class="w-full h-11 bg-secondary text-white font-label-md flex items-center justify-center gap-2 rounded-lg hover:bg-secondary/90 transition-colors">
            <span class="material-symbols-outlined text-[20px]" data-icon="swap_horiz">swap_horiz</span>
            Apply for Ownership Transfer
        </a>

        <button onclick="window.print()" class="w-full h-11 border border-primary-container text-primary-container font-label-md flex items-center justify-center gap-2 rounded-lg hover:bg-primary-container/5 transition-colors">
            <span class="material-symbols-outlined text-[20px]" data-icon="print">print</span>
            Print Record Statement
        </button>
    </div>
</main>
@endsection
