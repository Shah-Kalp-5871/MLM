<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClubMilestone;
use Illuminate\Http\Request;

class ClubMilestoneController extends Controller
{
    public function index()
    {
        $milestones = ClubMilestone::orderBy('tier')->get();
        return view('admin.club-milestones.index', compact('milestones'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tier' => 'required|integer|unique:club_milestones',
            'name' => 'required|string',
            'direct_business_target' => 'required|numeric',
            'team_business_target' => 'required|numeric',
            'voucher_value' => 'required|numeric',
        ]);

        ClubMilestone::create($request->all());

        return back()->with('success', 'Milestone added successfully.');
    }

    public function update(Request $request, $id)
    {
        $milestone = ClubMilestone::findOrFail($id);
        $milestone->update($request->all());

        return back()->with('success', 'Milestone updated successfully.');
    }
}
