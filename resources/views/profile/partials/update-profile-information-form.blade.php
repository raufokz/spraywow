<section>
    <header class="profile-panel-head">
        <div>
            <p class="dashboard-section-kicker">Profile Details</p>
            <h2 class="dashboard-section-title">Update profile information</h2>
            <p class="mt-2 text-sm leading-7 text-slate-500">Keep your personal details current so orders, receipts, and account access stay smooth.</p>
        </div>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="admin-product-form mt-6">
        @csrf
        @method('patch')

        <div class="admin-form-field">
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-2 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" placeholder="Your full name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div class="admin-form-field">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-2 block w-full" :value="old('email', $user->email)" required autocomplete="username" placeholder="you@example.com" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-3 rounded-[18px] border border-amber-100 bg-amber-50 px-4 py-3 text-sm text-amber-800">
                    <p>
                        {{ __('Your email address is unverified.') }}
                        <button form="send-verification" class="ml-1 font-semibold underline underline-offset-2">
                            {{ __('Resend verification email') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-emerald-700">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="admin-form-field admin-form-field-full">
            <div class="admin-form-actions">
                <x-primary-button>{{ __('Update Profile') }}</x-primary-button>

                @if (session('status') === 'profile-updated')
                    <p
                        x-data="{ show: true }"
                        x-show="show"
                        x-transition
                        x-init="setTimeout(() => show = false, 2000)"
                        class="text-sm font-medium text-emerald-700"
                    >{{ __('Profile updated.') }}</p>
                @endif
            </div>
        </div>
    </form>
</section>
