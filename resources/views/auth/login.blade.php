@extends('layouts.app')

@section('content')
<div class="min-h-[80vh] flex flex-col items-center justify-center px-gutter">
    <!-- Transactional Header -->
    <div class="w-full flex flex-col items-center mb-md">
        <div class="w-16 h-16 mb-4 flex items-center justify-center bg-primary-container rounded-full shadow-sm">
            <span class="material-symbols-outlined text-white text-[32px]" data-icon="account_balance">account_balance</span>
        </div>
        <h1 class="font-h2 text-h2 text-primary tracking-tight text-center">Land Records Portal</h1>
        <p class="font-body-sm text-body-sm text-on-surface-variant mt-2 text-center max-w-[280px]">Secure Official Gateway for National Land Title & Tax Services</p>
    </div>

    <!-- Main Content Canvas -->
    <div class="w-full max-w-md">
        <div class="bg-surface-container-lowest border border-outline-variant p-md rounded-xl shadow-[0_4px_12px_rgba(0,0,0,0.05)]">
            <form method="POST" action="{{ route('login') }}" class="space-y-gutter">
                @csrf

                <!-- Email Address -->
                <div class="flex flex-col gap-xs">
                    <label class="font-label-md text-label-md text-on-surface" for="email">Email</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-[20px]" data-icon="person">person</span>
                        <input class="w-full h-[44px] pl-10 pr-4 bg-white border border-outline rounded-lg font-body-md text-body-md focus:border-primary-container focus:ring-1 focus:ring-primary-container outline-none transition-all @error('email') border-error @enderror" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="Enter your registered email" type="email"/>
                    </div>
                    @error('email')
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
                        <input class="w-full h-[44px] pl-10 pr-10 bg-white border border-outline rounded-lg font-body-md text-body-md focus:border-primary-container focus:ring-1 focus:ring-primary-container outline-none transition-all @error('password') border-error @enderror" id="password" name="password" required placeholder="••••••••" type="password"/>
                        <button class="absolute right-3 top-1/2 -translate-y-1/2 text-outline hover:text-primary" type="button" onclick="const p = document.getElementById('password'); p.type = p.type === 'password' ? 'text' : 'password';">
                            <span class="material-symbols-outlined text-[20px]" data-icon="visibility">visibility</span>
                        </button>
                    </div>
                    @error('password')
                        <span class="font-label-sm text-label-sm text-error flex items-center gap-1">
                            <span class="material-symbols-outlined text-[14px]" data-icon="error">error</span>
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input name="remember" class="w-4 h-4 rounded border-outline text-primary focus:ring-primary" type="checkbox"/>
                        <span class="font-label-sm text-label-sm text-on-surface-variant">Remember me</span>
                    </label>
                    @if (Route::has('password.request'))
                        <a class="font-label-sm text-label-sm text-primary-container font-semibold hover:underline" href="{{ route('password.request') }}">Forgot Password?</a>
                    @endif
                </div>

                <!-- Primary Action -->
                <button class="w-full h-[44px] bg-primary-container text-white font-label-md text-label-md rounded-lg shadow-sm hover:opacity-90 active:scale-[0.98] transition-all flex items-center justify-center gap-2" type="submit">
                    Login
                    <span class="material-symbols-outlined text-[20px]" data-icon="arrow_forward">arrow_forward</span>
                </button>
            </form>

            <div class="mt-lg flex flex-col items-center gap-md">
                <div class="w-full h-px bg-outline-variant relative">
                    <span class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 px-2 bg-surface-container-lowest text-label-sm font-medium text-outline">OR</span>
                </div>
                <p class="font-body-sm text-body-sm text-on-surface-variant">
                    Don't have an account? 
                    <a class="text-primary-container font-bold hover:underline" href="{{ route('register') }}">Register</a>
                </p>
            </div>
        </div>

        <!-- Trust Indicator -->
        <div class="mt-md flex items-center justify-center gap-2 text-on-surface-variant/60">
            <span class="material-symbols-outlined text-[16px]" data-icon="verified_user" style="font-variation-settings: 'FILL' 1;">verified_user</span>
            <span class="font-label-sm text-label-sm">256-bit SSL Secure Connection</span>
        </div>
    </div>
</div>
@endsection
