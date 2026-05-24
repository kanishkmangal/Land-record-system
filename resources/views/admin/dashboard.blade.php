@extends('layouts.app')

@section('content')
<main class="max-w-container-max mx-auto p-4 md:p-6 space-y-6">
    <!-- Metrics Row -->
    <section class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white border border-outline-variant p-4 rounded-lg flex items-center gap-4 transition-all shadow-sm">
            <div class="bg-primary-fixed w-12 h-12 flex items-center justify-center rounded-full text-primary">
                <span class="material-symbols-outlined" data-icon="group">group</span>
            </div>
            <div>
                <p class="font-label-sm text-on-surface-variant uppercase tracking-wider">Total Citizens</p>
                <p class="font-h3 text-primary">{{ $total_users ?? 0 }}</p>
            </div>
        </div>
        <div class="bg-white border border-outline-variant p-4 rounded-lg flex items-center gap-4 shadow-sm">
            <div class="bg-secondary-container w-12 h-12 flex items-center justify-center rounded-full text-on-secondary-container">
                <span class="material-symbols-outlined" data-icon="payments">payments</span>
            </div>
            <div>
                <p class="font-label-sm text-on-surface-variant uppercase tracking-wider">Tax Collected</p>
                <p class="font-h3 text-primary">${{ number_format($total_tax_collected ?? 0, 2) }}</p>
            </div>
        </div>
        <div class="bg-white border border-outline-variant p-4 rounded-lg flex items-center gap-4 shadow-sm">
            <div class="bg-error-container w-12 h-12 flex items-center justify-center rounded-full text-on-error-container">
                <span class="material-symbols-outlined" data-icon="pending_actions">pending_actions</span>
            </div>
            <div>
                <p class="font-label-sm text-on-surface-variant uppercase tracking-wider">Pending Taxes</p>
                <p class="font-h3 text-primary">{{ $pending_taxes_count ?? 0 }}</p>
            </div>
        </div>
    </section>

    <!-- Main Bento Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <!-- Revenue Trends Chart -->
        <div class="lg:col-span-8 bg-white border border-outline-variant rounded-lg p-6 flex flex-col gap-4 shadow-sm">
            <div class="flex justify-between items-center">
                <h2 class="font-h3 text-on-surface">Revenue Trends</h2>
                <span class="text-label-sm text-on-surface-variant bg-surface-container px-2 py-1 rounded">Last 6 Months</span>
            </div>
            <div class="flex-grow min-h-[240px] relative mt-4">
                <svg class="w-full h-full" viewbox="0 0 800 200">
                    <path d="M0,180 Q100,160 200,140 T400,100 T600,60 T800,20" fill="none" stroke="#002D62" stroke-linecap="round" stroke-width="3"></path>
                    <path d="M0,180 Q100,160 200,140 T400,100 T600,60 T800,20 L800,200 L0,200 Z" fill="url(#grad1)" opacity="0.1"></path>
                    <defs>
                        <lineargradient id="grad1" x1="0%" x2="0%" y1="0%" y2="100%">
                            <stop offset="0%" style="stop-color:#002D62;stop-opacity:1"></stop>
                            <stop offset="100%" style="stop-color:#002D62;stop-opacity:0"></stop>
                        </lineargradient>
                    </defs>
                    <line stroke="#E5E7EB" stroke-dasharray="4" stroke-width="1" x1="0" x2="800" y1="50" y2="50"></line>
                    <line stroke="#E5E7EB" stroke-dasharray="4" stroke-width="1" x1="0" x2="800" y1="100" y2="100"></line>
                    <line stroke="#E5E7EB" stroke-dasharray="4" stroke-width="1" x1="0" x2="800" y1="150" y2="150"></line>
                </svg>
                <div class="flex justify-between mt-4 text-label-sm text-on-surface-variant">
                    <span>Jan</span><span>Feb</span><span>Mar</span><span>Apr</span><span>May</span><span>Jun</span>
                </div>
            </div>
        </div>

        <!-- Task List -->
        <div class="lg:col-span-4 bg-white border border-outline-variant rounded-lg p-6 flex flex-col gap-4 shadow-sm">
            <h2 class="font-h3 text-on-surface border-b border-outline-variant pb-3">Tasks</h2>
            <div class="space-y-4">
                <div class="flex items-center justify-between p-3 bg-surface-container-low border border-outline-variant/30 rounded-lg">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-primary" data-icon="verified_user">verified_user</span>
                        <div>
                            <p class="font-label-md">Verify New Records</p>
                            <p class="text-[10px] text-on-surface-variant uppercase">Pending Actions</p>
                        </div>
                    </div>
                    <button class="bg-primary text-white text-[12px] px-3 py-1 rounded-sm font-semibold">START</button>
                </div>
                <div class="flex items-center justify-between p-3 border border-outline-variant/30 rounded-lg">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-on-surface-variant" data-icon="manage_accounts">manage_accounts</span>
                        <div>
                            <p class="font-label-md">User Role Review</p>
                            <p class="text-[10px] text-on-surface-variant uppercase">Priority High</p>
                        </div>
                    </div>
                    <span class="material-symbols-outlined text-outline cursor-pointer" data-icon="more_vert">more_vert</span>
                </div>
            </div>
            <button class="mt-auto w-full border border-primary text-primary py-2 rounded-sm font-label-md hover:bg-primary-fixed transition-colors">VIEW ALL TASKS</button>
        </div>
    </div>

    <!-- Recent Activity Table Section -->
    <section class="bg-white border border-outline-variant rounded-lg overflow-hidden shadow-sm">
        <div class="bg-primary-container p-4">
            <h3 class="font-h3 text-white">Recent Transactions</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-surface-container text-on-surface-variant font-label-md border-b border-outline-variant">
                        <th class="p-4">Entity ID</th>
                        <th class="p-4">Owner/Citizen</th>
                        <th class="p-4">Status</th>
                        <th class="p-4">Amount</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/50">
                    @forelse($recent_payments ?? [] as $payment)
                        <tr class="hover:bg-surface-container-low transition-colors">
                            <td class="p-4 font-body-sm">#{{ $payment->receipt_number }}</td>
                            <td class="p-4 font-body-sm">{{ $payment->citizen->name }}</td>
                            <td class="p-4">
                                <span class="bg-secondary-container text-on-secondary-container text-[10px] px-2 py-1 rounded-full font-bold uppercase">{{ $payment->status }}</span>
                            </td>
                            <td class="p-4 font-body-sm">${{ number_format($payment->amount_paid, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-8 text-center font-body-sm italic text-on-surface-variant">No recent transactions found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</main>
@endsection
