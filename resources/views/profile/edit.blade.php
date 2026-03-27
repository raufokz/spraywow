@extends('account.layout')

@section('title', 'Profile')
@section('kicker', 'Account Settings')
@section('heading', 'Profile')

@section('header_actions')
    <a href="#profile-details" class="btn-secondary !px-4 !py-2">Update Profile</a>
    <a href="#password-panel" class="btn-primary">Change Password</a>
@endsection

@section('content')
    <div class="profile-shell">
        <section class="dashboard-panel profile-summary-card">
            <div class="profile-summary-top">
                <div class="profile-avatar">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div>
                    <p class="dashboard-section-kicker">Profile Overview</p>
                    <h2 class="dashboard-section-title">{{ $user->name }}</h2>
                    <p class="mt-2 text-sm text-slate-500">Manage your personal details, password, and account access from one place.</p>
                </div>
            </div>

            <div class="profile-detail-grid mt-6">
                <div class="profile-detail-card">
                    <span class="profile-detail-label">Email</span>
                    <span class="profile-detail-value">{{ $user->email }}</span>
                </div>
                <div class="profile-detail-card">
                    <span class="profile-detail-label">Phone</span>
                    <span class="profile-detail-value">{{ $user->phone ?: 'Not added yet' }}</span>
                </div>
                <div class="profile-detail-card">
                    <span class="profile-detail-label">Role</span>
                    <span class="profile-detail-value">{{ $user->is_admin ? 'Administrator' : 'Customer' }}</span>
                </div>
                <div class="profile-detail-card">
                    <span class="profile-detail-label">Member since</span>
                    <span class="profile-detail-value">{{ optional($user->created_at)->format('M d, Y') }}</span>
                </div>
            </div>
        </section>

        <section class="dashboard-panel" id="profile-details">
            @include('profile.partials.update-profile-information-form')
        </section>

        <section class="dashboard-panel" id="password-panel">
            @include('profile.partials.update-password-form')
        </section>

        <section class="dashboard-panel profile-danger-panel">
            @include('profile.partials.delete-user-form')
        </section>
    </div>
@endsection
