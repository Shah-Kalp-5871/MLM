@extends('layouts.user')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold text-white tracking-tight">Club Rewards</h1>
    <p class="text-xs text-gray-500 font-medium uppercase tracking-widest mt-1">Milestone Vouchers & Recognition</p>
</div>

<!-- Explanation Header -->
<div class="glass-panel rounded-2xl p-6 mb-8 border border-amber-500/30">
    <h2 class="text-sm font-bold text-white uppercase tracking-wider mb-2 flex items-center gap-2">
        <i data-lucide="info" class="w-4 h-4 text-amber-500"></i> How Club Rewards Work
    </h2>
    <p class="text-xs text-gray-400 leading-relaxed mb-4">
        Club rewards are milestone-based bonuses unlocked when your network reaches specific business targets. 
        <span class="text-amber-500 font-bold italic">Important: Vouchers cannot be withdrawn as cash; they are strictly for use within the platform ecosystem.</span>
    </p>
    <div class="flex flex-wrap gap-4 text-[10px] font-bold uppercase tracking-widest text-gray-500">
        <div class="flex items-center gap-2 bg-white/5 px-3 py-1.5 rounded-lg border border-white/5">
            <i data-lucide="check-circle" class="w-3 h-3 text-emerald-500"></i> Milestone Based
        </div>
        <div class="flex items-center gap-2 bg-white/5 px-3 py-1.5 rounded-lg border border-white/5">
            <i data-lucide="x-circle" class="w-3 h-3 text-rose-500"></i> Non-Withdrawable
        </div>
        <div class="flex items-center gap-2 bg-white/5 px-3 py-1.5 rounded-lg border border-white/5">
            <i data-lucide="ticket" class="w-3 h-3 text-purple-500"></i> Platform Use Only
        </div>
    </div>
</div>

<!-- Qualification Progress -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
    <div class="glass-panel p-6 rounded-2xl relative overflow-hidden group">
        <div class="absolute inset-0 bg-gradient-to-r from-emerald-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
        <div class="flex justify-between items-end mb-4">
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Direct Business</p>
                <h3 class="text-xl font-black text-white">₹7,000 / <span class="text-gray-500 text-sm">₹10,000</span></h3>
            </div>
            <span class="text-xs font-bold text-emerald-400">70%</span>
        </div>
        <div class="w-full h-2 bg-white/5 rounded-full overflow-hidden">
            <div class="h-full bg-gradient-to-r from-emerald-600 to-teal-400 w-[70%] rounded-full shadow-[0_0_10px_rgba(16,185,129,0.3)]"></div>
        </div>
        <p class="text-[10px] text-gray-500 mt-3 font-medium italic">₹3,000 more needed from direct referrals</p>
    </div>
    
    <div class="glass-panel p-6 rounded-2xl relative overflow-hidden group">
        <div class="absolute inset-0 bg-gradient-to-r from-purple-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
        <div class="flex justify-between items-end mb-4">
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Team Business</p>
                <h3 class="text-xl font-black text-white">₹20,000 / <span class="text-gray-500 text-sm">₹40,000</span></h3>
            </div>
            <span class="text-xs font-bold text-purple-400">50%</span>
        </div>
        <div class="w-full h-2 bg-white/5 rounded-full overflow-hidden">
            <div class="h-full bg-gradient-to-r from-purple-600 to-indigo-400 w-[50%] rounded-full shadow-[0_0_10px_rgba(147,51,234,0.3)]"></div>
        </div>
        <p class="text-[10px] text-gray-500 mt-3 font-medium italic">₹20,000 more needed from your entire network</p>
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