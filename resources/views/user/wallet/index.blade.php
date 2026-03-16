@extends('layouts.user')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold text-white tracking-tight">Wallet</h1>
    <p class="text-xs text-gray-500 font-medium uppercase tracking-widest mt-1">Transaction History</p>
</div>

<div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
    <div class="glass-panel p-8 rounded-2xl relative overflow-hidden group border-l-[6px] border-l-emerald-500">
        <div class="absolute right-0 top-0 w-32 h-32 bg-emerald-500/10 rounded-full blur-[40px] pointer-events-none"></div>
        <p class="text-[10px] font-bold text-emerald-400 uppercase tracking-widest mb-2">Available Balance</p>
        <h3 class="text-4xl font-black text-white">₹1,200.00</h3>
        <p class="text-[10px] text-gray-500 mt-2 font-medium uppercase tracking-widest">Withdrawal Profit (ROI + Level)</p>
    </div>
    <div class="glass-panel p-8 rounded-2xl">
        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Total Earnings</p>
        <h3 class="text-3xl font-bold text-gray-300">₹1,250.00</h3>
    </div>
    <div class="glass-panel p-8 rounded-2xl">
        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Total Withdrawn</p>
        <h3 class="text-3xl font-bold text-gray-300">₹50.00</h3>
    </div>
</div>

<div class="glass-panel p-4 rounded-xl mb-8 border border-purple-500/20 bg-purple-500/5 flex items-start gap-4">
    <div class="w-10 h-10 rounded-lg bg-purple-500/10 flex items-center justify-center flex-shrink-0">
        <i data-lucide="info" class="w-5 h-5 text-purple-400"></i>
    </div>
    <div>
        <h4 class="text-xs font-bold text-white uppercase tracking-wider mb-1">Quick Note</h4>
        <p class="text-[11px] text-gray-400 leading-relaxed">Your wallet balance consists of weekly ROI and Level Commissions. Club Milestone Rewards are kept in your <a href="/user/club-rewards" class="text-amber-500 hover:underline">Voucher Wallet</a>.</p>
    </div>
</div>

<div class="glass-panel rounded-2xl overflow-hidden mb-10">
    <div class="p-6 border-b border-white/5 bg-white/[0.02]">
        <h2 class="text-sm font-bold text-white uppercase tracking-wider">Wallet Transactions</h2>
    </div>
    <div class="table-wrapper p-4">
        <table>
            <thead>
                <tr>
                    <th>Type</th>
                    <th>Amount</th>
                    <th>Description</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><span class="px-3 py-1 bg-emerald-500/20 text-emerald-400 text-[10px] font-bold uppercase rounded-full">ROI</span></td>
                    <td class="text-emerald-400 font-bold font-mono">+ ₹50.00</td>
                    <td class="text-white">Weekly ROI (3%)</td>
                    <td class="text-xs text-gray-500">12 Mar 2026</td>
                </tr>
                <tr>
                    <td><span class="px-3 py-1 bg-purple-500/20 text-purple-400 text-[10px] font-bold uppercase rounded-full">Level</span></td>
                    <td class="text-emerald-400 font-bold font-mono">+ ₹20.00</td>
                    <td class="text-white">Level 1 Commission</td>
                    <td class="text-xs text-gray-500">10 Mar 2026</td>
                </tr>
                <tr>
                    <td><span class="px-3 py-1 bg-rose-500/20 text-rose-400 text-[10px] font-bold uppercase rounded-full">Withdrawal</span></td>
                    <td class="text-rose-400 font-bold font-mono">- ₹50.00</td>
                    <td class="text-white">Bank Transfer (Completed)</td>
                    <td class="text-xs text-gray-500">08 Mar 2026</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="p-4 border-t border-white/5 flex justify-center bg-white/[0.01]">
        <div class="pagination">
            <a href="#">&laquo; Prev</a>
            <a href="#" class="active">1</a>
            <a href="#">2</a>
            <a href="#">3</a>
            <a href="#">Next &raquo;</a>
        </div>
    </div>
</div>

@endsection