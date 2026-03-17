<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaymentMethodController extends Controller
{
    public function index()
    {
        $methods = PaymentMethod::all();
        return view('admin.payment-methods.index', compact('methods'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string',
            'qr_code' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'instructions' => 'nullable|string',
        ]);

        $path = $request->file('qr_code')->store('payment-qrs', 'public');

        PaymentMethod::create([
            'name' => $request->name,
            'type' => $request->type,
            'qr_code' => $path,
            'instructions' => $request->instructions,
        ]);

        return back()->with('success', 'Payment method added successfully.');
    }

    public function update(Request $request, $id)
    {
        $method = PaymentMethod::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string',
            'qr_code' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'instructions' => 'nullable|string',
            'is_active' => 'required|boolean',
        ]);

        $data = $request->only(['name', 'type', 'instructions', 'is_active']);

        if ($request->hasFile('qr_code')) {
            // Delete old one
            if ($method->qr_code) {
                Storage::disk('public')->delete($method->qr_code);
            }
            $data['qr_code'] = $request->file('qr_code')->store('payment-qrs', 'public');
        }

        $method->update($data);

        return back()->with('success', 'Payment method updated.');
    }

    public function destroy($id)
    {
        $method = PaymentMethod::findOrFail($id);
        if ($method->qr_code) {
            Storage::disk('public')->delete($method->qr_code);
        }
        $method->delete();

        return back()->with('success', 'Payment method deleted.');
    }
}
