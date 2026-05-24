@extends('layouts.app')

@section('content')
<main class="max-w-md mx-auto px-4 pt-6 pb-12 mb-24">
    <div class="mb-gutter">
        <h2 class="font-h2 text-on-surface">Profile Settings</h2>
    </div>

    <div class="space-y-6">
        <div class="p-6 bg-surface-container-lowest border border-outline-variant rounded-xl shadow-sm">
            <div class="max-w-xl">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <div class="p-6 bg-surface-container-lowest border border-outline-variant rounded-xl shadow-sm">
            <div class="max-w-xl">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <div class="p-6 bg-error-container/30 border border-error-container rounded-xl shadow-sm">
            <div class="max-w-xl">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</main>
@endsection
