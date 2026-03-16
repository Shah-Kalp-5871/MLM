<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WalletTransaction;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index()
    {
        $logs = WalletTransaction::with('user')->orderBy('created_at', 'desc')->paginate(50);
        return view('admin.activity-logs.index', compact('logs'));
    }
}
