<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use App\Models\User;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    public function index()
    {
        $vouchers = Voucher::with('assignedUser')->paginate(20);
        return view('admin.vouchers.index', compact('vouchers'));
    }

    public function create()
    {
        $users = User::all();
        return view('admin.vouchers.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'nullable|unique:vouchers,code',
            'value' => 'required|numeric',
            'type' => 'required',
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        $data = $request->all();
        if (empty($data['code'])) {
            $data['code'] = 'VOX-' . strtoupper(bin2hex(random_bytes(4)));
        }
        
        $data['status'] = 'unused';
        $data['is_used'] = false;

        Voucher::create($data);

        return redirect()->route('admin.vouchers.index')->with('success', 'Voucher created successfully.');
    }
}
