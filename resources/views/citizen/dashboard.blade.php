@extends('layouts.app')

@section('content')
<main class="px-4 max-w-container-max mx-auto space-y-md">
    <!-- Welcome Section -->
    <section class="mb-gutter">
        <h2 class="font-h3 text-h3 text-primary-container">Welcome, {{ auth()->user()->name }}</h2>
        <p class="font-body-sm text-body-sm text-on-surface-variant">Review your land holdings and pending obligations.</p>
    </section>

    <!-- Bento Grid Overview Cards -->
    <div class="grid grid-cols-2 gap-4">
        <!-- Properties Owned -->
        <div class="col-span-2 bg-surface-container-lowest border border-outline-variant p-4 rounded-xl flex flex-col justify-between h-32">
            <div class="flex justify-between items-start">
                <span class="material-symbols-outlined text-primary-container" data-icon="domain">domain</span>
                <span class="bg-secondary-container text-on-secondary-container text-xs px-2 py-1 rounded-full font-bold">Verified</span>
            </div>
            <div>
                <p class="font-label-sm text-on-surface-variant">Properties Owned</p>
                <h3 class="font-h3 text-h3 text-primary-container">{{ $properties_count ?? 0 }}</h3>
            </div>
        </div>
        <!-- Pending Tax -->
        <div class="bg-surface-container-lowest border border-outline-variant p-4 rounded-xl flex flex-col justify-between h-40">
            <span class="material-symbols-outlined text-error" data-icon="account_balance_wallet">account_balance_wallet</span>
            <div>
                <p class="font-label-sm text-on-surface-variant">Pending Tax</p>
                <h3 class="font-h3 text-h3 text-error">${{ number_format($pending_tax ?? 0, 2) }}</h3>
            </div>
        </div>
        <!-- Next Due Date -->
        <div class="bg-surface-container-lowest border border-outline-variant p-4 rounded-xl flex flex-col justify-between h-40">
            <span class="material-symbols-outlined text-primary-container" data-icon="event">event</span>
            <div>
                <p class="font-label-sm text-on-surface-variant">Next Due Date</p>
                <h3 class="font-h3 text-h3 text-primary-container">{{ $next_due_date ?? 'N/A' }}</h3>
            </div>
        </div>
    </div>

    <!-- Quick Actions Grid -->
    <section class="space-y-sm">
        <h3 class="font-label-md text-label-md text-on-surface uppercase tracking-wider">Quick Actions</h3>
        <div class="grid grid-cols-2 gap-3">
            <a href="{{ route('citizen.land-records.index') }}" class="flex items-center gap-3 bg-primary-container text-white p-3 rounded-lg hover:bg-primary transition-all">
                <span class="material-symbols-outlined" data-icon="payments">payments</span>
                <span class="font-label-sm">Pay Taxes</span>
            </a>
            <a href="{{ route('citizen.land-records.index') }}" class="flex items-center gap-3 border border-primary-container text-primary-container p-3 rounded-lg hover:bg-surface-container-low transition-all">
                <span class="material-symbols-outlined" data-icon="search">search</span>
                <span class="font-label-sm">Title Search</span>
            </a>
        </div>
    </section>

    <!-- Recent Activity -->
    <section class="space-y-sm pb-lg">
        <div class="flex justify-between items-center">
            <h3 class="font-label-md text-label-md text-on-surface uppercase tracking-wider">Recent Activity</h3>
            <button class="text-primary-container font-label-sm">View All</button>
        </div>
        <div class="space-y-3">
            @forelse($recent_activities ?? [] as $activity)
                <div class="bg-white border border-outline-variant rounded-lg p-4 flex gap-4">
                    <div class="w-10 h-10 rounded bg-secondary-container flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-on-secondary-container" data-icon="check_circle">check_circle</span>
                    </div>
                    <div class="flex-1">
                        <div class="flex justify-between">
                            <h4 class="font-label-md text-primary-container">{{ $activity->title }}</h4>
                            <span class="font-label-sm text-on-surface-variant">{{ $activity->date }}</span>
                        </div>
                        <p class="font-body-sm text-on-surface-variant mt-1">{{ $activity->description }}</p>
                    </div>
                </div>
            @empty
                <div class="bg-surface-container-low border border-dashed border-outline-variant rounded-lg p-8 flex items-center justify-center opacity-70">
                    <p class="font-body-sm italic text-on-surface-variant">No recent activity found.</p>
                </div>
            @endforelse
        </div>
    </section>
</main>
@endsection
