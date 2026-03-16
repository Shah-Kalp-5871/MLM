<?php
$viewsDir = __DIR__ . '/resources/views';

function makeView($path, $content) {
    $dir = dirname($path);
    if (!is_dir($dir)) mkdir($dir, 0777, true);
    file_put_contents($path, $content);
}

// ---------------------------------------------------------
// EARNINGS (Combined ROI & Level)
// ---------------------------------------------------------
$earningsIndex = <<<'HTML'
@extends('layouts.user')

@section('content')
<div class="mb-8 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold text-white tracking-tight">My Earnings</h1>
        <p class="text-xs text-gray-500 font-medium uppercase tracking-widest mt-1">ROI and Referral Income</p>
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
HTML;
makeView($viewsDir . '/user/earnings.blade.php', $earningsIndex);

// ---------------------------------------------------------
// WALLET
// ---------------------------------------------------------
$walletIndex = <<<'HTML'
@extends('layouts.user')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold text-white tracking-tight">Wallet</h1>
    <p class="text-xs text-gray-500 font-medium uppercase tracking-widest mt-1">Transaction History</p>
</div>

<div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
    <div class="glass-panel p-8 rounded-2xl relative overflow-hidden group border-l-[6px] border-l-emerald-500">
        <div class="absolute right-0 top-0 w-32 h-32 bg-emerald-500/10 rounded-full blur-[40px] pointer-events-none"></div>
        <p class="text-[10px] font-bold text-emerald-400 uppercase tracking-widest mb-2">Current Balance</p>
        <h3 class="text-4xl font-black text-white">₹1,200.00</h3>
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
HTML;
makeView($viewsDir . '/user/wallet/index.blade.php', $walletIndex);

// ---------------------------------------------------------
// WITHDRAWALS
// ---------------------------------------------------------
$withdrawalsIndex = <<<'HTML'
@extends('layouts.user')

@section('content')
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
    <div>
        <h1 class="text-2xl font-bold text-white tracking-tight">Withdrawals</h1>
        <p class="text-xs text-gray-500 font-medium uppercase tracking-widest mt-1">Cash out your earnings</p>
    </div>
    <a href="/user/withdrawals/create" class="w-full sm:w-auto px-8 py-3 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white text-xs font-bold uppercase tracking-wider transition-all shadow-lg shadow-emerald-900/40 text-center">Request Withdrawal</a>
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
HTML;
makeView($viewsDir . '/user/withdrawals/index.blade.php', $withdrawalsIndex);

echo "Part 3 views generated.\n";
