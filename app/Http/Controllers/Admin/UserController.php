<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('wallet')->orderBy('created_at', 'desc')->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function show($id)
    {
        $user = User::with(['wallet', 'investments', 'deposits', 'withdrawls', 'profile'])->findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    public function updateStatus($id, Request $request)
    {
        $user = User::findOrFail($id);
        $user->update(['status' => $request->status]);
        
        return back()->with('success', 'User status updated.');
    }
}
