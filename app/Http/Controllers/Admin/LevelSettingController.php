<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LevelSetting;
use Illuminate\Http\Request;

class LevelSettingController extends Controller
{
    public function index()
    {
        $levels = LevelSetting::orderBy('level')->get();
        return view('admin.level-settings.index', compact('levels'));
    }

    public function update(Request $request)
    {
        // Simple update logic for all levels at once or individually in a real app
        // Here we assume a bulk update for demo alignment
        if ($request->has('levels')) {
            foreach ($request->levels as $id => $data) {
                LevelSetting::where('id', $id)->update([
                    'percentage' => $data['percentage'],
                    'label' => $data['label'],
                ]);
            }
        }

        return back()->with('success', 'Level settings updated successfully.');
    }
}
