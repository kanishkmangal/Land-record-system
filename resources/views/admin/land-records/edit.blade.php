@extends('layouts.app')

@section('content')
<main class="max-w-xl mx-auto p-4 md:p-6 space-y-6 mb-24">
    <!-- Header -->
    <section class="border-b border-outline-variant pb-4">
        <h2 class="font-h2 text-h2 text-primary">Edit Land Record</h2>
        <p class="font-body-sm text-on-surface-variant">Update the details for {{ $record->record_number }}</p>
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

    <!-- Form -->
    <section class="bg-white border border-outline-variant rounded-xl p-6 shadow-sm">
        <form method="POST" action="{{ route('admin.land-records.update', $record->id) }}" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-2 gap-4">
                <div class="col-span-2">
                    <label class="block font-label-md text-on-surface-variant mb-1">Owner (Citizen)</label>
                    <select name="owner_id" required class="w-full h-11 px-4 rounded-lg border border-outline-variant focus:border-2 focus:border-primary-container outline-none transition-all font-body-md bg-white">
                        <option value="" disabled>Select an owner...</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ (old('owner_id') ?? $record->owner_id) == $user->id ? 'selected' : '' }}>{{ $user->name }} ({{ $user->email }})</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block font-label-md text-on-surface-variant mb-1">Record Number</label>
                    <input name="record_number" value="{{ $record->record_number }}" class="w-full h-11 px-4 rounded-lg border border-outline-variant focus:border-2 focus:border-primary-container outline-none transition-all font-body-md bg-surface-container-low text-on-surface-variant" type="text" readonly/>
                </div>

                <div>
                    <label class="block font-label-md text-on-surface-variant mb-1">Land Type</label>
                    <select name="land_type" required class="w-full h-11 px-4 rounded-lg border border-outline-variant focus:border-2 focus:border-primary-container outline-none transition-all font-body-md bg-white">
                        <option value="residential" {{ (old('land_type') ?? $record->land_type) == 'residential' ? 'selected' : '' }}>Residential</option>
                        <option value="commercial" {{ (old('land_type') ?? $record->land_type) == 'commercial' ? 'selected' : '' }}>Commercial</option>
                        <option value="agricultural" {{ (old('land_type') ?? $record->land_type) == 'agricultural' ? 'selected' : '' }}>Agricultural</option>
                        <option value="industrial" {{ (old('land_type') ?? $record->land_type) == 'industrial' ? 'selected' : '' }}>Industrial</option>
                    </select>
                </div>

                <div>
                    <label class="block font-label-md text-on-surface-variant mb-1">Plot Number</label>
                    <input name="plot_number" required value="{{ old('plot_number') ?? $record->plot_number }}" class="w-full h-11 px-4 rounded-lg border border-outline-variant focus:border-2 focus:border-primary-container outline-none transition-all font-body-md" type="text"/>
                </div>

                <div>
                    <label class="block font-label-md text-on-surface-variant mb-1">Survey Number</label>
                    <input name="survey_number" required value="{{ old('survey_number') ?? $record->survey_number }}" class="w-full h-11 px-4 rounded-lg border border-outline-variant focus:border-2 focus:border-primary-container outline-none transition-all font-body-md" type="text"/>
                </div>

                <div>
                    <label class="block font-label-md text-on-surface-variant mb-1">Area (SqFt)</label>
                    <input name="area_sqft" required value="{{ old('area_sqft') ?? $record->area_sqft }}" class="w-full h-11 px-4 rounded-lg border border-outline-variant focus:border-2 focus:border-primary-container outline-none transition-all font-body-md" type="number" step="0.01"/>
                </div>

                <div>
                    <label class="block font-label-md text-on-surface-variant mb-1">Status</label>
                    <select name="status" required class="w-full h-11 px-4 rounded-lg border border-outline-variant focus:border-2 focus:border-primary-container outline-none transition-all font-body-md bg-white">
                        <option value="active" {{ (old('status') ?? $record->status) == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="transferred" {{ (old('status') ?? $record->status) == 'transferred' ? 'selected' : '' }}>Transferred</option>
                        <option value="disputed" {{ (old('status') ?? $record->status) == 'disputed' ? 'selected' : '' }}>Disputed</option>
                    </select>
                </div>

                <div class="col-span-2">
                    <label class="block font-label-md text-on-surface-variant mb-1">Location Address</label>
                    <input name="location" required value="{{ old('location') ?? $record->location }}" class="w-full h-11 px-4 rounded-lg border border-outline-variant focus:border-2 focus:border-primary-container outline-none transition-all font-body-md" type="text"/>
                </div>

                <div>
                    <label class="block font-label-md text-on-surface-variant mb-1">District</label>
                    <input name="district" required value="{{ old('district') ?? $record->district }}" class="w-full h-11 px-4 rounded-lg border border-outline-variant focus:border-2 focus:border-primary-container outline-none transition-all font-body-md" type="text"/>
                </div>

                <div>
                    <label class="block font-label-md text-on-surface-variant mb-1">State</label>
                    <input name="state" required value="{{ old('state') ?? $record->state }}" class="w-full h-11 px-4 rounded-lg border border-outline-variant focus:border-2 focus:border-primary-container outline-none transition-all font-body-md" type="text"/>
                </div>

                <div class="col-span-2 mt-2">
                    <label class="block font-label-md text-on-surface-variant mb-1">Update Title Deed Document (Optional)</label>
                    @if($record->document_path)
                        <div class="mb-2 p-2 bg-surface-container-low rounded flex items-center gap-2 text-label-sm">
                            <span class="material-symbols-outlined text-primary text-[16px]">draft</span>
                            Current file: <a href="{{ asset('storage/' . $record->document_path) }}" target="_blank" class="text-primary hover:underline">View Document</a>
                        </div>
                    @endif
                    <input name="document" type="file" class="w-full px-4 py-3 rounded-lg border border-outline-variant border-dashed focus:border-primary-container outline-none transition-all font-body-sm text-on-surface-variant file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary-container file:text-white hover:file:bg-primary"/>
                </div>
            </div>

            <div class="mt-8 flex items-center justify-end gap-3 pt-4 border-t border-outline-variant">
                <a href="{{ route('admin.land-records.index') }}" class="px-5 py-2.5 rounded-lg font-label-md text-on-surface-variant hover:bg-surface-container-low transition-colors">
                    Cancel
                </a>
                <button type="submit" class="bg-primary text-white px-6 py-2.5 rounded-lg font-label-md hover:opacity-90 active:scale-95 transition-all">
                    Update Record
                </button>
            </div>
        </form>
    </section>
</main>
@endsection
