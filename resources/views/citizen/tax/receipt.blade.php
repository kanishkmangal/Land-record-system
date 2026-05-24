@extends('layouts.app')

@section('content')
<main class="max-w-md mx-auto px-4 pt-6 pb-12 mb-24">
    <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-6 shadow-sm text-center">
        <div class="w-16 h-16 bg-secondary-container text-on-secondary-container rounded-full flex items-center justify-center mx-auto mb-4">
            <span class="material-symbols-outlined text-3xl" data-icon="check_circle">check_circle</span>
        </div>
        
        <h2 class="font-h2 text-on-surface mb-2">Payment Successful!</h2>
        <p class="font-body-md text-on-surface-variant mb-6">Your property tax has been paid successfully.</p>

        <div class="bg-surface p-4 rounded-lg text-left mb-6">
            <div class="flex justify-between border-b border-outline-variant/30 pb-2 mb-2">
                <span class="font-label-sm text-on-surface-variant">Receipt No:</span>
                <span class="font-body-sm font-semibold">{{ $payment->receipt_number }}</span>
            </div>
            <div class="flex justify-between border-b border-outline-variant/30 pb-2 mb-2">
                <span class="font-label-sm text-on-surface-variant">Transaction ID:</span>
                <span class="font-body-sm font-semibold">{{ $payment->transaction_id }}</span>
            </div>
            <div class="flex justify-between border-b border-outline-variant/30 pb-2 mb-2">
                <span class="font-label-sm text-on-surface-variant">Date:</span>
                <span class="font-body-sm font-semibold">{{ $payment->payment_date->format('M d, Y h:i A') }}</span>
            </div>
            <div class="flex justify-between">
                <span class="font-label-sm text-on-surface-variant">Amount Paid:</span>
                <span class="font-body-sm font-semibold text-secondary">${{ number_format($payment->amount_paid, 2) }}</span>
            </div>
        </div>

        <div class="flex flex-col gap-3">
            <button onclick="window.print()" class="w-full h-[44px] bg-primary-container text-white font-label-md rounded-lg flex items-center justify-center gap-2 hover:opacity-90 active:scale-95 transition-all">
                <span class="material-symbols-outlined text-lg" data-icon="print">print</span>
                Print Receipt
            </button>
            <a href="{{ route('citizen.dashboard') }}" class="w-full h-[44px] border border-primary-container text-primary-container font-label-md rounded-lg flex items-center justify-center gap-2 hover:bg-surface-container transition-all">
                Return to Dashboard
            </a>
        </div>
    </div>
</main>
@endsection
