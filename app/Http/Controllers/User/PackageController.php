<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::where('status', 'active')->orderBy('price', 'asc')->get();
        return view('user.investments.create', compact('packages'));
    }
}
