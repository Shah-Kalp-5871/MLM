@extends('layouts.user')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold text-white tracking-tight">My Earnings</h1>
    <p class="text-xs text-gray-500 font-medium uppercase tracking-widest mt-1">ROI and Referral Income</p>
</div>

<!-- Earning Concepts -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <div class="glass-panel p-5 rounded-2xl border border-emerald-500/20">
        <h3 class="text-xs font-bold text-emerald-400 uppercase tracking-widest mb-2">Passive ROI Income</h3>
        <p class="text-xs text-gray-400 leading-relaxed">
            ROI (Return on Investment) is profit generated automatically from your own active packages. 
            Paid <span class="text-white font-bold">weekly (3% – 3.5%)</span> directly into your wallet.
        </p>
    </div>
    <div class="glass-panel p-5 rounded-2xl border border-purple-500/20">
        <h3 class="text-xs font-bold text-purple-400 uppercase tracking-widest mb-2">Network Level Income</h3>
        <p class="text-xs text-gray-400 leading-relaxed">
            Earned when someone in your 15-level network receives their ROI. 
            You receive a <span class="text-white font-bold">percentage (up to 20%)</span> of their weekly profit.
        </p>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
    <div class="glass-panel p-6 rounded-2xl relative overflow-hidden group">
        <div class="absolute inset-0 bg-gradient-to-r from-emerald-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
        <p class="text-[10px] font-bold text-emerald-400 uppercase tracking-widest mb-1">ROI Income</p>
        <h3 class="text-3xl font-black text-white">₹800.00</h3>
        <p class="text-[10px] text-gray-500 mt-2">Returns from active investments</p>
    </div>
    <div class="glass-panel p-6 rounded-2xl relative overflow-hidden group border border-purple-500/30">
        <div class="absolute inset-0 bg-gradient-to-r from-purple-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
        <p class="text-[10px] font-bold text-purple-400 uppercase tracking-widest mb-1">Level Income</p>
        <h3 class="text-3xl font-black text-white">₹450.00</h3>
        <p class="text-[10px] text-gray-500 mt-2">Commissions from network ROI</p>
    </div>
    <div class="glass-panel p-6 rounded-2xl bg-[#0a0f18] border border-blue-500/20 shadow-[0_0_30px_rgba(59,130,246,0.1)]">
        <p class="text-[10px] font-bold text-blue-400 uppercase tracking-widest mb-1">Total Earnings</p>
        <h3 class="text-3xl font-black text-white">₹1,250.00</h3>
        <p class="text-[10px] text-gray-500 mt-2">Available in Wallet</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-10">
    <!-- ROI Table -->
    <div class="glass-panel rounded-2xl overflow-hidden flex flex-col">
        <div class="p-5 border-b border-white/5 bg-white/[0.02]">
            <h2 class="text-sm font-bold text-white uppercase tracking-wider"><i data-lucide="bar-chart" class="w-4 h-4 inline-block -mt-1 text-emerald-400 mr-2"></i> ROI History</h2>
        </div>
        <div class="table-wrapper flex-1 p-4">
            <table>
                <thead>
                    <tr>
                        <th>Week</th>
                        <th>ROI %</th>
                        <th>Amount</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Week 1</td>
                        <td>3%</td>
                        <td class="text-emerald-400 font-bold">+₹15.00</td>
                        <td class="text-xs text-gray-400">12 Mar 2026</td>
                    </tr>
                    <tr>
                        <td>Week 2</td>
                        <td>3%</td>
                        <td class="text-emerald-400 font-bold">+₹15.00</td>
                        <td class="text-xs text-gray-400">19 Mar 2026</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="p-3 border-t border-white/5 flex justify-center bg-white/[0.01]">
            <div class="pagination scale-90">
                <a href="#">&laquo; Prev</a>
                <a href="#" class="active">1</a>
                <a href="#">Next &raquo;</a>
            </div>
        </div>
    </div>

    <!-- Level Income Table -->
    <div class="glass-panel rounded-2xl overflow-hidden flex flex-col">
        <div class="p-5 border-b border-white/5 bg-white/[0.02]">
            <h2 class="text-sm font-bold text-white uppercase tracking-wider"><i data-lucide="users" class="w-4 h-4 inline-block -mt-1 text-purple-400 mr-2"></i> Level Commissions</h2>
        </div>
        <div class="table-wrapper flex-1 p-4">
            <table>
                <thead>
                    <tr>
                        <th>From User</th>
                        <th>Level</th>
                        <th>Commission</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="font-bold text-white">Rahul</td>
                        <td><span class="px-2 py-1 bg-white/10 rounded text-[10px] font-bold uppercase text-purple-400">Level 1 (20%)</span></td>
                        <td class="text-emerald-400 font-bold">+₹3.00</td>
                        <td class="text-xs text-gray-400">10 Mar 2026</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="p-3 border-t border-white/5 flex justify-center bg-white/[0.01]">
            <div class="pagination scale-90">
                <a href="#">&laquo; Prev</a>
                <a href="#" class="active">1</a>
                <a href="#">Next &raquo;</a>
            </div>
        </div>
    </div>
</div>
@endsection