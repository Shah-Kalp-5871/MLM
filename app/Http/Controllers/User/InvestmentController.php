<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InvestmentController extends Controller
{
    public function index()
    {
        $investments = auth()->user()->investments()->with('package')->orderBy('created_at', 'desc')->paginate(10);
        return view('user.investments.index', compact('investments'));
    }

    public function create()
    {
        $packages = \App\Models\Package::where('status', 'active')->orderBy('price', 'asc')->get();
        return view('user.investments.create', compact('packages'));
    }
}
