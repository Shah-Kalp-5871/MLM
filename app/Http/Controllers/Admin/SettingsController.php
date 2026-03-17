<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function settings()
    {
        return view('admin.settings.index');
    }

    public function update(Request $request)
    {
        $data = $request->except('_token');
        
        $min = (float) \App\Models\Setting::get('roi_min_percentage', 3.0);
        $max = (float) \App\Models\Setting::get('roi_max_percentage', 3.5);

        foreach ($data as $key => $value) {
            if ($key === 'weekly_roi_percentage') {
                if (!is_numeric($value) || $value < $min || $value > $max) {
                    return back()->with('error', "Weekly ROI Percentage must be between {$min} and {$max}");
                }
            }
            \App\Models\Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        // Clear view cache or optimize if needed to reflect global share changes
        return back()->with('success', 'Settings updated successfully.');
    }
}
