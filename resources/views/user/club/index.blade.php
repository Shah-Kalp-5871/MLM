@extends('layouts.user')

@section('content')
<div class="space-y-10 pb-20">
    <!-- Header Area -->
    <div class="relative py-12 px-8 rounded-3xl overflow-hidden glass-panel">
        <div class="absolute inset-0 bg-gradient-to-r from-purple-600/20 to-indigo-600/20 pointer-events-none"></div>
        <div class="absolute -right-20 -top-20 w-64 h-64 bg-purple-600/10 rounded-full blur-3xl"></div>
        
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-8">
            <div class="space-y-3">
                <div class="flex items-center gap-3">
                    <div class="px-3 py-1 rounded-full bg-purple-600/20 border border-purple-500/30 text-[10px] font-black text-purple-400 uppercase tracking-[0.2em]">Achievement Center</div>
                </div>
                <h1 class="text-4xl font-black text-white tracking-tight">CLUB ACHIEVEMENTS</h1>
                <p class="text-slate-400 text-sm max-w-xl">Grow your network, increase direct and team business, and unlock massive reward vouchers at every milestone.</p>
            </div>
            
            <div class="flex items-center gap-6">
                <div class="text-center px-6 border-r border-white/5">
                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Total Earned</p>
                    <h4 class="text-2xl font-black text-emerald-400">{{ $settings['platform_currency_symbol'] ?? '$' }}{{ number_format($earnedVouchers->sum('amount'), 0) }}</h4>
                </div>
                <div class="text-center px-6">
                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Milestones</p>
                    <h4 class="text-2xl font-black text-white">{{ $earnedVouchers->count() }} / 7</h4>
                </div>
            </div>
        </div>
    </div>

    @php
        $nextClub = null;
        foreach($clubLevels as $lvl) {
            if ($stats['direct_business'] < $lvl->direct_required || $stats['team_business'] < $lvl->team_required) {
                $nextClub = $lvl;
                break;
            }
        }
    @endphp

    @if($nextClub)
    <!-- Next Milestone Tracking -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
        <div class="glass-panel p-8 rounded-2xl relative overflow-hidden group">
            <div class="absolute inset-0 bg-gradient-to-r from-purple-600/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <div class="flex justify-between items-center mb-6">
                <div class="space-y-1">
                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Next Target: Direct Business</p>
                    <h3 class="text-2xl font-black text-white">{{ $settings['platform_currency_symbol'] ?? '$' }}{{ number_format($stats['direct_business'], 0) }} <span class="text-slate-500 text-sm font-bold">/ {{ number_format($nextClub->direct_required, 0) }}</span></h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-purple-600/10 flex items-center justify-center">
                    <i data-lucide="users" class="w-6 h-6 text-purple-400"></i>
                </div>
            </div>
            <div class="w-full bg-white/5 h-3 rounded-full overflow-hidden">
                <div class="bg-gradient-to-r from-purple-600 to-indigo-600 h-full transition-all duration-1000" style="width: {{ min(($stats['direct_business'] / $nextClub->direct_required) * 100, 100) }}%"></div>
            </div>
            <p class="text-[10px] text-slate-500 mt-4 text-right font-bold uppercase tracking-widest">{{ round(min(($stats['direct_business'] / $nextClub->direct_required) * 100, 100)) }}% Completed</p>
        </div>

        <div class="glass-panel p-8 rounded-2xl relative overflow-hidden group">
            <div class="absolute inset-0 bg-gradient-to-r from-emerald-600/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <div class="flex justify-between items-center mb-6">
                <div class="space-y-1">
                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Next Target: Team Business</p>
                    <h3 class="text-2xl font-black text-white">{{ $settings['platform_currency_symbol'] ?? '$' }}{{ number_format($stats['team_business'], 0) }} <span class="text-slate-500 text-sm font-bold">/ {{ number_format($nextClub->team_required, 0) }}</span></h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-emerald-600/10 flex items-center justify-center">
                    <i data-lucide="network" class="w-6 h-6 text-emerald-400"></i>
                </div>
            </div>
            <div class="w-full bg-white/5 h-3 rounded-full overflow-hidden">
                <div class="bg-gradient-to-r from-emerald-600 to-teal-600 h-full transition-all duration-1000" style="width: {{ min(($stats['team_business'] / $nextClub->team_required) * 100, 100) }}%"></div>
            </div>
            <p class="text-[10px] text-slate-500 mt-4 text-right font-bold uppercase tracking-widest">{{ round(min(($stats['team_business'] / $nextClub->team_required) * 100, 100)) }}% Completed</p>
        </div>
    </div>
    @endif

    <!-- Club Tiers Grid -->
    <div>
        <h2 class="text-lg font-black text-white mb-8 flex items-center gap-3">
            <i data-lucide="award" class="text-amber-500"></i>
            Club Milestones
        </h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($clubLevels as $level)
                @php
                    $isEarned = $earnedVouchers->contains('type', 'club_' . $level->level);
                    $isInProgress = !$isEarned && ($nextClub && $nextClub->level == $level->level);
                    $isLocked = !$isEarned && !$isInProgress;
                @endphp
                
                <div class="glass-panel p-6 rounded-2xl relative overflow-hidden transition-all group {{ $isEarned ? 'border-emerald-500/30 bg-emerald-500/5' : ($isInProgress ? 'border-purple-500/30 bg-purple-500/5 hover:border-purple-500/50' : 'opacity-40 grayscale') }}">
                    @if($isEarned)
                    <div class="absolute -right-4 -top-4 w-20 h-20 bg-emerald-500/10 rounded-full flex items-center justify-center">
                        <i data-lucide="check-circle" class="w-6 h-6 text-emerald-500"></i>
                    </div>
                    @endif

                    <div class="mb-6">
                        <h3 class="text-xl font-black text-white">{{ $level->title }}</h3>
                        <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mt-1">Reward: <span class="text-amber-500">{{ $settings['platform_currency_symbol'] ?? '$' }}{{ number_format($level->reward_amount, 0) }} Voucher</span></p>
                    </div>

                    <div class="space-y-4">
                        <div class="flex justify-between items-center text-xs">
                            <span class="text-slate-500 font-bold uppercase tracking-widest">Direct Business</span>
                            <span class="text-white font-bold">{{ $settings['platform_currency_symbol'] ?? '$' }}{{ number_format($level->direct_required, 0) }}</span>
                        </div>
                        <div class="flex justify-between items-center text-xs">
                            <span class="text-slate-500 font-bold uppercase tracking-widest">Team Business</span>
                            <span class="text-white font-bold">{{ $settings['platform_currency_symbol'] ?? '$' }}{{ number_format($level->team_required, 0) }}</span>
                        </div>
                    </div>

                    <div class="mt-8">
                        @if($isEarned)
                            <div class="w-full py-2 rounded-xl bg-emerald-500/20 text-emerald-400 text-center text-[10px] font-black uppercase tracking-widest">Reward Claimed</div>
                        @elseif($isInProgress)
                            <div class="w-full py-2 rounded-xl bg-purple-600 text-white text-center text-[10px] font-black uppercase tracking-widest">In Progress</div>
                        @else
                            <div class="w-full py-2 rounded-xl bg-white/5 text-slate-600 text-center text-[10px] font-black uppercase tracking-widest flex items-center justify-center gap-2">
                                <i data-lucide="lock" class="w-3 h-3"></i> Locked
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Voucher Rules & Info -->
    <div class="glass-panel p-8 rounded-3xl border border-amber-500/20 bg-amber-500/5 relative overflow-hidden">
        <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-amber-500/5 rounded-full blur-[40px]"></div>
        <div class="flex items-start gap-6">
            <div class="w-14 h-14 rounded-2xl bg-amber-500/10 border border-amber-500/30 flex items-center justify-center flex-shrink-0">
                <i data-lucide="info" class="w-7 h-7 text-amber-500"></i>
            </div>
            <div>
                <h4 class="text-lg font-black text-white mb-2">How Vouchers Work</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-3">
                    <p class="text-xs text-slate-400 flex items-center gap-2 italic">
                        <i data-lucide="circle-dot" class="w-2 h-2 text-amber-500"></i>
                        Vouchers are issued automatically upon milestone approval.
                    </p>
                    <p class="text-xs text-slate-400 flex items-center gap-2 italic">
                        <i data-lucide="circle-dot" class="w-2 h-2 text-amber-500"></i>
                        Codes can be used for platform reinvestments.
                    </p>
                    <p class="text-xs text-slate-400 flex items-center gap-2 italic">
                        <i data-lucide="circle-dot" class="w-2 h-2 text-amber-500"></i>
                        Club rewards are non-withdrawable but transferable.
                    </p>
                    <p class="text-xs text-slate-400 flex items-center gap-2 italic">
                        <i data-lucide="circle-dot" class="w-2 h-2 text-amber-500"></i>
                        Each club milestone is a one-time lifetime award.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
