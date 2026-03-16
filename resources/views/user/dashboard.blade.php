@extends('layouts.user')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold text-white tracking-tight">Welcome, Kalp</h1>
    <p class="text-xs text-gray-400 font-medium uppercase tracking-widest mt-1">Build your network and earn passive income</p>
</div>

<!-- Stat Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
    <div class="glass-panel p-6 rounded-2xl relative overflow-hidden group border-l-4 border-l-emerald-500">
        <div class="absolute inset-0 bg-gradient-to-r from-emerald-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
        <i data-lucide="wallet" class="w-8 h-8 text-emerald-400 mb-4 opacity-80"></i>
        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Wallet Balance</p>
        <h3 class="text-2xl font-black text-white">₹1,200.00</h3>
    </div>

    <div class="glass-panel p-6 rounded-2xl relative overflow-hidden group">
        <div class="absolute inset-0 bg-gradient-to-r from-purple-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
        <i data-lucide="trending-up" class="w-8 h-8 text-purple-400 mb-4 opacity-80"></i>
        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">ROI Income</p>
        <h3 class="text-2xl font-black text-white">₹120.00</h3>
    </div>

    <div class="glass-panel p-6 rounded-2xl relative overflow-hidden group">
        <div class="absolute inset-0 bg-gradient-to-r from-blue-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
        <i data-lucide="users" class="w-8 h-8 text-blue-400 mb-4 opacity-80"></i>
        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Level Income</p>
        <h3 class="text-2xl font-black text-white">₹85.00</h3>
    </div>

    <div class="glass-panel p-6 rounded-2xl relative overflow-hidden group border-amber-500/20">
        <div class="absolute inset-0 bg-gradient-to-r from-amber-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
        <i data-lucide="award" class="w-8 h-8 text-amber-500 mb-4 opacity-80"></i>
        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Club Rewards</p>
        <h3 class="text-2xl font-black text-white">₹500 Voucher</h3>
    </div>
</div>

<!-- Quick Actions -->
<div class="mb-10">
    <h2 class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-4">Quick Actions</h2>
    <div class="flex flex-wrap gap-4">
        <a href="/user/investments/create" class="px-6 py-3 rounded-xl bg-purple-600 hover:bg-purple-500 text-white text-xs font-bold uppercase tracking-wider transition-all shadow-lg shadow-purple-900/40 flex items-center gap-2"><i data-lucide="plus-circle" class="w-4 h-4"></i> Invest Now</a>
        <a href="/user/network" class="px-6 py-3 rounded-xl glass-panel text-white text-xs font-bold uppercase tracking-wider hover:bg-white/10 transition-all flex items-center gap-2"><i data-lucide="users" class="w-4 h-4"></i> View Network</a>
        <a href="/user/withdrawals/create" class="px-6 py-3 rounded-xl glass-panel text-white text-xs font-bold uppercase tracking-wider hover:bg-white/10 transition-all flex items-center gap-2"><i data-lucide="arrow-up-right" class="w-4 h-4"></i> Withdraw</a>
        <a href="/user/referrals" class="px-6 py-3 rounded-xl glass-panel text-white text-xs font-bold uppercase tracking-wider hover:bg-white/10 transition-all flex items-center gap-2"><i data-lucide="user-plus" class="w-4 h-4"></i> Invite Friends</a>
    </div>
</div>

<!-- Recent Earnings -->
<div class="glass-panel rounded-2xl overflow-hidden">
    <div class="p-6 border-b border-white/5 flex justify-between items-center bg-white/[0.02]">
        <h2 class="text-sm font-bold text-white uppercase tracking-wider">Recent Earnings</h2>
        <a href="/user/earnings" class="text-xs font-bold text-purple-400 hover:text-white transition-colors uppercase tracking-widest">View All</a>
    </div>
    <div class="table-wrapper p-4">
        <table>
            <thead>
                <tr>
                    <th>Type</th>
                    <th>Amount</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="font-medium text-white"><span class="px-2 py-1 rounded bg-purple-500/20 text-purple-400 text-[10px] uppercase font-bold mr-2">ROI</span> ROI Income</td>
                    <td class="text-emerald-400 font-bold">+ ₹50.00</td>
                    <td class="text-xs">12 Mar 2026</td>
                </tr>
                <tr>
                    <td class="font-medium text-white"><span class="px-2 py-1 rounded bg-blue-500/20 text-blue-400 text-[10px] uppercase font-bold mr-2">LVL</span> Level Income</td>
                    <td class="text-emerald-400 font-bold">+ ₹20.00</td>
                    <td class="text-xs">10 Mar 2026</td>
                </tr>
            </tbody>
        </table>
    </div>
    
    <!-- Static Pagination Example -->
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