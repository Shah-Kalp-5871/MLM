<?php
$viewsDir = __DIR__ . '/resources/views';

function makeView($path, $content) {
    $dir = dirname($path);
    if (!is_dir($dir)) mkdir($dir, 0777, true);
    file_put_contents($path, $content);
}

// ---------------------------------------------------------
// REFERRALS
// ---------------------------------------------------------
$referralsIndex = <<<'HTML'
@extends('layouts.user')

@section('content')
<div class="mb-8 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold text-white tracking-tight">Referrals & Affiliates</h1>
        <p class="text-xs text-gray-500 font-medium uppercase tracking-widest mt-1">Grow your network and earn</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-10">
    <div class="lg:col-span-2 glass-panel p-8 rounded-2xl border border-purple-500/30 flex flex-col justify-center">
        <h2 class="text-sm font-bold text-white uppercase tracking-wider mb-2">Your Invite Link</h2>
        <p class="text-xs text-gray-400 mb-6">Share this link to invite users. You earn level commissions on their ROI.</p>
        
        <div class="flex items-center gap-3">
            <div class="flex-1 bg-black/40 border border-white/10 rounded-xl px-4 py-3 font-mono text-sm text-purple-400 select-all">
                https://platform.com/register?ref=KALP123
            </div>
            <button class="px-6 py-3 rounded-xl bg-purple-600 hover:bg-purple-500 text-white text-xs font-bold uppercase tracking-wider transition-all shadow-lg shadow-purple-900/40 flex items-center gap-2" onclick="alert('Copied to clipboard!')">
                <i data-lucide="copy" class="w-4 h-4"></i> Copy
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-4">
        <div class="glass-panel p-5 rounded-2xl flex items-center justify-between">
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Direct Referrals</p>
                <h3 class="text-2xl font-black text-white">4</h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-purple-500/20 flex items-center justify-center text-purple-400"><i data-lucide="users" class="w-5 h-5"></i></div>
        </div>
        <div class="glass-panel p-5 rounded-2xl flex items-center justify-between">
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Total Team</p>
                <h3 class="text-2xl font-black text-white">24</h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-blue-500/20 flex items-center justify-center text-blue-400"><i data-lucide="network" class="w-5 h-5"></i></div>
        </div>
    </div>
</div>

<div class="glass-panel rounded-2xl overflow-hidden">
    <div class="p-6 border-b border-white/5 bg-white/[0.02]">
        <h2 class="text-sm font-bold text-white uppercase tracking-wider">Referral List</h2>
    </div>
    <div class="table-wrapper p-4">
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Join Date</th>
                    <th>Investment Vol</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="font-bold text-white">Rahul</td>
                    <td class="text-gray-400 text-xs">rahul@example.com</td>
                    <td class="text-xs text-gray-500">01 Mar 2026</td>
                    <td class="font-mono text-emerald-400">₹5,000</td>
                </tr>
                <tr>
                    <td class="font-bold text-white">Neha</td>
                    <td class="text-gray-400 text-xs">neha@example.com</td>
                    <td class="text-xs text-gray-500">05 Mar 2026</td>
                    <td class="font-mono text-emerald-400">₹2,000</td>
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
makeView($viewsDir . '/user/referrals/index.blade.php', $referralsIndex);

// ---------------------------------------------------------
// CLUB REWARDS
// ---------------------------------------------------------
$clubIndex = <<<'HTML'
@extends('layouts.user')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold text-white tracking-tight">Club Rewards</h1>
    <p class="text-xs text-gray-500 font-medium uppercase tracking-widest mt-1">Milestone Vouchers & Recognition</p>
</div>

<!-- Qualification Progress -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
    <div class="glass-panel p-6 rounded-2xl">
        <h2 class="text-xs font-bold text-white uppercase tracking-wider mb-4 flex justify-between"><span>Direct Business</span> <span class="text-emerald-400">₹7,000 / $10,000</span></h2>
        <div class="w-full h-3 bg-white/5 rounded-full overflow-hidden">
            <div class="h-full bg-gradient-to-r from-emerald-600 to-teal-400 w-[70%] rounded-full"></div>
        </div>
        <p class="text-[10px] text-gray-500 mt-2 font-medium">30% remaining for Silver Level</p>
    </div>
    
    <div class="glass-panel p-6 rounded-2xl">
        <h2 class="text-xs font-bold text-white uppercase tracking-wider mb-4 flex justify-between"><span>Team Business</span> <span class="text-purple-400">₹20,000 / $40,000</span></h2>
        <div class="w-full h-3 bg-white/5 rounded-full overflow-hidden">
            <div class="h-full bg-gradient-to-r from-purple-600 to-indigo-400 w-[50%] rounded-full"></div>
        </div>
        <p class="text-[10px] text-gray-500 mt-2 font-medium">50% remaining for Gold Level</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-10">
    <!-- Club Levels -->
    <div class="glass-panel rounded-2xl overflow-hidden flex flex-col border border-amber-500/20">
        <div class="p-5 border-b border-white/5 bg-gradient-to-r from-amber-500/10 to-transparent">
            <h2 class="text-sm font-bold text-amber-500 uppercase tracking-wider flex items-center gap-2"><i data-lucide="award" class="w-4 h-4 text-amber-500"></i> Reward Tiers</h2>
        </div>
        <div class="table-wrapper flex-1 p-4">
            <table>
                <thead>
                    <tr>
                        <th>Level</th>
                        <th>Requirement (Dir + Team)</th>
                        <th>Reward</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="bg-white/[0.02]">
                        <td class="font-bold text-white">Silver</td>
                        <td class="text-xs text-gray-400">5k + 15k</td>
                        <td class="font-bold text-amber-500 text-xs">₹500 Voucher</td>
                    </tr>
                    <tr>
                        <td class="font-bold text-white">Gold</td>
                        <td class="text-xs text-gray-400">10k + 40k</td>
                        <td class="font-bold text-amber-500 text-xs">₹2,000 Voucher</td>
                    </tr>
                    <tr>
                        <td class="font-bold text-white">Platinum</td>
                        <td class="text-xs text-gray-400">20k + 100k</td>
                        <td class="font-bold text-amber-500 text-xs">₹2,500 Voucher</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Earned Rewards -->
    <div class="glass-panel rounded-2xl overflow-hidden flex flex-col">
        <div class="p-5 border-b border-white/5 bg-white/[0.02]">
            <h2 class="text-sm font-bold text-white uppercase tracking-wider">My Vouchers</h2>
        </div>
        <div class="table-wrapper flex-1 p-4">
            <table>
                <thead>
                    <tr>
                        <th>Reward</th>
                        <th>Voucher Code</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="font-bold text-white">Silver Badge</td>
                        <td class="font-mono text-purple-400 text-xs bg-black/40 px-2 py-1 rounded inline-block">NX-SILV-9921</td>
                        <td><span class="px-2 py-1 bg-emerald-500/20 text-emerald-400 text-[10px] font-bold uppercase rounded">Unused</span></td>
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
makeView($viewsDir . '/user/club-rewards/index.blade.php', $clubIndex);

