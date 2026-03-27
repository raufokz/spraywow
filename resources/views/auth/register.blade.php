<x-guest-layout
    title="Register"
    heading="Create your account in a minute"
    subheading="Join SprayWow to save time at checkout, manage orders easily, and keep your cleaning essentials within reach."
>
    <div class="auth-form-intro">
        <p class="auth-form-kicker">Create Account</p>
        <h2 class="auth-form-title">Set up your profile</h2>
        <p class="auth-form-text">Start with a few details and you'll be ready to shop, reorder, and track everything in one place.</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-2 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Your full name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-2 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="you@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <div class="auth-password-wrap mt-2">
                <x-text-input id="password" class="block w-full pr-12" type="password" name="password" required autocomplete="new-password" placeholder="Create a password" data-auth-password-input />
                <button type="button" class="auth-password-toggle" data-auth-password-toggle aria-label="Show password">
                    Show
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <div class="auth-password-wrap mt-2">
                <x-text-input id="password_confirmation" class="block w-full pr-12" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Repeat your password" data-auth-password-input />
                <button type="button" class="auth-password-toggle" data-auth-password-toggle aria-label="Show password confirmation">
                    Show
                </button>
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="mt-6">
            <x-primary-button class="w-full justify-center">
                {{ __('Register') }}
            </x-primary-button>
        </div>

        <div class="auth-form-footer">
            <span>Already have an account?</span>
            <a class="auth-inline-link" href="{{ route('login') }}">Log in</a>
        </div>
    </form>
</x-guest-layout>
