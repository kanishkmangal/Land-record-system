@extends('layouts.app')

@section('content')
<main class="pt-6 pb-24 px-4 max-w-container-max mx-auto space-y-6">
    <!-- Header -->
    <section class="border-b border-outline-variant pb-4">
        <h2 class="font-h2 text-h2 text-primary">Pending Approvals</h2>
        <p class="font-body-sm text-on-surface-variant">Review and process property ownership transfer requests.</p>
    </section>

    <!-- Success Messages -->
    @if(session('success'))
        <div class="bg-secondary-container text-on-secondary-container p-4 rounded-lg font-body-sm flex items-center gap-2">
            <span class="material-symbols-outlined text-sm">check_circle</span>
            {{ session('success') }}
        </div>
    @endif
    @if($errors->any())
        <div class="bg-error-container text-on-error-container p-4 rounded-lg font-body-sm flex items-center gap-2">
            <span class="material-symbols-outlined text-sm">error</span>
            {{ $errors->first() }}
        </div>
    @endif

    <!-- Search -->
    <section class="flex flex-col gap-3 md:flex-row md:items-center">
        <form action="{{ route('admin.transfers.index') }}" method="GET" class="relative flex-grow flex items-center gap-2">
            <div class="relative flex-grow">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline" data-icon="search">search</span>
                <input name="search" value="{{ request('search') }}" class="w-full pl-10 pr-4 py-2 bg-white border border-outline-variant rounded-lg text-body-md focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all" placeholder="Search by Property Record ID or New Owner Name" type="text"/>
            </div>
            <button type="submit" class="bg-surface-container-high border border-outline-variant text-on-surface px-4 py-2 rounded-lg font-label-md hover:bg-surface-container-highest transition-colors">
                Search
            </button>
            @if(request()->has('search'))
                <a href="{{ route('admin.transfers.index') }}" class="text-error hover:underline font-label-sm px-2">Clear</a>
            @endif
        </form>
    </section>

    <!-- Records Cards -->
    <section class="space-y-4">
        <!-- Table Header (Hidden on mobile) -->
        <div class="hidden md:grid grid-cols-6 bg-primary text-white rounded-t-xl p-4 font-label-md">
            <div>Property ID</div>
            <div>Current Owner</div>
            <div>New Owner (Buyer)</div>
            <div>Date Submitted</div>
            <div>Status</div>
            <div class="text-right">Actions</div>
        </div>

        @forelse($transfers as $transfer)
            <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-4 shadow-sm hover:shadow-md transition-shadow md:grid md:grid-cols-6 md:items-center md:rounded-none md:border-t-0 {{ $loop->first ? 'md:rounded-t-none' : '' }}">
                <div class="flex justify-between items-center mb-2 md:mb-0">
                    <span class="text-label-sm text-outline md:hidden">Property ID</span>
                    <a href="{{ route('admin.land-records.edit', $transfer->land_record_id) }}" class="font-label-md text-primary hover:underline">
                        #{{ $transfer->landRecord->record_number ?? 'UNKNOWN' }}
                    </a>
                </div>
                
                <div class="flex justify-between items-center mb-2 md:mb-0">
                    <span class="text-label-sm text-outline md:hidden">Current Owner</span>
                    <span class="text-body-sm">{{ $transfer->fromOwner->name ?? 'N/A' }}</span>
                </div>

                <div class="flex justify-between items-center mb-2 md:mb-0">
                    <span class="text-label-sm text-outline md:hidden">New Owner</span>
                    <span class="text-body-sm font-semibold">{{ $transfer->toOwner->name ?? 'N/A' }}</span>
                </div>
                
                <div class="flex justify-between items-center mb-2 md:mb-0">
                    <span class="text-label-sm text-outline md:hidden">Date</span>
                    <span class="text-body-sm">{{ $transfer->created_at->format('M d, Y') }}</span>
                </div>
                
                <div class="flex justify-between items-center mb-4 md:mb-0">
                    <span class="text-label-sm text-outline md:hidden">Status</span>
                    @if($transfer->status == 'pending')
                        <span class="px-2 py-0.5 bg-surface-container-highest text-on-surface-variant text-[10px] uppercase font-bold rounded-full">Pending Review</span>
                    @elseif($transfer->status == 'approved')
                        <span class="px-2 py-0.5 bg-secondary-container text-on-secondary-container text-[10px] uppercase font-bold rounded-full">Approved</span>
                    @else
                        <span class="px-2 py-0.5 bg-error-container text-on-error-container text-[10px] uppercase font-bold rounded-full">Rejected</span>
                    @endif
                </div>
                
                <div class="flex gap-2 justify-end items-center">
                    @if($transfer->document_path)
                        <a href="{{ asset('storage/' . $transfer->document_path) }}" target="_blank" class="p-1 text-primary-container hover:bg-primary-container/10 rounded transition-colors" title="View Document">
                            <span class="material-symbols-outlined text-[20px]">description</span>
                        </a>
                    @endif

                    @if($transfer->status == 'pending')
                        <form method="POST" action="{{ route('admin.transfers.approve', $transfer->id) }}" onsubmit="return confirm('Approve this transfer? The property ownership will be updated immediately.');" class="inline">
                            @csrf
                            <button type="submit" class="flex-1 md:flex-none px-3 py-1.5 bg-primary text-white text-label-sm rounded-lg hover:opacity-90 active:scale-95 transition-all">Approve</button>
                        </form>
                        <form method="POST" action="{{ route('admin.transfers.reject', $transfer->id) }}" onsubmit="return confirm('Reject this transfer?');" class="inline">
                            @csrf
                            <button type="submit" class="flex-1 md:flex-none px-3 py-1.5 border border-error text-error text-label-sm rounded-lg hover:bg-error-container/20 active:scale-95 transition-all">Reject</button>
                        </form>
                    @endif
                </div>
            </div>
        @empty
            <div class="bg-surface-container-lowest border border-outline-variant p-8 text-center text-on-surface-variant italic font-body-sm rounded-b-xl">
                No transfer requests found.
            </div>
        @endforelse
    </section>

    @if($transfers->hasPages())
        <div class="mt-lg flex justify-center">
            {{ $transfers->links() }}
        </div>
    @endif
</main>
@endsection
