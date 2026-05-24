@extends('layouts.app')

@section('content')
<main class="max-w-container-max mx-auto p-4 md:p-6 space-y-6 mb-24">
    <!-- Header & Action -->
    <section class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 border-b border-outline-variant pb-4">
        <div>
            <h2 class="font-h2 text-h2 text-primary">Land Records Management</h2>
            <p class="font-body-sm text-on-surface-variant">Manage all registered properties and land records.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.land-records.export') }}" class="flex items-center gap-2 border border-outline-variant bg-white text-on-surface-variant px-4 py-2.5 rounded-lg font-label-md hover:bg-surface-container-low transition-all">
                <span class="material-symbols-outlined text-[18px]" data-icon="download">download</span>
                Export CSV
            </a>
            <a href="{{ route('admin.land-records.create') }}" class="flex items-center gap-2 bg-primary text-white px-5 py-2.5 rounded-lg font-label-md hover:opacity-90 active:scale-95 transition-all">
                <span class="material-symbols-outlined text-[20px]" data-icon="add">add</span>
                Create New Record
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
        <form action="{{ route('admin.land-records.index') }}" method="GET" class="relative flex-grow flex items-center gap-2">
            <div class="relative flex-grow">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline" data-icon="search">search</span>
                <input name="search" value="{{ request('search') }}" class="w-full pl-10 pr-4 py-2 bg-white border border-outline-variant rounded-lg text-body-md focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all" placeholder="Search by Record ID, Plot Number, or Owner Name" type="text"/>
            </div>
            <button type="submit" class="bg-surface-container-high border border-outline-variant text-on-surface px-4 py-2 rounded-lg font-label-md hover:bg-surface-container-highest transition-colors">
                Search
            </button>
            @if(request()->has('search'))
                <a href="{{ route('admin.land-records.index') }}" class="text-error hover:underline font-label-sm px-2">Clear</a>
            @endif
        </form>
    </section>

    <!-- Records Table -->
    <section class="bg-white border border-outline-variant rounded-lg overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-[800px]">
                <thead>
                    <tr class="bg-surface-container text-on-surface-variant font-label-md border-b border-outline-variant">
                        <th class="p-4">Record ID</th>
                        <th class="p-4">Owner Name</th>
                        <th class="p-4">Plot / Survey</th>
                        <th class="p-4">Type</th>
                        <th class="p-4">Status</th>
                        <th class="p-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/50">
                    @forelse($records as $record)
                        <tr class="hover:bg-surface-container-low transition-colors">
                            <td class="p-4 font-body-md text-primary font-bold">{{ $record->record_number }}</td>
                            <td class="p-4 font-body-sm">{{ $record->owner->name ?? 'N/A' }}</td>
                            <td class="p-4 font-body-sm">{{ $record->plot_number }} / {{ $record->survey_number }}</td>
                            <td class="p-4 font-body-sm capitalize">{{ $record->land_type }}</td>
                            <td class="p-4">
                                <span class="{{ $record->status == 'active' ? 'bg-secondary-container text-on-secondary-container' : 'bg-surface-container-highest text-on-surface-variant' }} text-[10px] px-2 py-1 rounded-full font-bold uppercase">
                                    {{ $record->status }}
                                </span>
                            </td>
                            <td class="p-4 flex gap-2 justify-end">
                                @if($record->document_path)
                                    <a href="{{ asset('storage/' . $record->document_path) }}" target="_blank" class="p-2 text-primary-container hover:bg-primary-container/10 rounded-lg transition-colors" title="View Document">
                                        <span class="material-symbols-outlined text-[20px]">description</span>
                                    </a>
                                @endif
                                <a href="{{ route('admin.land-records.edit', $record->id) }}" class="p-2 text-primary hover:bg-primary/10 rounded-lg transition-colors" title="Edit">
                                    <span class="material-symbols-outlined text-[20px]">edit</span>
                                </a>
                                <form method="POST" action="{{ route('admin.land-records.destroy', $record->id) }}" onsubmit="return confirm('Are you sure you want to delete this record?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-error hover:bg-error/10 rounded-lg transition-colors" title="Delete">
                                        <span class="material-symbols-outlined text-[20px]">delete</span>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center font-body-sm italic text-on-surface-variant">No land records found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
    
    @if($records->hasPages())
        <div class="mt-lg flex justify-center">
            {{ $records->links() }}
        </div>
    @endif
</main>
@endsection
