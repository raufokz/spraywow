<section>
    <header class="profile-panel-head">
        <div>
            <p class="dashboard-section-kicker">Security</p>
            <h2 class="dashboard-section-title">Change password</h2>
            <p class="mt-2 text-sm leading-7 text-slate-500">Use a strong password to keep your SprayWow account secure across devices.</p>
        </div>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="admin-product-form mt-6">
        @csrf
        @method('put')

        <div class="admin-form-field admin-form-field-full">
            <x-input-label for="update_password_current_password" :value="__('Current Password')" />
            <div class="auth-password-wrap mt-2">
                <x-text-input id="update_password_current_password" name="current_password" type="password" class="block w-full pr-12" autocomplete="current-password" placeholder="Current password" data-auth-password-input />
                <button type="button" class="auth-password-toggle" data-auth-password-toggle aria-label="Show current password">Show</button>
            </div>
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div class="admin-form-field">
            <x-input-label for="update_password_password" :value="__('New Password')" />
            <div class="auth-password-wrap mt-2">
                <x-text-input id="update_password_password" name="password" type="password" class="block w-full pr-12" autocomplete="new-password" placeholder="New password" data-auth-password-input />
                <button type="button" class="auth-password-toggle" data-auth-password-toggle aria-label="Show new password">Show</button>
            </div>
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div class="admin-form-field">
            <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" />
            <div class="auth-password-wrap mt-2">
                <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="block w-full pr-12" autocomplete="new-password" placeholder="Confirm new password" data-auth-password-input />
                <button type="button" class="auth-password-toggle" data-auth-password-toggle aria-label="Show password confirmation">Show</button>
            </div>
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="admin-form-field admin-form-field-full">
            <div class="admin-form-actions">
                <x-primary-button>{{ __('Change Password') }}</x-primary-button>

                @if (session('status') === 'password-updated')
                    <p
                        x-data="{ show: true }"
                        x-show="show"
                        x-transition
                        x-init="setTimeout(() => show = false, 2000)"
                        class="text-sm font-medium text-emerald-700"
                    >{{ __('Password updated.') }}</p>
                @endif
            </div>
        </div>
    </form>
</section>