// ---------------------------------------------------------
// PROFILE
// ---------------------------------------------------------
$profileIndex = <<<'HTML'
@extends('layouts.user')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold text-white tracking-tight">Account Settings</h1>
    <p class="text-xs text-gray-500 font-medium uppercase tracking-widest mt-1">Manage your profile and security</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Personal Details -->
    <div class="glass-panel rounded-2xl p-8 border hover:border-purple-500/30 transition-colors">
        <h2 class="text-sm font-bold text-white uppercase tracking-wider mb-6 flex items-center gap-2"><i data-lucide="user" class="w-4 h-4 text-purple-400"></i> Personal Information</h2>
        
        <form class="flex flex-col gap-5">
            <div>
                <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Full Name</label>
                <input type="text" class="w-full bg-black/40 border border-white/10 rounded-xl px-4 py-3 text-white text-sm focus:border-purple-500 focus:outline-none transition-colors" value="Kalp Shah">
            </div>
            <div>
                <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Email Address</label>
                <input type="email" class="w-full bg-black/40 border border-white/10 rounded-xl px-4 py-3 text-white text-sm focus:border-purple-500 focus:outline-none transition-colors" value="kalp@example.com" disabled>
                <p class="text-[10px] text-gray-500 mt-1">Contact support to change email.</p>
            </div>
            <div>
                <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Phone Number</label>
                <input type="text" class="w-full bg-black/40 border border-white/10 rounded-xl px-4 py-3 text-white text-sm focus:border-purple-500 focus:outline-none transition-colors" value="+91 9876543210">
            </div>
            <div>
                <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Withdrawal Wallet Address / UPI</label>
                <input type="text" class="w-full bg-black/40 border border-white/10 rounded-xl px-4 py-3 text-purple-300 font-mono text-xs focus:border-purple-500 focus:outline-none transition-colors" value="kalp@upi">
            </div>
            <button type="button" class="mt-4 px-6 py-3 rounded-xl bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-500 hover:to-indigo-500 text-white text-xs font-bold uppercase tracking-wider transition-all shadow-lg shadow-purple-900/40 self-start">Update Profile</button>
        </form>
    </div>

    <!-- Security -->
    <div class="glass-panel rounded-2xl p-8 border hover:border-emerald-500/30 transition-colors self-start">
        <h2 class="text-sm font-bold text-white uppercase tracking-wider mb-6 flex items-center gap-2"><i data-lucide="shield" class="w-4 h-4 text-emerald-400"></i> Password & Security</h2>
        
        <form class="flex flex-col gap-5">
            <div>
                <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Current Password</label>
                <input type="password" class="w-full bg-black/40 border border-white/10 rounded-xl px-4 py-3 text-white text-sm focus:border-emerald-500 focus:outline-none transition-colors" placeholder="••••••••">
            </div>
            <div>
                <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">New Password</label>
                <input type="password" class="w-full bg-black/40 border border-white/10 rounded-xl px-4 py-3 text-white text-sm focus:border-emerald-500 focus:outline-none transition-colors" placeholder="••••••••">
            </div>
            <div>
                <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Confirm New Password</label>
                <input type="password" class="w-full bg-black/40 border border-white/10 rounded-xl px-4 py-3 text-white text-sm focus:border-emerald-500 focus:outline-none transition-colors" placeholder="••••••••">
            </div>
            <button type="button" class="mt-4 px-6 py-3 rounded-xl bg-white/10 hover:bg-white/20 border border-white/10 text-white text-xs font-bold uppercase tracking-wider transition-all self-start">Change Password</button>
        </form>
    </div>
</div>
@endsection
HTML;
makeView($viewsDir . '/user/profile/index.blade.php', $profileIndex);

echo "Part 4 views generated.\n";
