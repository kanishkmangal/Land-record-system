@extends('layouts.app')

@section('content')
<main class="max-w-md mx-auto px-4 pt-6 pb-12 mb-24">
    <section>
        <div class="flex items-center justify-between mb-4 px-1 border-b border-outline-variant pb-2">
            <h2 class="font-h2 text-on-surface">My Payments</h2>
        </div>
        
        <div class="flex flex-col gap-3">
            @forelse($payments as $payment)
                <div class="bg-white border border-outline-variant rounded-lg p-4 flex items-center justify-between {{ $payment->status == 'failed' ? 'opacity-70' : '' }}">
                    <div class="flex items-center gap-3">
                        <div class="{{ $payment->status == 'success' ? 'bg-secondary-container text-on-secondary-container' : 'bg-error-container text-on-error-container' }} w-10 h-10 rounded-full flex items-center justify-center">
                            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">{{ $payment->status == 'success' ? 'check_circle' : 'cancel' }}</span>
                        </div>
                        <div>
                            <p class="font-label-md text-on-surface">{{ $payment->payment_date->format('M d, Y') }}</p>
                            <p class="text-body-sm text-outline">Receipt #{{ $payment->receipt_number }}</p>
                            @if($payment->propertyTax && $payment->propertyTax->landRecord)
                                <p class="text-[10px] text-primary-container mt-0.5">Property: {{ $payment->propertyTax->landRecord->record_number }}</p>
                            @endif
                        </div>
                    </div>
                    <div class="text-right flex flex-col items-end gap-1">
                        <p class="font-h3 {{ $payment->status == 'success' ? 'text-secondary' : 'text-error' }} text-[18px]">${{ number_format($payment->amount_paid, 2) }}</p>
                        <p class="text-[10px] uppercase font-bold {{ $payment->status == 'success' ? 'text-secondary' : 'text-error' }} tracking-widest">{{ $payment->status }}</p>
                        
                        @if($payment->status == 'success')
                            <a href="{{ route('citizen.tax.receipt', $payment->id) }}" class="mt-1 text-[10px] text-primary-container font-bold hover:underline flex items-center gap-1 bg-surface-container-low px-2 py-1 rounded">
                                <span class="material-symbols-outlined text-[12px]">download</span> Receipt
                            </a>
                        @endif
                    </div>
                </div>
            @empty
                <div class="text-center p-8 bg-surface-container-lowest border border-outline-variant rounded-xl border-dashed">
                    <span class="material-symbols-outlined text-outline text-5xl mb-4">receipt_long</span>
                    <p class="text-on-surface-variant font-body-sm">No payment history found.</p>
                </div>
            @endforelse
        </div>
    </section>
</main>
@endsection
