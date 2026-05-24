@extends('layouts.app')

@section('content')
<main class="max-w-md mx-auto px-4 pt-6 pb-12 mb-24">
    <!-- Header info showing due amount -->
    <section class="mb-gutter">
        <div class="bg-primary-container p-6 rounded-xl shadow-sm text-white flex flex-col gap-2 relative overflow-hidden">
            <div class="absolute -right-4 -top-4 opacity-10">
                <span class="material-symbols-outlined text-[120px]" data-icon="account_balance">account_balance</span>
            </div>
            <div class="flex flex-col">
                <span class="font-label-sm uppercase tracking-widest opacity-80">Property ID: {{ $tax->landRecord->record_number }}</span>
                <h1 class="font-h1 text-white mt-1">Total Due: ${{ number_format($tax->total_amount, 2) }}</h1>
            </div>
            <div class="mt-4 flex items-center gap-2 text-primary-fixed text-sm">
                <span class="material-symbols-outlined text-sm" data-icon="event">event</span>
                <span>Due Date: {{ \Carbon\Carbon::parse($tax->due_date)->format('M d, Y') }}</span>
            </div>
        </div>
    </section>

    <!-- Payment Form -->
    <section class="mb-gutter">
        <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-6 shadow-sm">
            <div class="flex items-center gap-2 mb-6">
                <span class="material-symbols-outlined text-primary-container" data-icon="credit_card">credit_card</span>
                <h2 class="font-h3 text-on-surface">Payment Details</h2>
            </div>

            <!-- Error Messages -->
            @if(session('error'))
                <div class="bg-error-container text-on-error-container p-3 rounded mb-4 font-body-sm flex items-center gap-2">
                    <span class="material-symbols-outlined text-sm">warning</span>
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('citizen.tax.process', $tax->id) }}" class="flex flex-col gap-4">
                @csrf
                <div>
                    <label class="block font-label-md text-on-surface-variant mb-1 ml-1">Cardholder Name</label>
                    <input name="card_name" required class="w-full h-11 px-4 rounded-lg border border-outline-variant focus:border-2 focus:border-primary-container outline-none transition-all font-body-md" placeholder="Johnathan Doe" type="text" value="{{ auth()->user()->name }}"/>
                </div>
                <div>
                    <label class="block font-label-md text-on-surface-variant mb-1 ml-1">Card Number (Dummy)</label>
                    <div class="relative">
                        <input name="card_number" required class="w-full h-11 px-4 pr-12 rounded-lg border border-outline-variant focus:border-2 focus:border-primary-container outline-none transition-all font-body-md" placeholder="0000 0000 0000 0000" type="text"/>
                        <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-outline" data-icon="lock">lock</span>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block font-label-md text-on-surface-variant mb-1 ml-1">Expiry</label>
                        <input name="expiry" required class="w-full h-11 px-4 rounded-lg border border-outline-variant focus:border-2 focus:border-primary-container outline-none transition-all font-body-md text-center" placeholder="MM/YY" type="text"/>
                    </div>
                    <div>
                        <label class="block font-label-md text-on-surface-variant mb-1 ml-1">CVV</label>
                        <input name="cvv" required class="w-full h-11 px-4 rounded-lg border border-outline-variant focus:border-2 focus:border-primary-container outline-none transition-all font-body-md text-center" placeholder="***" type="password"/>
                    </div>
                </div>
                <div class="mt-4 flex flex-col gap-3">
                    <button class="w-full h-[44px] bg-primary-container text-white font-label-md rounded-lg flex items-center justify-center gap-2 hover:opacity-90 active:scale-95 transition-all" type="submit">
                        <span class="material-symbols-outlined text-lg" data-icon="verified_user">verified_user</span>
                        Pay ${{ number_format($tax->total_amount, 2) }} Now
                    </button>
                    <p class="text-[10px] text-center text-outline uppercase tracking-tight">Encrypted 256-bit Secure Transaction</p>
                </div>
            </form>
        </div>
    </section>

    <!-- Payment History -->
    <section>
        <div class="flex items-center justify-between mb-4 px-1">
            <h3 class="font-h3 text-on-surface">Payment History</h3>
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
                        </div>
                    </div>
                    <div class="text-right flex flex-col items-end gap-1">
                        <p class="font-h3 {{ $payment->status == 'success' ? 'text-secondary' : 'text-error' }} text-[18px]">${{ number_format($payment->amount_paid, 2) }}</p>
                        <p class="text-[10px] uppercase font-bold {{ $payment->status == 'success' ? 'text-secondary' : 'text-error' }} tracking-widest">{{ $payment->status }}</p>
                        
                        @if($payment->status == 'success')
                            <!-- Download PDF Receipt Link -->
                            <a href="{{ route('citizen.tax.receipt', $payment->id) }}" class="mt-1 text-[10px] text-primary-container font-bold hover:underline flex items-center gap-1">
                                <span class="material-symbols-outlined text-[12px]">download</span> Receipt
                            </a>
                        @endif
                    </div>
                </div>
            @empty
                <div class="text-center p-4">
                    <p class="text-on-surface-variant font-body-sm">No payment history found for this property.</p>
                </div>
            @endforelse
        </div>
    </section>
</main>
@endsection
