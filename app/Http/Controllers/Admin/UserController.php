<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        return view('admin.users.index', ['users' => User::query()->latest()->paginate(15)]);
    }

    public function toggleAdmin(User $user): RedirectResponse
    {
        $user->update(['is_admin' => ! $user->is_admin]);

        return back()->with('success', 'User role updated.');
    }
}
