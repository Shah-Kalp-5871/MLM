@extends('layouts.user')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold text-white tracking-tight">Welcome, {{ $user->name }}</h1>
    <p class="text-xs text-gray-400 font-medium uppercase tracking-widest mt-1">Build your network and earn passive income</p>
</div>

<!-- Stat Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
    <div class="glass-panel p-6 rounded-2xl relative overflow-hidden group border-l-4 border-l-emerald-500">
        <div class="absolute inset-0 bg-gradient-to-r from-emerald-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
        <i data-lucide="wallet" class="w-8 h-8 text-emerald-400 mb-4 opacity-80"></i>
        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Wallet Balance</p>
        <h3 class="text-2xl font-black text-white">{{ $settings['platform_currency_symbol'] ?? '$' }}{{ number_format($stats['wallet_balance'], 2) }}</h3>
    </div>

    <div class="glass-panel p-6 rounded-2xl relative overflow-hidden group">
        <div class="absolute inset-0 bg-gradient-to-r from-purple-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
        <i data-lucide="trending-up" class="w-8 h-8 text-purple-400 mb-4 opacity-80"></i>
        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Weekly Profit ({{ $stats['roi_percentage'] }}%)</p>
        <h3 class="text-2xl font-black text-white">{{ $settings['platform_currency_symbol'] ?? '$' }}{{ number_format($stats['weekly_earnings'], 2) }}</h3>
    </div>

    <div class="glass-panel p-6 rounded-2xl relative overflow-hidden group border-l-4 border-l-blue-500">
        <div class="absolute inset-0 bg-gradient-to-r from-blue-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
        <i data-lucide="calendar-check" class="w-8 h-8 text-blue-400 mb-4 opacity-80"></i>
        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Next ROI Payout</p>
        <h3 class="text-xl font-black text-white">
            @if($stats['next_payout_at'])
                {{ $stats['next_payout_at']->format('d M') }}
                <span class="text-[10px] text-blue-400 block mt-1 font-bold uppercase tracking-tighter">In {{ now()->diffInDays($stats['next_payout_at']) }} Days</span>
            @else
                <span class="text-sm">No Active Plan</span>
            @endif
        </h3>
    </div>

    <div class="glass-panel p-6 rounded-2xl relative overflow-hidden group">
        <div class="absolute inset-0 bg-gradient-to-r from-amber-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
        <i data-lucide="gem" class="w-8 h-8 text-amber-500 mb-4 opacity-80"></i>
        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Total Investment</p>
        <h3 class="text-2xl font-black text-white">{{ $settings['platform_currency_symbol'] ?? '$' }}{{ number_format($stats['total_investment'], 2) }}</h3>
    </div>

    <!-- New: Level Income Card -->
    <div class="glass-panel p-6 rounded-2xl relative overflow-hidden group border-indigo-500/20">
        <div class="absolute inset-0 bg-gradient-to-r from-indigo-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
        <div class="flex justify-between items-start mb-4">
            <i data-lucide="network" class="w-8 h-8 text-indigo-400 opacity-80"></i>
            <span class="px-2 py-1 bg-indigo-500/10 text-indigo-400 text-[10px] uppercase font-bold rounded-lg">+{{ $settings['platform_currency_symbol'] ?? '$' }}{{ number_format($stats['level_income_today'], 2) }} Today</span>
        </div>
        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Total Level Income</p>
        <h3 class="text-2xl font-black text-white">{{ $settings['platform_currency_symbol'] ?? '$' }}{{ number_format($stats['total_level_income'], 2) }}</h3>
    </div>

    <div class="glass-panel p-6 rounded-2xl relative overflow-hidden group border-emerald-500/20">
        <div class="absolute inset-0 bg-gradient-to-r from-emerald-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
        <i data-lucide="award" class="w-8 h-8 text-emerald-500 mb-4 opacity-80"></i>
        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Network Team Base</p>
        <h3 class="text-xl font-black text-white">Team: <span class="text-emerald-500">{{ $stats['team_size'] }}</span> | Direct: <span class="text-emerald-500">{{ $stats['direct_referrals'] }}</span></h3>
    </div>
</div>

