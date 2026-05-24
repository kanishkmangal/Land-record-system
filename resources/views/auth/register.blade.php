@extends('layouts.app')

@section('content')
<div class="min-h-[80vh] flex flex-col items-center justify-center px-gutter py-10">
    <!-- Transactional Header -->
    <div class="w-full flex flex-col items-center mb-md">
        <div class="w-16 h-16 mb-4 flex items-center justify-center bg-primary-container rounded-full shadow-sm">
            <span class="material-symbols-outlined text-white text-[32px]" data-icon="how_to_reg">how_to_reg</span>
        </div>
        <h1 class="font-h2 text-h2 text-primary tracking-tight text-center">Create Citizen Account</h1>
        <p class="font-body-sm text-body-sm text-on-surface-variant mt-2 text-center max-w-[280px]">Join the official portal for digital land records and tax management.</p>
    </div>

    <!-- Main Content Canvas -->
    <div class="w-full max-w-md">
        <div class="bg-surface-container-lowest border border-outline-variant p-md rounded-xl shadow-[0_4px_12px_rgba(0,0,0,0.05)]">
            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                <!-- Name -->
                <div class="flex flex-col gap-xs">
                    <label class="font-label-md text-label-md text-on-surface" for="name">Full Name</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-[20px]" data-icon="person">person</span>
                        <input class="w-full h-[44px] pl-10 pr-4 bg-white border border-outline rounded-lg font-body-md text-body-md focus:border-primary-container focus:ring-1 focus:ring-primary-container outline-none transition-all @error('name') border-error @enderror" id="name" name="name" value="{{ old('name') }}" required autofocus placeholder="Enter your full name" type="text"/>
                    </div>
                    @error('name')
                        <span class="font-label-sm text-label-sm text-error flex items-center gap-1">
                            <span class="material-symbols-outlined text-[14px]" data-icon="error">error</span>
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <!-- Email Address -->
                <div class="flex flex-col gap-xs">
                    <label class="font-label-md text-label-md text-on-surface" for="email">Email Address</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-[20px]" data-icon="mail">mail</span>
                        <input class="w-full h-[44px] pl-10 pr-4 bg-white border border-outline rounded-lg font-body-md text-body-md focus:border-primary-container focus:ring-1 focus:ring-primary-container outline-none transition-all @error('email') border-error @enderror" id="email" name="email" value="{{ old('email') }}" required placeholder="yourname@example.com" type="email"/>
                    </div>
                    @error('email')
                        <span class="font-label-sm text-label-sm text-error flex items-center gap-1">
                            <span class="material-symbols-outlined text-[14px]" data-icon="error">error</span>
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <!-- Phone -->
                <div class="flex flex-col gap-xs">
                    <label class="font-label-md text-label-md text-on-surface" for="phone">Phone Number</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-[20px]" data-icon="call">call</span>
                        <input class="w-full h-[44px] pl-10 pr-4 bg-white border border-outline rounded-lg font-body-md text-body-md focus:border-primary-container focus:ring-1 focus:ring-primary-container outline-none transition-all @error('phone') border-error @enderror" id="phone" name="phone" value="{{ old('phone') }}" required placeholder="Enter mobile number" type="text"/>
                    </div>
                    @error('phone')
                        <span class="font-label-sm text-label-sm text-error flex items-center gap-1">
                            <span class="material-symbols-outlined text-[14px]" data-icon="error">error</span>
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <!-- Address -->
                <div class="flex flex-col gap-xs">
                    <label class="font-label-md text-label-md text-on-surface" for="address">Residential Address</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-3 text-outline text-[20px]" data-icon="home">home</span>
                        <textarea class="w-full pl-10 pr-4 py-2 bg-white border border-outline rounded-lg font-body-md text-body-md focus:border-primary-container focus:ring-1 focus:ring-primary-container outline-none transition-all @error('address') border-error @enderror" id="address" name="address" required placeholder="Enter your full address" rows="2">{{ old('address') }}</textarea>
                    </div>
                    @error('address')
                        <span class="font-label-sm text-label-sm text-error flex items-center gap-1">
                            <span class="material-symbols-outlined text-[14px]" data-icon="error">error</span>
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <!-- Password -->
                <div class="flex flex-col gap-xs">
                    <label class="font-label-md text-label-md text-on-surface" for="password">Password</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-[20px]" data-icon="lock">lock</span>
                        <input class="w-full h-[44px] pl-10 pr-10 bg-white border border-outline rounded-lg font-body-md text-body-md focus:border-primary-container focus:ring-1 focus:ring-primary-container outline-none transition-all @error('password') border-error @enderror" id="password" name="password" required placeholder="Min. 8 characters" type="password"/>
                    </div>
                    @error('password')
                        <span class="font-label-sm text-label-sm text-error flex items-center gap-1">
                            <span class="material-symbols-outlined text-[14px]" data-icon="error">error</span>
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="flex flex-col gap-xs">
                    <label class="font-label-md text-label-md text-on-surface" for="password_confirmation">Confirm Password</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-[20px]" data-icon="lock_reset">lock_reset</span>
                        <input class="w-full h-[44px] pl-10 pr-4 bg-white border border-outline rounded-lg font-body-md text-body-md focus:border-primary-container focus:ring-1 focus:ring-primary-container outline-none transition-all" id="password_confirmation" name="password_confirmation" required placeholder="Repeat password" type="password"/>
                    </div>
                </div>

                <!-- Primary Action -->
                <button class="w-full h-[44px] bg-primary-container text-white font-label-md text-label-md rounded-lg shadow-sm hover:opacity-90 active:scale-[0.98] transition-all flex items-center justify-center gap-2 mt-4" type="submit">
                    Register Account
                    <span class="material-symbols-outlined text-[20px]" data-icon="person_add">person_add</span>
                </button>
            </form>

            <div class="mt-md flex flex-col items-center gap-md">
                <div class="w-full h-px bg-outline-variant relative">
                    <span class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 px-2 bg-surface-container-lowest text-label-sm font-medium text-outline">OR</span>
                </div>
                <p class="font-body-sm text-body-sm text-on-surface-variant">
                    Already have an account? 
                    <a class="text-primary-container font-bold hover:underline" href="{{ route('login') }}">Login</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
