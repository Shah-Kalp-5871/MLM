@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    <!-- Breadcrumbs & Actions -->
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-slate-500">
            <a href="{{ route('admin.users.index') }}" class="hover:text-purple-400">Users</a>
            <i data-lucide="chevron-right" class="w-3 h-3"></i>
            <span class="text-slate-200">User Overview #{{ $user->id }}</span>
        </div>
        <div class="flex items-center gap-3">
             <form action="{{ route('admin.users.update-status', $user->id) }}" method="POST">
                @csrf
                <input type="hidden" name="status" value="{{ $user->status == 'active' ? 'blocked' : 'active' }}">
                <button class="bg-red-500/10 text-red-500 border border-red-500/20 px-6 py-2 rounded-xl text-xs font-black uppercase hover:bg-red-500 hover:text-white transition-all shadow-lg shadow-red-500/10">
                    {{ $user->status == 'active' ? 'Block User' : 'Unblock User' }}
                </button>
             </form>
             <button class="btn-gradient px-8 py-2 rounded-xl text-xs font-black uppercase shadow-lg shadow-purple-600/20 italic tracking-widest">Login As User</button>
        </div>
    </div>

    <!-- User Information & Wallet -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Profile Card -->
        <div class="glass p-8 rounded-[2rem] border border-white/5 relative overflow-hidden flex flex-col items-center text-center">
            <div class="absolute -right-20 -top-20 w-64 h-64 bg-purple-600/10 rounded-full blur-3xl"></div>
            <div class="w-24 h-24 rounded-3xl bg-gradient-to-br from-slate-800 to-slate-900 border-2 border-[#1f1f1f] flex items-center justify-center text-4xl font-black text-slate-200 shadow-2xl mb-6 relative z-10">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div class="relative z-10 space-y-2">
                <h1 class="text-3xl font-black text-white leading-tight">{{ $user->name }}</h1>
                <p class="text-slate-400 font-medium text-sm">{{ $user->email }}</p>
                <div class="flex flex-center gap-3 mt-4">
                    <span class="badge {{ $user->status == 'active' ? 'badge-success' : 'badge-danger' }} text-[10px] px-3 py-1 rounded-full uppercase font-black tracking-widest">{{ $user->status }} Status</span>
                    <span class="bg-[#121212] text-purple-400 border border-purple-600/30 text-[10px] px-3 py-1 rounded-full uppercase font-black italic">Ref: {{ $user->referral_code }}</span>
                </div>
            </div>
            <div class="w-full mt-8 pt-8 border-t border-[#1f1f1f] grid grid-cols-2 gap-4">
                <div class="text-left">
                    <p class="text-[10px] text-slate-500 font-black uppercase tracking-widest">Joined On</p>
                    <p class="text-sm font-bold text-slate-200 mt-1">{{ $user->created_at->format('d M, Y') }}</p>
                </div>
                <div class="text-left border-l border-[#1f1f1f] pl-4">
                    <p class="text-[10px] text-slate-500 font-black uppercase tracking-widest">Reports To</p>
                    <p class="text-sm font-bold text-slate-200 mt-1 truncate">{{ $user->upline->name ?? 'System' }}</p>
                </div>
            </div>
        </div>

        <!-- Wallet Stats -->
        <div class="lg:col-span-2 glass rounded-[2rem] p-8 grid grid-cols-2 md:grid-cols-3 gap-8">
            <div class="space-y-1">
                <p class="text-xs font-black text-slate-500 uppercase tracking-widest mb-2 flex items-center gap-2">
                    <i data-lucide="wallet" class="w-3 h-3 text-emerald-500"></i> Balance
                </p>
                <p class="text-3xl font-black text-emerald-400 leading-none">
                    {{ $settings['platform_currency_symbol'] ?? '$' }}{{ number_format($user->wallet->balance ?? 0, 2) }}
                </p>
            </div>
            <div class="space-y-1 border-l border-[#1f1f1f] pl-4 md:pl-8">
                <p class="text-xs font-black text-slate-500 uppercase tracking-widest mb-2 flex items-center gap-2">
                    <i data-lucide="arrow-down" class="w-3 h-3 text-blue-500"></i> Deposited
                </p>
                <p class="text-3xl font-black text-slate-100 leading-none">
                    {{ $settings['platform_currency_symbol'] ?? '$' }}{{ number_format($stats['total_deposited'], 2) }}
                </p>
            </div>
            <div class="space-y-1 border-l border-[#1f1f1f] pl-4 md:pl-8">
                <p class="text-xs font-black text-slate-500 uppercase tracking-widest mb-2 flex items-center gap-2">
                    <i data-lucide="arrow-up" class="w-3 h-3 text-red-400"></i> Withdrawn
                </p>
                <p class="text-3xl font-black text-slate-100 leading-none">
                    {{ $settings['platform_currency_symbol'] ?? '$' }}{{ number_format($stats['total_withdrawn'], 2) }}
                </p>
            </div>
            <div class="space-y-1 pt-4">
                <p class="text-xs font-black text-slate-500 uppercase tracking-widest mb-2 flex items-center gap-2">
                    <i data-lucide="zap" class="w-3 h-3 text-amber-500"></i> ROI Earned
                </p>
                <p class="text-3xl font-black text-amber-500 leading-none">
                    {{ $settings['platform_currency_symbol'] ?? '$' }}{{ number_format($stats['total_roi_earned'], 2) }}
                </p>
            </div>
            <div class="space-y-1 border-l border-[#1f1f1f] pl-4 md:pl-8 pt-4">
                <p class="text-xs font-black text-slate-500 uppercase tracking-widest mb-2 flex items-center gap-2">
                    <i data-lucide="users" class="w-3 h-3 text-purple-400"></i> Commissions
                </p>
                <p class="text-3xl font-black text-purple-400 leading-none">
                    {{ $settings['platform_currency_symbol'] ?? '$' }}{{ number_format($stats['total_commission_earned'], 2) }}
                </p>
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Investment Info -->
        <div class="glass p-6 rounded-3xl group border-l-4 border-blue-500">
            <h4 class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1">Active Investments</h4>
            <p class="text-2xl font-black">{{ $stats['active_investments'] }} / {{ $stats['total_investments'] }}</p>
            <p class="text-[10px] text-blue-400 font-bold mt-2 uppercase">Volume: {{ $settings['platform_currency_symbol'] ?? '$' }}{{ number_format($stats['total_investment_amount'], 2) }}</p>
        </div>
        <!-- Team Stats -->
        <div class="glass p-6 rounded-3xl group border-l-4 border-purple-600">
            <h4 class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1">Total Team Size</h4>
            <p class="text-2xl font-black">{{ number_format($stats['total_team_size']) }}</p>
            <p class="text-[10px] text-purple-400 font-bold mt-2 uppercase">Direct Referrals: {{ $stats['direct_referrals'] }}</p>
        </div>
        <!-- Team Volume -->
        <div class="glass p-6 rounded-3xl group border-l-4 border-emerald-500">
            <h4 class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1">Team Volume</h4>
            <p class="text-2xl font-black">{{ $settings['platform_currency_symbol'] ?? '$' }}{{ number_format($stats['team_investment_volume'], 2) }}</p>
            <p class="text-[10px] text-emerald-400 font-bold mt-2 uppercase italic">Verified Business</p>
        </div>
        <!-- Network Link -->
        <a href="{{ route('admin.network.index', ['search' => $user->email]) }}" class="glass p-6 rounded-3xl group border-l-4 border-amber-500 hover:bg-amber-500/5 transition-all">
            <h4 class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1">Network Tree</h4>
            <p class="text-2xl font-black flex items-center justify-between">
                Explore <i data-lucide="chevron-right" class="w-6 h-6 text-amber-500 group-hover:translate-x-1 transition-transform"></i>
            </p>
            <p class="text-[10px] text-amber-400 font-bold mt-2 uppercase">View Hierarchy</p>
        </a>
    </div>

    <!-- Recent Earnings Table -->
    <div class="glass rounded-[2rem] overflow-hidden">
        <div class="p-8 border-b border-[#1f1f1f] flex items-center justify-between bg-white/[0.01]">
            <h3 class="font-black flex items-center gap-3 tracking-tight text-lg uppercase italic">
                <i data-lucide="trending-up" class="w-6 h-6 text-purple-400"></i>
                Recent Earnings activity
            </h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-[#0c0c0c] text-slate-500 uppercase text-[10px] font-black tracking-widest">
                    <tr>
                        <th class="px-8 py-5">Activity Type</th>
                        <th class="px-8 py-5">Amount</th>
                        <th class="px-8 py-5">Source</th>
                        <th class="px-8 py-5">Investment Reference</th>
                        <th class="px-8 py-5 text-right">Timestamp</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#1f1f1f]">
                    @forelse($earnings as $earn)
                    <tr class="hover:bg-white/[0.02] transition-colors">
                        <td class="px-8 py-5">
                            <span class="font-black uppercase text-[10px] tracking-tighter px-3 py-1 rounded-lg {{ $earn->type == 'ROI' ? 'bg-amber-500/10 text-amber-500 border border-amber-500/20' : 'bg-purple-600/10 text-purple-400 border border-purple-600/20' }}">
                                {{ $earn->type }}
                            </span>
                        </td>
                        <td class="px-8 py-5 font-black text-slate-200">
                            {{ $settings['platform_currency_symbol'] ?? '$' }}{{ number_format($earn->amount, 2) }}
                        </td>
                        <td class="px-8 py-5">
                            <span class="text-slate-400 font-medium italic">{{ $earn->from }}</span>
                        </td>
                        <td class="px-8 py-5">
                            <span class="text-xs font-mono text-slate-500">
                                {{ $earn->id ? '#INV-' . str_pad($earn->id, 5, '0', STR_PAD_LEFT) : '—' }}
                            </span>
                        </td>
                        <td class="px-8 py-5 text-right text-xs text-slate-500 font-bold uppercase">
                            {{ $earn->date->format('d M y • H:i') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-20 text-center text-slate-600 italic">
                            No recent earnings data available for this account.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

