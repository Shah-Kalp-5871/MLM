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
    @php
        $directTarget = $nextMilestone->direct_business_target ?? 0;
        $teamTarget = $nextMilestone->team_business_target ?? 0;
        $directPercent = $directTarget > 0 ? min(100, ($directBusiness / $directTarget) * 100) : 100;
        $teamPercent = $teamTarget > 0 ? min(100, ($teamBusiness / $teamTarget) * 100) : 100;
    @endphp
    
    <div class="glass-panel p-6 rounded-2xl relative overflow-hidden group">
        <div class="absolute inset-0 bg-gradient-to-r from-emerald-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
        <div class="flex justify-between items-end mb-4">
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Direct Business</p>
                <h3 class="text-xl font-black text-white">₹{{ number_format($directBusiness, 2) }} / <span class="text-gray-500 text-sm">₹{{ number_format($directTarget, 2) }}</span></h3>
            </div>
            <span class="text-xs font-bold text-emerald-400">{{ round($directPercent) }}%</span>
        </div>
        <div class="w-full h-2 bg-white/5 rounded-full overflow-hidden">
            <div class="h-full bg-gradient-to-r from-emerald-600 to-teal-400 rounded-full shadow-[0_0_10px_rgba(16,185,129,0.3)]" style="width: {{ $directPercent }}%"></div>
        </div>
        @if($directTarget > $directBusiness)
        <p class="text-[10px] text-gray-500 mt-3 font-medium italic">₹{{ number_format($directTarget - $directBusiness, 2) }} more needed from direct referrals</p>
        @else
        <p class="text-[10px] text-emerald-500 mt-3 font-medium italic">Target achieved for {{ $nextMilestone->name ?? 'next level' }}!</p>
        @endif
    </div>
    
    <div class="glass-panel p-6 rounded-2xl relative overflow-hidden group">
        <div class="absolute inset-0 bg-gradient-to-r from-purple-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
        <div class="flex justify-between items-end mb-4">
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Team Business</p>
                <h3 class="text-xl font-black text-white">₹{{ number_format($teamBusiness, 2) }} / <span class="text-gray-500 text-sm">₹{{ number_format($teamTarget, 2) }}</span></h3>
            </div>
            <span class="text-xs font-bold text-purple-400">{{ round($teamPercent) }}%</span>
        </div>
        <div class="w-full h-2 bg-white/5 rounded-full overflow-hidden">
            <div class="h-full bg-gradient-to-r from-purple-600 to-indigo-400 rounded-full shadow-[0_0_10px_rgba(147,51,234,0.3)]" style="width: {{ $teamPercent }}%"></div>
        </div>
        @if($teamTarget > $teamBusiness)
        <p class="text-[10px] text-gray-500 mt-3 font-medium italic">₹{{ number_format($teamTarget - $teamBusiness, 2) }} more needed from your entire network</p>
        @else
        <p class="text-[10px] text-purple-500 mt-3 font-medium italic">Target achieved for {{ $nextMilestone->name ?? 'next level' }}!</p>
        @endif
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
                    @foreach($milestones as $milestone)
                    <tr class="{{ $directBusiness >= $milestone->direct_business_target && $teamBusiness >= $milestone->team_business_target ? 'bg-emerald-500/5' : '' }}">
                        <td class="font-bold text-white">{{ $milestone->name }}</td>
                        <td class="text-xs text-gray-400">₹{{ number_format($milestone->direct_business_target / 1000, 0) }}k + ₹{{ number_format($milestone->team_business_target / 1000, 0) }}k</td>
                        <td class="font-bold text-amber-500 text-xs">₹{{ number_format($milestone->voucher_value) }} Voucher</td>
                    </tr>
                    @endforeach
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
                    @forelse($vouchers as $voucher)
                    <tr>
                        <td class="font-bold text-white">{{ $voucher->club_reward_id ? 'Milestone Reward' : 'Promo Voucher' }}</td>
                        <td class="font-mono text-purple-400 text-xs bg-black/40 px-2 py-1 rounded inline-block">{{ $voucher->code }}</td>
                        <td>
                            @if($voucher->status === 'redeemed')
                            <span class="px-2 py-1 bg-gray-500/20 text-gray-400 text-[10px] font-bold uppercase rounded">Used</span>
                            @else
                            <span class="px-2 py-1 bg-emerald-500/20 text-emerald-400 text-[10px] font-bold uppercase rounded">{{ ucfirst($voucher->status) }}</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center py-4 text-gray-500 italic text-xs">No vouchers earned yet.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-3 border-t border-white/5 flex justify-center bg-white/[0.01]">
            {{ $vouchers->links() }}
        </div>
    </div>
</div>
@endsection