@extends('layouts.user')

@section('content')
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
    <div>
        <h1 class="text-2xl font-bold text-white tracking-tight">Withdrawals</h1>
        <p class="text-xs text-gray-500 font-medium uppercase tracking-widest mt-1">Cash out your earnings</p>
    </div>
    <a href="/user/withdrawals/create" class="w-full sm:w-auto px-8 py-3 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white text-xs font-bold uppercase tracking-wider transition-all shadow-lg shadow-emerald-900/40 text-center">Request Withdrawal</a>
</div>

<!-- Special Note on Vouchers -->
<div class="glass-panel p-4 rounded-xl mb-8 border border-amber-500/20 bg-amber-500/5 flex items-start gap-4">
    <div class="w-10 h-10 rounded-lg bg-amber-500/10 flex items-center justify-center flex-shrink-0">
        <i data-lucide="alert-triangle" class="w-5 h-5 text-amber-500"></i>
    </div>
    <div>
        <h4 class="text-xs font-bold text-white uppercase tracking-wider mb-1">Notice: Club Vouchers</h4>
        <p class="text-[11px] text-gray-400">Club Milestone rewards are issued as vouchers for platform reinvestment and purchases. Unlike ROI or Level Income, <span class="text-amber-500 font-bold">vouchers cannot be withdrawn as cash.</span></p>
    </div>
</div>

<div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
    <div class="glass-panel p-6 rounded-2xl bg-[#0a0f18] border border-emerald-500/20">
        <p class="text-[10px] font-bold text-emerald-400 uppercase tracking-widest mb-1">Available to Withdraw</p>
        <h3 class="text-2xl font-black text-white">₹1,200.00</h3>
    </div>
    <div class="glass-panel p-6 rounded-2xl border-l-[3px] border-emerald-500">
        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Total Withdrawn</p>
        <h3 class="text-2xl font-black text-white">₹50.00</h3>
    </div>
    <div class="glass-panel p-6 rounded-2xl border-l-[3px] border-amber-500">
        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Pending Amount</p>
        <h3 class="text-2xl font-black text-white">₹0.00</h3>
    </div>
</div>

<div class="glass-panel rounded-2xl overflow-hidden">
    <div class="p-6 border-b border-white/5 bg-white/[0.02]">
        <h2 class="text-sm font-bold text-white uppercase tracking-wider">Withdrawal History</h2>
    </div>
    <div class="table-wrapper p-4">
        <table>
            <thead>
                <tr>
                    <th>Amount</th>
                    <th>Method</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="font-bold text-white font-mono">₹50.00</td>
                    <td>Bank Transfer (Ending 4512)</td>
                    <td><span class="px-3 py-1 bg-emerald-500/20 text-emerald-400 text-[10px] font-bold uppercase rounded-full">Completed</span></td>
                    <td class="text-xs text-gray-500">08 Mar 2026</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="p-4 border-t border-white/5 flex justify-center bg-white/[0.01]">
        <div class="pagination">
            <a href="#">&laquo; Prev</a>
            <a href="#" class="active">1</a>
            <a href="#">Next &raquo;</a>
        </div>
    </div>
</div>
@endsection