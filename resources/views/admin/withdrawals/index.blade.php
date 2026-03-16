@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight">Withdrawal Requests</h1>
            <p class="text-slate-400 text-sm">Approve and track payout requests efficiently.</p>
        </div>
        <div class="flex items-center gap-3">
             <button class="bg-[#121212] border border-[#1f1f1f] px-4 py-2 rounded-xl text-sm font-medium hover:border-slate-700 transition-all flex items-center gap-2">
                <i data-lucide="download" class="w-4 h-4"></i> Export Batch
            </button>
        </div>
    </div>

    <!-- Active Requests -->
    <div class="glass rounded-3xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-[#0c0c0c] text-slate-500 uppercase text-[10px] font-bold">
                    <tr>
                        <th class="px-6 py-4">User</th>
                        <th class="px-6 py-4">Wallet Balance</th>
                        <th class="px-6 py-4">Request Amount</th>
                        <th class="px-6 py-4">Fee (5%)</th>
                        <th class="px-6 py-4">Net Payout</th>
                        <th class="px-6 py-4">Method</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#1f1f1f]">
                    <!-- Row 1 -->
                    <tr class="hover:bg-white/[0.02] transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <span class="font-medium text-slate-200">Rahul Kumar</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-slate-400">₹1,240</td>
                        <td class="px-6 py-4 font-bold">₹500.00</td>
                        <td class="px-6 py-4 text-red-500/70">₹25.00</td>
                        <td class="px-6 py-4 text-green-400">₹475.00</td>
                        <td class="px-6 py-4">
                            <span class="text-xs text-slate-500 bg-slate-800/10 px-2 py-1 rounded border border-[#1f1f1f]">Bank Transfer</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="badge-pending text-[10px] px-2 py-0.5 rounded-full uppercase font-bold">Pending</span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <button class="text-purple-500 hover:text-purple-400 font-bold text-xs uppercase tracking-wider underline">Mark as Paid</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection