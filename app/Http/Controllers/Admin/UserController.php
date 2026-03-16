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
        $users = User::with(['wallet', 'upline' => fn($q) => $q->withTrashed()])->orderBy('created_at', 'desc')->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function show($id)
    {
        $user = User::withTrashed()->with(['wallet', 'investments', 'deposits', 'withdrawls', 'profile', 'upline', 'referrals'])->findOrFail($id);
        
        $stats = [
            'total_deposited' => $user->deposits()->where('status', 'approved')->sum('amount'),
            'total_withdrawn' => $user->withdrawls()->where('status', 'approved')->sum('amount'),
            'total_roi_earned' => \App\Models\ROIIncome::where('user_id', $user->id)->sum('roi_amount'),
            'total_commission_earned' => \App\Models\LevelCommission::where('user_id', $user->id)->sum('commission_amount'),
            'total_investments' => $user->investments()->count(),
            'active_investments' => $user->investments()->where('status', 'active')->count(),
            'total_investment_amount' => $user->investments()->sum('amount'),
            'roi_income_breakdown' => \App\Models\ROIIncome::where('user_id', $user->id)->orderBy('distributed_at', 'desc')->limit(5)->get(),
            'commission_breakdown' => \App\Models\LevelCommission::where('user_id', $user->id)->with('fromUser')->orderBy('created_at', 'desc')->limit(5)->get(),
            'direct_referrals' => $user->referrals()->count(),
            'total_team_size' => $user->mlmDescendants()->count(),
            'team_investment_volume' => Investment::whereIn('user_id', $user->mlmDescendants()->pluck('descendant_id'))->sum('amount'),
        ];

        // Combined Earnings Table
        $earnings = collect();
        foreach($stats['roi_income_breakdown'] as $roi) {
            $earnings->push((object)['type' => 'ROI', 'amount' => $roi->roi_amount, 'from' => 'System', 'id' => $roi->investment_id, 'date' => $roi->distributed_at]);
        }
        foreach($stats['commission_breakdown'] as $com) {
            $earnings->push((object)['type' => 'Level Commission', 'amount' => $com->commission_amount, 'from' => $com->fromUser->name ?? 'User', 'id' => null, 'date' => $com->created_at]);
        }
        $earnings = $earnings->sortByDesc('date');

        return view('admin.users.show', compact('user', 'stats', 'earnings'));
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
