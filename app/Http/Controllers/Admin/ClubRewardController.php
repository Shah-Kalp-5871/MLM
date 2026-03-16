<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClubQualification;
use Illuminate\Http\Request;

class ClubRewardController extends Controller
{
    public function index()
    {
        $qualifications = ClubQualification::with('user')->orderBy('current_tier', 'desc')->paginate(20);
        return view('admin.club.index', compact('qualifications'));
    }
}
