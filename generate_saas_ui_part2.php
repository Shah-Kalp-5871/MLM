<?php
$viewsDir = __DIR__ . '/resources/views';

// Helper to write a file
function makeView($path, $content) {
    $dir = dirname($path);
    if (!is_dir($dir)) mkdir($dir, 0777, true);
    file_put_contents($path, $content);
}

// ---------------------------------------------------------
// DASHBOARD
// ---------------------------------------------------------
$dashboard = <<<'HTML'
@extends('layouts.user')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold text-white tracking-tight">Welcome, Kalp Shah</h1>
    <p class="text-xs text-gray-500 font-medium uppercase tracking-widest mt-1">Your account overview</p>
</div>

<!-- Stat Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
    <div class="glass-panel p-6 rounded-2xl relative overflow-hidden group">
        <div class="absolute inset-0 bg-gradient-to-r from-purple-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
        <i data-lucide="briefcase" class="w-8 h-8 text-purple-400 mb-4 opacity-80"></i>
        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Total Investment</p>
        <h3 class="text-2xl font-black text-white">₹5,000.00</h3>
    </div>
    
    <div class="glass-panel p-6 rounded-2xl relative overflow-hidden group">
        <div class="absolute inset-0 bg-gradient-to-r from-emerald-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
        <i data-lucide="wallet" class="w-8 h-8 text-emerald-400 mb-4 opacity-80"></i>
        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Wallet Balance</p>
        <h3 class="text-2xl font-black text-white">₹1,200.00</h3>
    </div>

    <div class="glass-panel p-6 rounded-2xl relative overflow-hidden group">
        <div class="absolute inset-0 bg-gradient-to-r from-amber-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
        <i data-lucide="trending-up" class="w-8 h-8 text-amber-400 mb-4 opacity-80"></i>
        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Total ROI Earned</p>
        <h3 class="text-2xl font-black text-white">₹800.00</h3>
    </div>

    <div class="glass-panel p-6 rounded-2xl relative overflow-hidden group">
        <div class="absolute inset-0 bg-gradient-to-r from-blue-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
        <i data-lucide="users" class="w-8 h-8 text-blue-400 mb-4 opacity-80"></i>
        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Level Income</p>
        <h3 class="text-2xl font-black text-white">₹450.00</h3>
    </div>
</div>

<!-- Quick Actions -->
<div class="mb-10">
    <h2 class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-4">Quick Actions</h2>
    <div class="flex flex-wrap gap-4">
        <a href="/user/investments/create" class="px-6 py-3 rounded-xl bg-purple-600 hover:bg-purple-500 text-white text-xs font-bold uppercase tracking-wider transition-all shadow-lg shadow-purple-900/40 flex items-center gap-2"><i data-lucide="plus-circle" class="w-4 h-4"></i> Invest Now</a>
        <a href="/user/withdrawals/create" class="px-6 py-3 rounded-xl glass-panel text-white text-xs font-bold uppercase tracking-wider hover:bg-white/10 transition-all flex items-center gap-2"><i data-lucide="arrow-up-right" class="w-4 h-4"></i> Withdraw</a>
        <a href="/user/network" class="px-6 py-3 rounded-xl glass-panel text-white text-xs font-bold uppercase tracking-wider hover:bg-white/10 transition-all flex items-center gap-2"><i data-lucide="git-branch" class="w-4 h-4"></i> View Network</a>
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
HTML;
makeView($viewsDir . '/user/dashboard.blade.php', $dashboard);

// ---------------------------------------------------------
// INVESTMENTS
// ---------------------------------------------------------
$investmentsIndex = <<<'HTML'
@extends('layouts.user')

@section('content')
<div class="flex justify-between items-center mb-8">
    <div>
        <h1 class="text-2xl font-bold text-white tracking-tight">Investments</h1>
        <p class="text-xs text-gray-500 font-medium uppercase tracking-widest mt-1">Manage your active plans</p>
    </div>
    <a href="/user/investments/create" class="px-6 py-3 rounded-xl bg-purple-600 hover:bg-purple-500 text-white text-xs font-bold uppercase tracking-wider transition-all shadow-lg shadow-purple-900/40 flex items-center gap-2"><i data-lucide="plus" class="w-4 h-4"></i> Invest Now</a>
</div>

<div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
    <div class="glass-panel p-6 rounded-2xl border-l-4 border-l-purple-500">
        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Total Investment</p>
        <h3 class="text-2xl font-black text-white">₹5,000.00</h3>
    </div>
    <div class="glass-panel p-6 rounded-2xl border-l-4 border-l-emerald-500">
        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Active Investments</p>
        <h3 class="text-2xl font-black text-white">1</h3>
    </div>
    <div class="glass-panel p-6 rounded-2xl border-l-4 border-l-gray-500">
        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Completed</p>
        <h3 class="text-2xl font-black text-white">0</h3>
    </div>
</div>

