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
        // Logic to update global settings (stored in DB or config)
        return back()->with('success', 'Settings updated successfully.');
    }
}
