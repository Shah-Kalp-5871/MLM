<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LevelIncomeController extends Controller
{
    public function index()
    {
        $commissions = auth()->user()->levelCommissions()
            ->with(['roiIncome.investment.package', 'fromUser'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);
            
        return view('user.level-income.index', compact('commissions'));
    }
}
