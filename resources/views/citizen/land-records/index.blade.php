@extends('layouts.app')

@section('content')
<main class="max-w-container-max mx-auto px-4 py-md mb-24">
    <!-- Search Section -->
    <section class="mb-gutter">
        <div class="flex flex-col gap-base">
            <label class="font-label-md text-on-surface-variant ml-1">Search My Property Records</label>
            <div class="relative group">
                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline group-focus-within:text-primary-container">search</span>
                <input class="w-full h-[48px] pl-12 pr-4 bg-surface-container-lowest border border-outline-variant rounded-xl focus:ring-2 focus:ring-primary-container focus:border-primary-container outline-none font-body-md transition-all shadow-sm" placeholder="Search by Record ID or Plot Number" type="text"/>
            </div>
        </div>
    </section>

    <!-- Quick Filters -->
    <section class="mb-gutter overflow-x-auto pb-2 -mx-4 px-4 scrollbar-hide">
        <div class="flex gap-sm">
            <button class="flex items-center gap-xs px-4 py-2 bg-primary-container text-white rounded-full font-label-md whitespace-nowrap shadow-sm">
                <span class="material-symbols-outlined text-[18px]">tune</span>
                All Records
            </button>
            <button class="flex items-center gap-xs px-4 py-2 bg-white border border-outline-variant text-on-surface-variant rounded-full font-label-md whitespace-nowrap hover:bg-surface-container-low transition-colors">
                Verified
            </button>
            <button class="flex items-center gap-xs px-4 py-2 bg-white border border-outline-variant text-on-surface-variant rounded-full font-label-md whitespace-nowrap hover:bg-surface-container-low transition-colors">
                Pending
            </button>
        </div>
    </section>

    <!-- Records Grid -->
    <div class="flex flex-col gap-sm">
        <div class="flex justify-between items-end mb-2 px-1">
            <h2 class="font-h3 text-primary">Found {{ $records->count() }} Records</h2>
            <span class="font-label-sm text-outline">Updated just now</span>
        </div>

        @forelse($records as $record)
            <!-- Record Card -->
            <article class="bg-surface-container-lowest border border-outline-variant rounded-xl p-4 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex justify-between items-start mb-base">
                    <div>
                        <p class="font-label-sm text-outline uppercase tracking-wider mb-xs">Record Number</p>
                        <h3 class="font-h3 text-primary">{{ $record->record_number }}</h3>
                    </div>
                    @php
                        $statusColors = [
                            'active' => 'bg-secondary-container text-on-secondary-container',
                            'transferred' => 'bg-surface-container-highest text-on-surface-variant',
                            'disputed' => 'bg-error-container text-on-error-container',
                        ];
                        $statusIcons = [
                            'active' => 'check_circle',
                            'transferred' => 'swap_horiz',
                            'disputed' => 'warning',
                        ];
                    @endphp
                    <span class="px-3 py-1 {{ $statusColors[$record->status] ?? 'bg-surface-container' }} rounded-full font-label-sm flex items-center gap-1">
                        <span class="material-symbols-outlined text-[14px]" style="font-variation-settings: 'FILL' 1;">{{ $statusIcons[$record->status] ?? 'info' }}</span>
                        {{ ucfirst($record->status) }}
                    </span>
                </div>
                <div class="grid grid-cols-2 gap-md py-base border-y border-outline-variant/30 my-base">
                    <div>
                        <p class="font-label-sm text-outline">Plot Number</p>
                        <p class="font-body-md font-semibold text-on-surface">{{ $record->plot_number }}</p>
                    </div>
                    <div>
                        <p class="font-label-sm text-outline">Location</p>
                        <p class="font-body-md font-semibold text-on-surface">{{ $record->location }}, {{ $record->district }}</p>
                    </div>
                </div>
                <div class="flex items-center justify-between mt-sm">
                    <div class="flex items-center gap-2 text-outline">
                        <span class="material-symbols-outlined text-[20px]">calendar_today</span>
                        <span class="font-label-sm">Registered: {{ $record->created_at->format('M d, Y') }}</span>
                    </div>
                    <a href="{{ route('citizen.land-records.show', $record->id) }}" class="bg-primary-container text-white px-5 py-2.5 rounded-lg font-label-md hover:opacity-90 transition-opacity active:scale-95 inline-block text-center">
                        View Details
                    </a>
                </div>
            </article>
        @empty
            <div class="bg-white border border-dashed border-outline-variant rounded-xl p-12 text-center">
                <span class="material-symbols-outlined text-outline text-5xl mb-4">description_off</span>
                <p class="font-body-md text-on-surface-variant">No land records found associated with your account.</p>
                <button class="mt-4 text-primary-container font-label-md hover:underline">Contact Registry Office</button>
            </div>
        @endforelse
    </div>

    @if($records->hasPages())
        <div class="mt-lg flex justify-center">
            {{ $records->links() }}
        </div>
    @endif
</main>
@endsection
