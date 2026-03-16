<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class NetworkController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $rootUser = null;

        if ($search) {
            $rootUser = User::where('email', $search)
                ->orWhere('referral_code', $search)
                ->with('referrals')
                ->first();
        } else {
            // Default to the first user with no upline (usually the admin/master node)
            $rootUser = User::whereNull('upline_id')->with('referrals')->first();
        }

        return view('admin.network.tree', compact('rootUser'));
    }
}
