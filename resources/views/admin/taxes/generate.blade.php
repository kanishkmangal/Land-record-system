@extends('layouts.app')

@section('content')
<main class="max-w-xl mx-auto p-4 md:p-6 space-y-6 mb-24">
    <!-- Header -->
    <section class="border-b border-outline-variant pb-4">
        <h2 class="font-h2 text-h2 text-primary">Generate Tax Bills</h2>
        <p class="font-body-sm text-on-surface-variant">Create new property tax bills for all active land records for a specific financial year.</p>
    </section>

    <!-- Error Messages -->
    @if($errors->any())
        <div class="bg-error-container text-on-error-container p-4 rounded-lg font-body-sm">
            <ul class="list-disc ml-4 space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Warning Alert -->
    <div class="bg-surface-container-high text-on-surface p-4 rounded-lg flex items-start gap-3 border border-outline-variant">
        <span class="material-symbols-outlined text-primary mt-0.5">info</span>
        <div>
            <h4 class="font-label-md">How this works</h4>
            <p class="font-body-sm text-on-surface-variant mt-1">This will automatically generate a pending property tax bill for <strong>every active land record</strong> in the system that doesn't already have a bill for the specified financial year.</p>
        </div>
    </div>

    <!-- Form -->
    <section class="bg-white border border-outline-variant rounded-xl p-6 shadow-sm">
        <form method="POST" action="{{ route('admin.taxes.store') }}" class="space-y-4">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="md:col-span-2">
                    <label class="block font-label-md text-on-surface-variant mb-1">Financial Year</label>
                    <input name="financial_year" required value="{{ old('financial_year') ?? (date('Y') . '-' . (date('Y') + 1)) }}" class="w-full h-11 px-4 rounded-lg border border-outline-variant focus:border-2 focus:border-primary-container outline-none transition-all font-body-md" placeholder="e.g. 2024-2025" type="text"/>
                </div>

                <div>
                    <label class="block font-label-md text-on-surface-variant mb-1">Base Amount ($)</label>
                    <input name="base_amount" required value="{{ old('base_amount') ?? '500.00' }}" class="w-full h-11 px-4 rounded-lg border border-outline-variant focus:border-2 focus:border-primary-container outline-none transition-all font-body-md" type="number" step="0.01" min="0"/>
                </div>

                <div>
                    <label class="block font-label-md text-on-surface-variant mb-1">Penalty Amount ($)</label>
                    <input name="penalty_amount" required value="{{ old('penalty_amount') ?? '0.00' }}" class="w-full h-11 px-4 rounded-lg border border-outline-variant focus:border-2 focus:border-primary-container outline-none transition-all font-body-md" type="number" step="0.01" min="0"/>
                </div>

                <div class="md:col-span-2">
                    <label class="block font-label-md text-on-surface-variant mb-1">Due Date</label>
                    <input name="due_date" required value="{{ old('due_date') ?? now()->addDays(30)->toDateString() }}" class="w-full h-11 px-4 rounded-lg border border-outline-variant focus:border-2 focus:border-primary-container outline-none transition-all font-body-md" type="date"/>
                </div>
            </div>

            <div class="mt-8 flex items-center justify-end gap-3 pt-4 border-t border-outline-variant">
                <a href="{{ route('admin.taxes.index') }}" class="px-5 py-2.5 rounded-lg font-label-md text-on-surface-variant hover:bg-surface-container-low transition-colors">
                    Cancel
                </a>
                <button type="submit" class="bg-primary text-white px-6 py-2.5 rounded-lg font-label-md hover:opacity-90 active:scale-95 transition-all" onclick="return confirm('Are you sure you want to generate bills for all active records? This action cannot be undone.');">
                    Generate Bills
                </button>
            </div>
        </form>
    </section>
</main>
@endsection
