<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LevelCommission;
use Illuminate\Http\Request;

class LevelCommissionController extends Controller
{
    public function index()
    {
        $commissions = LevelCommission::with(['receiver', 'roiIncome.investment.user'])
            ->orderBy('distributed_at', 'desc')
            ->paginate(20);
            
        return view('admin.level-income.index', compact('commissions'));
    }
}
