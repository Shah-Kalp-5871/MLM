@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight">Voucher Management</h1>
            <p class="text-slate-400 text-sm">Issue and track non-withdrawable club vouchers.</p>
        </div>
        <div class="flex items-center gap-3">
             <button class="btn-gradient px-6 py-2 rounded-xl text-sm font-bold shadow-lg shadow-purple-600/10 flex items-center gap-2">
                <i data-lucide="plus" class="w-4 h-4"></i> Generate Voucher
            </button>
        </div>
    </div>

    <!-- Voucher Inventory -->
    <div class="glass rounded-3xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-[#0c0c0c] text-slate-500 uppercase text-[10px] font-bold">
                    <tr>
                        <th class="px-6 py-4">Voucher Code</th>
                        <th class="px-6 py-4">Value</th>
                        <th class="px-6 py-4">Assigned To</th>
                        <th class="px-6 py-4">Type</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Created</th>
                        <th class="px-6 py-4 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#1f1f1f]">
                    <tr>
                        <td class="px-6 py-4 font-mono text-purple-400 font-bold">CLUB-500X-Z92</td>
                        <td class="px-6 py-4 font-bold text-slate-200">₹500.00</td>
                        <td class="px-6 py-4 text-slate-400">Sneha Gupta</td>
                        <td class="px-6 py-4"><span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Milestone Reward</span></td>
                        <td class="px-6 py-4">
                            <span class="badge-pending text-[10px] px-2 py-0.5 rounded-full uppercase font-bold">Unused</span>
                        </td>
                        <td class="px-6 py-4 text-xs text-slate-400">1 hour ago</td>
                        <td class="px-6 py-4 text-right">
                            <button class="text-slate-500 hover:text-red-500 transition-all">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection