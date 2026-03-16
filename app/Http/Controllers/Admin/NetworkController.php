<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class NetworkController extends Controller
{
    public function index()
    {
        // Get root-level users (those not referred by anyone)
        $rootUsers = User::whereNull('upline_id')->with('referrals')->get();
        return view('admin.network.index', compact('rootUsers'));
    }
}
