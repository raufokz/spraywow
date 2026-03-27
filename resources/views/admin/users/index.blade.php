@extends('admin.layout')

@section('title', 'Customers')
@section('kicker', 'Customer Management')
@section('heading', 'Customers')

@section('content')
    <section class="dashboard-panel">
        <div class="dashboard-panel-head">
            <div>
                <p class="dashboard-section-kicker">User Directory</p>
                <h2 class="dashboard-section-title">Manage customers and admins</h2>
            </div>
        </div>

        <div class="dashboard-table-wrap mt-6">
            <table class="dashboard-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td class="font-semibold text-slate-950">{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td><span class="dashboard-status-badge {{ $user->is_admin ? 'status-processing' : 'status-delivered' }}">{{ $user->is_admin ? 'Admin' : 'Customer' }}</span></td>
                            <td>
                                <form method="POST" action="{{ route('admin.users.toggle-admin', $user) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button class="text-sm font-semibold text-sky-700">{{ $user->is_admin ? 'Revoke admin' : 'Make admin' }}</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6">{{ $users->links() }}</div>
    </section>
@endsection