<!-- Quick Actions -->
<div class="mb-10">
    <h2 class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-4">Quick Actions</h2>
    <div class="flex flex-wrap gap-4">
        <a href="{{ route('invest.create') }}" class="px-6 py-3 rounded-xl bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-500 hover:to-indigo-500 text-white text-xs font-bold uppercase tracking-wider transition-all shadow-lg shadow-purple-900/40 flex items-center gap-2 animate-pulse hover:animate-none border border-purple-400/30">
            <i data-lucide="plus-circle" class="w-4 h-4"></i> Invest Now
        </a>
        <a href="{{ route('network.index') }}" class="px-6 py-3 rounded-xl glass-panel text-white text-xs font-bold uppercase tracking-wider hover:bg-white/10 transition-all flex items-center gap-2"><i data-lucide="users" class="w-4 h-4"></i> View Network</a>
        <a href="{{ route('withdraw.create') }}" class="px-6 py-3 rounded-xl glass-panel text-white text-xs font-bold uppercase tracking-wider hover:bg-white/10 transition-all flex items-center gap-2"><i data-lucide="arrow-up-right" class="w-4 h-4"></i> Withdraw</a>
        <a href="{{ route('referrals.index') }}" class="px-6 py-3 rounded-xl glass-panel text-white text-xs font-bold uppercase tracking-wider hover:bg-white/10 transition-all flex items-center gap-2"><i data-lucide="user-plus" class="w-4 h-4"></i> Invite Friends</a>
    </div>
</div>

<!-- Club Target Progress -->
<div class="mb-10">
    @php
        $nextClub = null;
        $highestQualified = 0;
        foreach($clubLevels as $lvl) {
            if ($stats['direct_business'] >= $lvl->direct_required && $stats['team_business'] >= $lvl->team_required) {
                $highestQualified = $lvl->level;
            } else {
                $nextClub = $lvl;
                break;
            }
        }
        
        // Default to last club if all cleared
        if (!$nextClub) $nextClub = $clubLevels->last();
    @endphp

    <div class="flex items-center justify-between mb-4">
        <div>
            <h2 class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Club Reward Progress ({{ $highestQualified > 0 ? 'Last: Club '.$highestQualified : 'Initial Milestone' }})</h2>
            <p class="text-[11px] text-white font-bold mt-1">Next: Club {{ $nextClub->level }} Reward - {{ $settings['platform_currency_symbol'] ?? '$' }}{{ number_format($nextClub->reward_amount, 0) }}</p>
        </div>
        <span class="text-[10px] font-black {{ $highestQualified == 7 ? 'text-emerald-400' : 'text-purple-400' }} uppercase tracking-widest">
            {{ $highestQualified == 7 ? 'All Milestones Met' : 'In Progress' }}
        </span>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="glass-panel p-6 rounded-2xl relative overflow-hidden group">
            <div class="absolute inset-0 bg-gradient-to-r from-purple-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <div class="flex justify-between items-center mb-4">
                <span class="text-xs font-bold text-white uppercase tracking-wider">Direct Business</span>
                <span class="text-xs font-black text-white">{{ $settings['platform_currency_symbol'] ?? '$' }}{{ number_format($stats['direct_business'], 0) }} / {{ $settings['platform_currency_symbol'] ?? '$' }}{{ number_format($nextClub->direct_required, 0) }}</span>
            </div>
            <div class="w-full bg-white/5 h-2 rounded-full overflow-hidden">
                <div class="bg-gradient-to-r from-purple-600 to-indigo-600 h-full transition-all duration-1000" style="width: {{ min(($stats['direct_business'] / $nextClub->direct_required) * 100, 100) }}%"></div>
            </div>
        </div>
        <div class="glass-panel p-6 rounded-2xl relative overflow-hidden group">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <div class="flex justify-between items-center mb-4">
                <span class="text-xs font-bold text-white uppercase tracking-wider">Team Business</span>
                <span class="text-xs font-black text-white">{{ $settings['platform_currency_symbol'] ?? '$' }}{{ number_format($stats['team_business'], 0) }} / {{ $settings['platform_currency_symbol'] ?? '$' }}{{ number_format($nextClub->team_required, 0) }}</span>
            </div>
            <div class="w-full bg-white/5 h-2 rounded-full overflow-hidden">
                <div class="bg-gradient-to-r from-blue-600 to-emerald-600 h-full transition-all duration-1000" style="width: {{ min(($stats['team_business'] / $nextClub->team_required) * 100, 100) }}%"></div>
            </div>
        </div>
    </div>
