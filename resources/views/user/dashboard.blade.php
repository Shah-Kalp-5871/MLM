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
        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Weekly ROI</p>
        <h3 class="text-2xl font-black text-white">{{ $settings['platform_currency_symbol'] ?? '$' }}{{ number_format($stats['weekly_roi'], 2) }}</h3>
    </div>

    <div class="glass-panel p-6 rounded-2xl relative overflow-hidden group">
        <div class="absolute inset-0 bg-gradient-to-r from-blue-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
        <i data-lucide="users" class="w-8 h-8 text-blue-400 mb-4 opacity-80"></i>
        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Total Investment</p>
        <h3 class="text-2xl font-black text-white">{{ $settings['platform_currency_symbol'] ?? '$' }}{{ number_format($stats['total_investment'], 2) }}</h3>
    </div>

    <div class="glass-panel p-6 rounded-2xl relative overflow-hidden group border-amber-500/20">
        <div class="absolute inset-0 bg-gradient-to-r from-amber-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
        <i data-lucide="award" class="w-8 h-8 text-amber-500 mb-4 opacity-80"></i>
        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Network Team Base</p>
        <h3 class="text-xl font-black text-white">Team: <span class="text-amber-500">{{ $stats['team_size'] }}</span> | Direct: <span class="text-amber-500">{{ $stats['direct_referrals'] }}</span></h3>
    </div>
</div>

<!-- Quick Actions -->
<div class="mb-10">
    <h2 class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-4">Quick Actions</h2>
    <div class="flex flex-wrap gap-4">
        <a href="{{ route('invest.create') }}" class="px-6 py-3 rounded-xl bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-500 hover:to-indigo-500 text-white text-xs font-bold uppercase tracking-wider transition-all shadow-lg shadow-purple-900/40 flex items-center gap-2 animate-pulse hover:animate-none border border-purple-400/30">
            <i data-lucide="plus-circle" class="w-4 h-4"></i> Invest Now
        </a>
        <a href="{{ route('team.index') }}" class="px-6 py-3 rounded-xl glass-panel text-white text-xs font-bold uppercase tracking-wider hover:bg-white/10 transition-all flex items-center gap-2"><i data-lucide="users" class="w-4 h-4"></i> View Network</a>
        <a href="{{ route('withdraw.create') }}" class="px-6 py-3 rounded-xl glass-panel text-white text-xs font-bold uppercase tracking-wider hover:bg-white/10 transition-all flex items-center gap-2"><i data-lucide="arrow-up-right" class="w-4 h-4"></i> Withdraw</a>
        <a href="{{ route('referrals.index') }}" class="px-6 py-3 rounded-xl glass-panel text-white text-xs font-bold uppercase tracking-wider hover:bg-white/10 transition-all flex items-center gap-2"><i data-lucide="user-plus" class="w-4 h-4"></i> Invite Friends</a>
    </div>
</div>

<!-- Club Target Progress -->
<div class="mb-10">
    @php
        $clubLevels = [
            ['id' => 1, 'direct' => 5000,  'team' => 15000,  'reward' => 500],
            ['id' => 2, 'direct' => 7000,  'team' => 20000,  'reward' => 1000],
            ['id' => 3, 'direct' => 10000, 'team' => 40000,  'reward' => 2000],
            ['id' => 4, 'direct' => 15000, 'team' => 100000, 'reward' => 2500],
            ['id' => 5, 'direct' => 20000, 'team' => 200000, 'reward' => 3000],
            ['id' => 6, 'direct' => 30000, 'team' => 300000, 'reward' => 3500],
            ['id' => 7, 'direct' => 50000, 'team' => 700000, 'reward' => 5000],
        ];
        
        $nextClub = null;
        $highestQualified = 0;
        foreach($clubLevels as $lvl) {
            if ($stats['direct_business'] >= $lvl['direct'] && $stats['team_business'] >= $lvl['team']) {
                $highestQualified = $lvl['id'];
            } else {
                $nextClub = $lvl;
                break;
            }
        }
        
        // Default to last club if all cleared
        if (!$nextClub) $nextClub = end($clubLevels);
    @endphp

    <div class="flex items-center justify-between mb-4">
        <div>
            <h2 class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Club Reward Progress ({{ $highestQualified > 0 ? 'Last: Club '.$highestQualified : 'Initial Milestone' }})</h2>
            <p class="text-[11px] text-white font-bold mt-1">Next: Club {{ $nextClub['id'] }} Reward - {{ $settings['platform_currency_symbol'] ?? '$' }}{{ number_format($nextClub['reward'], 0) }}</p>
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
                <span class="text-xs font-black text-white">{{ $settings['platform_currency_symbol'] ?? '$' }}{{ number_format($stats['direct_business'], 0) }} / {{ $settings['platform_currency_symbol'] ?? '$' }}{{ number_format($nextClub['direct'], 0) }}</span>
            </div>
            <div class="w-full bg-white/5 h-2 rounded-full overflow-hidden">
                <div class="bg-gradient-to-r from-purple-600 to-indigo-600 h-full transition-all duration-1000" style="width: {{ min(($stats['direct_business'] / $nextClub['direct']) * 100, 100) }}%"></div>
            </div>
        </div>
        <div class="glass-panel p-6 rounded-2xl relative overflow-hidden group">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <div class="flex justify-between items-center mb-4">
                <span class="text-xs font-bold text-white uppercase tracking-wider">Team Business</span>
                <span class="text-xs font-black text-white">{{ $settings['platform_currency_symbol'] ?? '$' }}{{ number_format($stats['team_business'], 0) }} / {{ $settings['platform_currency_symbol'] ?? '$' }}{{ number_format($nextClub['team'], 0) }}</span>
            </div>
            <div class="w-full bg-white/5 h-2 rounded-full overflow-hidden">
                <div class="bg-gradient-to-r from-blue-600 to-emerald-600 h-full transition-all duration-1000" style="width: {{ min(($stats['team_business'] / $nextClub['team']) * 100, 100) }}%"></div>
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
