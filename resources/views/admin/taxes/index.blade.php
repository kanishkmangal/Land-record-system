@extends('layouts.app')

@section('content')
<main class="max-w-container-max mx-auto p-4 md:p-6 space-y-6 mb-24">
    <!-- Header & Action -->
    <section class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 border-b border-outline-variant pb-4">
        <div>
            <h2 class="font-h2 text-h2 text-primary">Tax & Bills Management</h2>
            <p class="font-body-sm text-on-surface-variant">View pending taxes and generate new bills for the financial year.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.taxes.export') }}" class="flex items-center gap-2 border border-outline-variant bg-white text-on-surface-variant px-4 py-2.5 rounded-lg font-label-md hover:bg-surface-container-low transition-all">
                <span class="material-symbols-outlined text-[18px]" data-icon="download">download</span>
                Export CSV
            </a>
            <a href="{{ route('admin.taxes.generate') }}" class="flex items-center gap-2 bg-primary text-white px-5 py-2.5 rounded-lg font-label-md hover:opacity-90 active:scale-95 transition-all">
                <span class="material-symbols-outlined text-[20px]" data-icon="post_add">post_add</span>
                Generate Tax Bills
            </a>
        </div>
    </section>

    <!-- Success Messages -->
    @if(session('success'))
        <div class="bg-secondary-container text-on-secondary-container p-4 rounded-lg font-body-sm flex items-center gap-2">
            <span class="material-symbols-outlined text-sm">check_circle</span>
            {{ session('success') }}
        </div>
    @endif

    <!-- Search -->
    <section class="flex flex-col gap-3 md:flex-row md:items-center">
        <form action="{{ route('admin.taxes.index') }}" method="GET" class="relative flex-grow flex items-center gap-2">
            <div class="relative flex-grow">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline" data-icon="search">search</span>
                <input name="search" value="{{ request('search') }}" class="w-full pl-10 pr-4 py-2 bg-white border border-outline-variant rounded-lg text-body-md focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all" placeholder="Search by Property Record ID or Financial Year" type="text"/>
            </div>
            <button type="submit" class="bg-surface-container-high border border-outline-variant text-on-surface px-4 py-2 rounded-lg font-label-md hover:bg-surface-container-highest transition-colors">
                Search
            </button>
            @if(request()->has('search'))
                <a href="{{ route('admin.taxes.index') }}" class="text-error hover:underline font-label-sm px-2">Clear</a>
            @endif
        </form>
    </section>

    <!-- Taxes Table -->
    <section class="bg-white border border-outline-variant rounded-lg overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-[800px]">
                <thead>
                    <tr class="bg-surface-container text-on-surface-variant font-label-md border-b border-outline-variant">
                        <th class="p-4">Property Record</th>
                        <th class="p-4">Financial Year</th>
                        <th class="p-4">Total Amount</th>
                        <th class="p-4">Due Date</th>
                        <th class="p-4">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/50">
                    @forelse($taxes as $tax)
                        <tr class="hover:bg-surface-container-low transition-colors">
                            <td class="p-4 font-body-md text-primary font-bold">
                                <a href="{{ route('admin.land-records.edit', $tax->land_record_id) }}" class="hover:underline">
                                    {{ $tax->landRecord->record_number ?? 'Unknown' }}
                                </a>
                            </td>
                            <td class="p-4 font-body-sm">{{ $tax->financial_year }}</td>
                            <td class="p-4 font-body-sm">${{ number_format($tax->total_amount, 2) }}</td>
                            <td class="p-4 font-body-sm">
                                {{ \Carbon\Carbon::parse($tax->due_date)->format('M d, Y') }}
                                @if(\Carbon\Carbon::parse($tax->due_date)->isPast() && $tax->status == 'pending')
                                    <span class="text-error text-[10px] ml-1 font-bold">(Overdue)</span>
                                @endif
                            </td>
                            <td class="p-4">
                                @if($tax->status == 'paid')
                                    <span class="bg-secondary-container text-on-secondary-container text-[10px] px-2 py-1 rounded-full font-bold uppercase">Paid</span>
                                @else
                                    <span class="bg-error-container text-on-error-container text-[10px] px-2 py-1 rounded-full font-bold uppercase">Pending</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center font-body-sm italic text-on-surface-variant">No tax records found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
    
    @if($taxes->hasPages())
        <div class="mt-lg flex justify-center">
            {{ $taxes->links() }}
        </div>
    @endif
</main>
@endsection
