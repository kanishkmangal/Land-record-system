@extends('layouts.app')

@section('content')
<main class="max-w-md mx-auto px-4 pt-6 pb-12 mb-24">
    <!-- Header -->
    <section class="mb-gutter">
        <h2 class="font-h2 text-primary-container">Land Transfer Application</h2>
        <p class="font-body-sm text-on-surface-variant mt-1">Initiate a transfer of ownership for your property.</p>
    </section>

    <!-- Property Summary Card -->
    <section class="mb-gutter">
        <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-4 shadow-sm flex items-start gap-4">
            <div class="bg-primary-container text-white p-3 rounded-lg flex items-center justify-center">
                <span class="material-symbols-outlined text-2xl" data-icon="domain">domain</span>
            </div>
            <div>
                <span class="font-label-sm text-on-surface-variant uppercase tracking-widest text-[10px]">Property Record</span>
                <h3 class="font-h3 text-primary">{{ $record->record_number }}</h3>
                <p class="font-body-sm text-on-surface-variant">{{ $record->location }}, {{ $record->district }}</p>
            </div>
        </div>
    </section>

    <!-- Transfer Form -->
    <section>
        <div class="bg-white border border-outline-variant rounded-xl p-6 shadow-sm">
            <div class="flex items-center gap-2 mb-6 border-b border-outline-variant pb-2">
                <span class="material-symbols-outlined text-primary-container" data-icon="person_add">person_add</span>
                <h3 class="font-h3 text-on-surface">New Owner Details</h3>
            </div>

            <!-- Error Messages -->
            @if($errors->any())
                <div class="bg-error-container text-on-error-container p-3 rounded mb-4 font-body-sm flex items-start gap-2">
                    <span class="material-symbols-outlined text-sm mt-0.5">warning</span>
                    <ul class="list-disc ml-4">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('citizen.land-records.transfer.store', $record->id) }}" enctype="multipart/form-data" class="flex flex-col gap-4">
                @csrf
                
                <div>
                    <label class="block font-label-md text-on-surface-variant mb-1 ml-1">Full Name of Transferee</label>
                    <input name="buyer_name" required value="{{ old('buyer_name') }}" class="w-full h-11 px-4 rounded-lg border border-outline-variant focus:border-2 focus:border-primary-container outline-none transition-all font-body-md" placeholder="e.g. Jane Doe" type="text"/>
                </div>

                <div>
                    <label class="block font-label-md text-on-surface-variant mb-1 ml-1">National ID / CNIC</label>
                    <input name="buyer_cnic" required value="{{ old('buyer_cnic') }}" class="w-full h-11 px-4 rounded-lg border border-outline-variant focus:border-2 focus:border-primary-container outline-none transition-all font-body-md" placeholder="XXXXX-XXXXXXX-X" type="text"/>
                </div>

                <div>
                    <label class="block font-label-md text-on-surface-variant mb-1 ml-1">Contact Email</label>
                    <input name="buyer_email" required value="{{ old('buyer_email') }}" class="w-full h-11 px-4 rounded-lg border border-outline-variant focus:border-2 focus:border-primary-container outline-none transition-all font-body-md" placeholder="jane@example.com" type="email"/>
                </div>

                <div>
                    <label class="block font-label-md text-on-surface-variant mb-1 ml-1">Reason for Transfer</label>
                    <select name="transfer_reason" required class="w-full h-11 px-4 rounded-lg border border-outline-variant focus:border-2 focus:border-primary-container outline-none transition-all font-body-md bg-white">
                        <option value="" disabled selected>Select a reason...</option>
                        <option value="sale" {{ old('transfer_reason') == 'sale' ? 'selected' : '' }}>Sale / Purchase</option>
                        <option value="gift" {{ old('transfer_reason') == 'gift' ? 'selected' : '' }}>Gift / Donation</option>
                        <option value="inheritance" {{ old('transfer_reason') == 'inheritance' ? 'selected' : '' }}>Inheritance</option>
                        <option value="other" {{ old('transfer_reason') == 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>

                <div>
                    <label class="block font-label-md text-on-surface-variant mb-1 ml-1">Supporting Documents (PDF, JPG)</label>
                    <div class="relative">
                        <input name="transfer_document" type="file" required class="w-full px-4 py-2 rounded-lg border border-outline-variant border-dashed focus:border-primary-container outline-none transition-all font-body-sm text-on-surface-variant file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary-container file:text-white hover:file:bg-primary"/>
                    </div>
                    <p class="text-[10px] text-outline mt-1 ml-1">Upload the transfer deed or No Objection Certificate (NOC).</p>
                </div>

                <div class="mt-6 flex flex-col gap-3">
                    <button class="w-full h-[44px] bg-secondary text-white font-label-md rounded-lg flex items-center justify-center gap-2 hover:opacity-90 active:scale-95 transition-all" type="submit">
                        <span class="material-symbols-outlined text-lg" data-icon="send">send</span>
                        Submit Application
                    </button>
                    <a href="{{ route('citizen.land-records.show', $record->id) }}" class="w-full h-[44px] border border-outline-variant text-on-surface-variant font-label-md rounded-lg flex items-center justify-center gap-2 hover:bg-surface-container-low transition-all text-center">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </section>
</main>
@endsection
