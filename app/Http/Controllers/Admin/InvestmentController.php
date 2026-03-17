<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Investment;
use Illuminate\Http\Request;

class InvestmentController extends Controller
{
    public function index()
    {
        $investments = Investment::with(['user'])->orderBy('created_at', 'desc')->paginate(20);
        return view('admin.investments.index', compact('investments'));
    }
}
