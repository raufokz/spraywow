<x-guest-layout
    title="Login"
    heading="Sign in and pick up where you left off"
    subheading="Access your account to track orders, revisit saved details, and shop faster across every device."
>
    <div class="auth-form-intro">
        <p class="auth-form-kicker">Account Login</p>
        <h2 class="auth-form-title">Welcome back</h2>
        <p class="auth-form-text">Use your email and password to continue to your SprayWow account.</p>
    </div>

    <x-auth-session-status class="auth-status" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="auth-form-grid">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email Address')" />
            <x-text-input id="email" class="block mt-2 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="you@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <div class="flex items-center justify-between gap-3">
                <x-input-label for="password" :value="__('Password')" />
                @if (Route::has('password.request'))
                    <a class="auth-inline-link" href="{{ route('password.request') }}">
                        {{ __('Forgot Password?') }}
                    </a>
                @endif
            </div>

            <div class="auth-password-wrap mt-2">
                <x-text-input id="password" class="block w-full pr-16" type="password" name="password" required autocomplete="current-password" placeholder="Enter your password" data-auth-password-input />
                <button type="button" class="auth-password-toggle" data-auth-password-toggle aria-label="Show password">
                    Show
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="auth-form-meta">
            <label for="remember_me" class="auth-checkbox">
                <input id="remember_me" type="checkbox" class="auth-checkbox-input" name="remember">
                <span>{{ __('Keep me signed in') }}</span>
            </label>
            <span class="auth-meta-copy">Secure login for your orders and saved details.</span>
        </div>

        <div class="mt-2">
            <x-primary-button class="w-full justify-center">
                {{ __('Log In') }}
            </x-primary-button>
        </div>

        <div class="auth-form-footer">
            <span>New to SprayWow?</span>
            <a class="auth-inline-link" href="{{ route('register') }}">Create an account</a>
        </div>
    </form>
</x-guest-layout>