</div>


<!-- How It Works (Mirrored from Welcome) -->
<div class="mb-10">
    <div class="p-8 rounded-[2rem] glass-panel border-purple-500/10 relative overflow-hidden group">
        <div class="absolute top-0 right-0 w-64 h-64 bg-purple-600/5 rounded-full blur-3xl -mr-32 -mt-32"></div>
        
        <div class="flex items-center gap-4 mb-8 relative z-10">
            <div class="w-12 h-12 bg-purple-600/20 rounded-2xl flex items-center justify-center text-purple-400">
                <i data-lucide="help-circle" class="w-6 h-6"></i>
            </div>
            <div>
                <h2 class="text-sm font-black text-white px-1 uppercase tracking-widest">How It Works</h2>
                <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest px-1">Your Path to EliteMatrixPro Success</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 relative z-10">
            <div class="space-y-3">
                <div class="text-2xl font-black text-purple-500/30 group-hover:text-purple-500 transition-colors">01</div>
                <h4 class="text-sm font-bold text-white uppercase">Automated ROI</h4>
                <p class="text-[11px] text-gray-400 leading-relaxed">Earn 3% to 3.5% weekly returns on your principal investment, credited automatically every Friday.</p>
            </div>
            <div class="space-y-3">
                <div class="text-2xl font-black text-purple-500/30 group-hover:text-purple-500 transition-colors">02</div>
                <h4 class="text-sm font-bold text-white uppercase">15-Level Network</h4>
                <p class="text-[11px] text-gray-400 leading-relaxed">Earn a percentage of the ROI generated by your referrals up to 15 levels deep in your hierarchy.</p>
            </div>
            <div class="space-y-3">
                <div class="text-2xl font-black text-purple-500/30 group-hover:text-purple-500 transition-colors">03</div>
                <h4 class="text-sm font-bold text-white uppercase">Direct & Team Volume</h4>
                <p class="text-[11px] text-gray-400 leading-relaxed">Build your direct business and watch your cumulative team volume unlock higher status tiers.</p>
            </div>
            <div class="space-y-3">
                <div class="text-2xl font-black text-purple-500/30 group-hover:text-purple-500 transition-colors">04</div>
                <h4 class="text-sm font-bold text-white uppercase">Voucher Redemption</h4>
                <p class="text-[11px] text-gray-400 leading-relaxed">Redeem your milestone vouchers directly in our internal system to compound your earnings.</p>
            </div>
        </div>
    </div>
</div>

<!-- Recent Earnings -->
<div class="glass-panel rounded-2xl overflow-hidden">
    <div class="p-6 border-b border-white/5 flex justify-between items-center bg-white/[0.02]">
        <h2 class="text-sm font-bold text-white uppercase tracking-wider">Recent Earnings</h2>
        <a href="{{ route('earnings.index') }}" class="text-xs font-bold text-purple-400 hover:text-white transition-colors uppercase tracking-widest">View All</a>
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
                @forelse($recent_transactions as $tx)
                <tr>
                    <td class="font-medium text-white">
                        <span class="px-2 py-1 rounded bg-purple-500/20 text-purple-400 text-[10px] uppercase font-bold mr-2">{{ str_replace('_', ' ', $tx->type) }}</span> 
                        {{ $tx->description }}
                    </td>
                    <td class="{{ $tx->direction == 'credit' ? 'text-emerald-400' : 'text-red-400' }} font-bold">
                        {{ $tx->direction == 'credit' ? '+' : '-' }} {{ $settings['platform_currency_symbol'] ?? '$' }}{{ number_format($tx->amount, 2) }}
                    </td>
                    <td class="text-xs text-gray-500">{{ $tx->created_at->format('d M Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center py-8 text-gray-500 italic">No transactions found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="p-4 border-t border-white/5 flex justify-center bg-white/[0.01]">
        <a href="{{ route('wallet.index') }}" class="text-[10px] font-black uppercase tracking-widest text-gray-500 hover:text-purple-400 transition-colors flex items-center gap-2">
            See All Transactions <i data-lucide="arrow-right" class="w-3 h-3"></i>
        </a>
    </div>
</div>
@endsection
