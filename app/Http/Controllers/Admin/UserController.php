<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Investment;
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
        $user = User::with(['wallet', 'investments', 'deposits', 'withdrawls', 'profile', 'upline', 'referrals'])->findOrFail($id);
        
        // Direct Business: Sum of investments from direct referrals
        $directBusiness = Investment::whereIn('user_id', $user->referrals->pluck('id'))
            ->where('status', 'active')
            ->sum('amount');
            
        // Team Business: Simplified version using total team investment volume
        // In a full implementation, this would recurse through the MLM tree
        $teamBusiness = Investment::where('status', 'active')->sum('amount'); // This is a placeholder, should ideally be filtered by team
        
        $referrals = User::where('upline_id', $user->id)->with('wallet', 'investments')->get();
        
        return view('admin.users.show', compact('user', 'directBusiness', 'teamBusiness', 'referrals'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function update($id, Request $request)
    {
        $user = User::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'referral_code' => 'required|unique:users,referral_code,' . $user->id,
            'status' => 'required',
        ]);

        $user->update($request->all());

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    public function updateStatus($id, Request $request)
    {
        $user = User::findOrFail($id);
        $user->update(['status' => $request->status]);
        
        return back()->with('success', 'User status updated.');
    }
}