<div class="glass-panel rounded-2xl overflow-hidden">
    <div class="table-wrapper p-4">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Package</th>
                    <th>Amount</th>
                    <th>ROI %</th>
                    <th>Status</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="font-mono text-gray-400 text-xs">#INV-1001</td>
                    <td class="font-bold text-white">Starter Package</td>
                    <td class="font-bold text-white">₹500.00</td>
                    <td class="text-xs">5% Weekly</td>
                    <td><span class="px-3 py-1 bg-emerald-500/20 text-emerald-400 text-[10px] font-bold uppercase rounded-full">Active</span></td>
                    <td class="text-xs">10 Mar 2026</td>
                    <td class="text-xs text-gray-500">12 Jun 2026</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="p-4 border-t border-white/5 flex justify-between items-center bg-white/[0.01]">
        <span class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">Showing 1 to 1 of 1 records</span>
        <div class="pagination">
            <a href="#">&laquo; Prev</a>
            <a href="#" class="active">1</a>
            <a href="#">Next &raquo;</a>
        </div>
    </div>
</div>
@endsection
HTML;
makeView($viewsDir . '/user/investments/index.blade.php', $investmentsIndex);

// ---------------------------------------------------------
// NETWORK
// ---------------------------------------------------------
$networkIndex = <<<'HTML'
@extends('layouts.user')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold text-white tracking-tight">My Network</h1>
    <p class="text-xs text-gray-500 font-medium uppercase tracking-widest mt-1">View your downline team</p>
</div>

<div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
    <div class="glass-panel p-6 rounded-2xl">
        <i data-lucide="users" class="w-6 h-6 text-purple-400 mb-3"></i>
        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Direct Referrals</p>
        <h3 class="text-xl font-black text-white">4</h3>
    </div>
    <div class="glass-panel p-6 rounded-2xl">
        <i data-lucide="network" class="w-6 h-6 text-blue-400 mb-3"></i>
        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Total Team Members</p>
        <h3 class="text-xl font-black text-white">24</h3>
    </div>
    <div class="glass-panel p-6 rounded-2xl">
        <i data-lucide="dollar-sign" class="w-6 h-6 text-emerald-400 mb-3"></i>
        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Team Investment Volume</p>
        <h3 class="text-xl font-black text-white">₹45,000.00</h3>
    </div>
</div>

<div class="glass-panel rounded-2xl p-6 mb-8 border border-white/10">
    <h2 class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-6">Network Tree Structure</h2>
    <div class="bg-[#0f111a] p-6 rounded-xl border border-white/5 font-mono text-sm leading-8 text-gray-300 overflow-x-auto">
<div class="text-purple-400 font-bold mb-2">You (Kalp Shah)</div>
<div class="ml-4 border-l border-white/10 pl-4 py-1">
    <div class="text-white relative"><span class="absolute -left-5 top-4 w-4 border-t border-white/10"></span> ├ Rahul</div>
    <div class="ml-4 border-l border-white/10 pl-4 py-1">
        <div class="text-gray-400 relative"><span class="absolute -left-5 top-4 w-4 border-t border-white/10"></span> └ Amit</div>
    </div>
    <div class="text-white relative"><span class="absolute -left-5 top-4 w-4 border-t border-white/10"></span> └ Neha</div>
    <div class="ml-4 border-l border-white/10 pl-4 py-1">
        <div class="text-gray-400 relative"><span class="absolute -left-5 top-4 w-4 border-t border-white/10"></span> └ Vikram</div>
    </div>
</div>
    </div>
</div>

<div class="glass-panel rounded-2xl overflow-hidden">
    <div class="p-6 border-b border-white/5 bg-white/[0.02]">
        <h2 class="text-sm font-bold text-white uppercase tracking-wider">Team Matrix List</h2>
    </div>
    <div class="table-wrapper p-4">
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Level</th>
                    <th>Join Date</th>
                    <th>Investment</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="font-bold text-white flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-purple-500/20 text-purple-400 flex items-center justify-center text-xs">R</div> Rahul
                    </td>
                    <td><span class="px-2 py-1 bg-white/10 rounded text-[10px] font-bold uppercase">Level 1</span></td>
                    <td class="text-xs">01 Mar 2026</td>
                    <td class="font-mono text-emerald-400">₹5,000</td>
                </tr>
                <tr>
                    <td class="font-bold text-white flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-blue-500/20 text-blue-400 flex items-center justify-center text-xs">N</div> Neha
                    </td>
                    <td><span class="px-2 py-1 bg-white/10 rounded text-[10px] font-bold uppercase">Level 1</span></td>
                    <td class="text-xs">05 Mar 2026</td>
                    <td class="font-mono text-emerald-400">₹2,000</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="p-4 border-t border-white/5 flex justify-center bg-white/[0.01]">
        <div class="pagination">
            <a href="#">&laquo; Prev</a>
            <a href="#" class="active">1</a>
            <a href="#">2</a>
            <a href="#">Next &raquo;</a>
        </div>
    </div>
</div>

@endsection
HTML;
makeView($viewsDir . '/user/network/index.blade.php', $networkIndex);

echo "Part 2 views generated.\n";
