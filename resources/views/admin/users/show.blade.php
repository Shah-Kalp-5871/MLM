@extends('layouts.admin')

@section('content')
<div class="space-y-8" x-data="{ activeTab: 'overview' }">
    <!-- Breadcrumbs & Actions -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-slate-500">
            <a href="{{ route('admin.users.index') }}" class="hover:text-purple-400">Users</a>
            <i data-lucide="chevron-right" class="w-3 h-3"></i>
            <span class="text-slate-200">User Details #{{ $user->id }}</span>
        </div>
        <div class="flex items-center gap-3">
             <form action="{{ route('admin.users.update-status', $user->id) }}" method="POST">
                @csrf
                <input type="hidden" name="status" value="{{ $user->status == 'active' ? 'blocked' : 'active' }}">
                <button class="bg-red-500/10 text-red-500 border border-red-500/20 px-6 py-2 rounded-xl text-xs font-black uppercase hover:bg-red-500 hover:text-white transition-all shadow-lg shadow-red-500/10">
                    {{ $user->status == 'active' ? 'Block Account' : 'Activate Account' }}
                </button>
             </form>
             <a href="{{ route('admin.users.edit', $user->id) }}" class="glass px-6 py-2 rounded-xl text-xs font-black uppercase hover:bg-white/10 transition-all">Edit Profile</a>
             <button class="btn-gradient px-8 py-2 rounded-xl text-xs font-black uppercase shadow-lg shadow-purple-600/20 italic tracking-widest">Login As User</button>
        </div>
    </div>

    <!-- Header Card -->
    <div class="glass p-8 rounded-[2rem] border border-white/5 relative overflow-hidden">
        <div class="absolute -right-20 -top-20 w-96 h-96 bg-purple-600/10 rounded-full blur-3xl"></div>
        <div class="absolute -left-20 -bottom-20 w-96 h-96 bg-blue-600/5 rounded-full blur-3xl"></div>
        
        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center gap-8">
            <div class="w-32 h-32 rounded-[2.5rem] bg-gradient-to-br from-slate-800 to-slate-900 border-4 border-[#1f1f1f] flex items-center justify-center text-5xl font-black text-slate-200 shadow-2xl relative">
                {{ strtoupper(substr($user->name, 0, 1)) }}
                <div class="absolute -bottom-2 -right-2 w-10 h-10 rounded-2xl {{ $user->status == 'active' ? 'bg-emerald-500' : 'bg-red-500' }} border-4 border-[#050505] flex items-center justify-center shadow-lg">
                    <i data-lucide="{{ $user->status == 'active' ? 'check' : 'x' }}" class="w-5 h-5 text-white"></i>
                </div>
            </div>
            
            <div class="flex-1 space-y-4">
                <div>
                    <h1 class="text-4xl font-black text-white leading-tight tracking-tight">{{ $user->name }}</h1>
                    <div class="flex flex-wrap items-center gap-4 mt-2">
                        <span class="flex items-center gap-2 text-slate-400 font-medium text-sm">
                            <i data-lucide="mail" class="w-4 h-4"></i> {{ $user->email }}
                        </span>
                        <span class="flex items-center gap-2 text-slate-400 font-medium text-sm border-l border-white/10 pl-4">
                            <i data-lucide="phone" class="w-4 h-4"></i> {{ $user->phone ?? 'No Phone' }}
                        </span>
                        <span class="bg-[#121212] text-purple-400 border border-purple-600/30 text-[10px] px-3 py-1 rounded-full uppercase font-black italic ml-2">
                            Ref Code: {{ $user->referral_code }}
                        </span>
                    </div>
                </div>
                
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 pt-4 border-t border-white/5">
                    <div>
                        <p class="text-[10px] text-slate-500 font-black uppercase tracking-widest">Joined On</p>
                        <p class="text-lg font-bold text-slate-200">{{ $user->created_at->format('d M, Y') }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] text-slate-500 font-black uppercase tracking-widest">Upline</p>
                        <p class="text-lg font-bold text-purple-400 truncate">{{ $user->upline->name ?? 'Direct System' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] text-slate-500 font-black uppercase tracking-widest">Wallet Balance</p>
                        <p class="text-lg font-bold text-emerald-400">{{ $settings['platform_currency_symbol'] ?? '$' }}{{ number_format($user->wallet->balance ?? 0, 2) }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] text-slate-500 font-black uppercase tracking-widest">Total Earned</p>
                        <p class="text-lg font-bold text-blue-400">{{ $settings['platform_currency_symbol'] ?? '$' }}{{ number_format($stats['total_roi_earned'] + $stats['total_commission_earned'], 2) }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabs Navigation -->
    <div class="flex items-center gap-2 border-b border-white/5 pb-px overflow-x-auto no-scrollbar">
        <button onclick="switchTab('overview')" id="tab-overview" class="tab-btn active px-6 py-4 text-sm font-black uppercase tracking-widest border-b-2 border-purple-500 text-purple-400 transition-all">Overview</button>
        <button onclick="switchTab('financials')" id="tab-financials" class="tab-btn px-6 py-4 text-sm font-black uppercase tracking-widest border-b-2 border-transparent text-slate-500 hover:text-slate-300 transition-all">Financials</button>
        <button onclick="switchTab('investments')" id="tab-investments" class="tab-btn px-6 py-4 text-sm font-black uppercase tracking-widest border-b-2 border-transparent text-slate-500 hover:text-slate-300 transition-all">Investments</button>
        <button onclick="switchTab('network')" id="tab-network" class="tab-btn px-6 py-4 text-sm font-black uppercase tracking-widest border-b-2 border-transparent text-slate-500 hover:text-slate-300 transition-all">Network Tree</button>
        <button onclick="switchTab('earnings')" id="tab-earnings" class="tab-btn px-6 py-4 text-sm font-black uppercase tracking-widest border-b-2 border-transparent text-slate-500 hover:text-slate-300 transition-all">Earnings Log</button>
        <button onclick="switchTab('transactions')" id="tab-transactions" class="tab-btn px-6 py-4 text-sm font-black uppercase tracking-widest border-b-2 border-transparent text-slate-500 hover:text-slate-300 transition-all">Wallet History</button>
        <button onclick="switchTab('vouchers')" id="tab-vouchers" class="tab-btn px-6 py-4 text-sm font-black uppercase tracking-widest border-b-2 border-transparent text-slate-500 hover:text-slate-300 transition-all">Vouchers</button>
    </div>

    <!-- Tab Contents -->
    <div id="content-overview" class="tab-content block animate-in fade-in slide-in-from-bottom-4 duration-500">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Profile Detailed Info -->
            <div class="glass p-8 rounded-[2rem] space-y-6">
                <h3 class="text-sm font-black uppercase tracking-widest text-white flex items-center gap-2">
                    <i data-lucide="user-circle" class="w-4 h-4 text-purple-500"></i> Personal Information
                </h3>
                <div class="space-y-4">
                    <div class="flex justify-between items-center py-3 border-b border-white/5">
                        <span class="text-xs text-slate-500 font-bold uppercase">Full Name</span>
                        <span class="text-sm text-slate-200 font-black">{{ $user->name }}</span>
                    </div>
                    <div class="flex justify-between items-center py-3 border-b border-white/5">
                        <span class="text-xs text-slate-500 font-bold uppercase">Email Address</span>
                        <span class="text-sm text-slate-200 font-black">{{ $user->email }}</span>
                    </div>
                    <div class="flex justify-between items-center py-3 border-b border-white/5">
                        <span class="text-xs text-slate-500 font-bold uppercase">Phone Number</span>
                        <span class="text-sm text-slate-200 font-black">{{ $user->phone ?? 'N/A' }}</span>
                    </div>
                    <div class="flex justify-between items-center py-3 border-b border-white/5">
                        <span class="text-xs text-slate-500 font-bold uppercase">Country</span>
                        <span class="text-sm text-slate-200 font-black">{{ $user->profile->country ?? 'N/A' }}</span>
                    </div>
                    <div class="flex justify-between items-center py-3 border-b border-white/5">
                        <span class="text-xs text-slate-500 font-bold uppercase">KYC Status</span>
                        <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase {{ ($user->profile->kyc_status ?? 'pending') == 'verified' ? 'bg-emerald-500/10 text-emerald-500' : 'bg-amber-500/10 text-amber-500' }}">
                            {{ $user->profile->kyc_status ?? 'Pending' }}
                        </span>
                    </div>
                    <div class="pt-4">
                        <p class="text-[10px] text-slate-500 font-black uppercase tracking-widest mb-2">Address</p>
                        <p class="text-sm text-slate-300 italic">{{ $user->profile->address ?? 'No address provided' }}</p>
                    </div>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="lg:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="glass p-8 rounded-[2rem] border-l-4 border-emerald-500 relative group overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-24 h-24 bg-emerald-500/10 rounded-full blur-2xl group-hover:bg-emerald-500/20 transition-all"></div>
                    <p class="text-xs font-black text-slate-500 uppercase tracking-widest mb-2 flex items-center gap-2">
                        <i data-lucide="wallet" class="w-4 h-4 text-emerald-500"></i> Total Deposited
                    </p>
                    <h4 class="text-4xl font-black text-white leading-none">
                        {{ $settings['platform_currency_symbol'] ?? '$' }}{{ number_format($stats['total_deposited'], 2) }}
                    </h4>
                    <p class="text-[10px] text-emerald-500 font-bold mt-4 uppercase">Direct Business: {{ $settings['platform_currency_symbol'] ?? '$' }}{{ number_format($stats['direct_business'], 2) }}</p>
                </div>

                <div class="glass p-8 rounded-[2rem] border-l-4 border-rose-500 relative group overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-24 h-24 bg-rose-500/10 rounded-full blur-2xl group-hover:bg-rose-500/20 transition-all"></div>
                    <p class="text-xs font-black text-slate-500 uppercase tracking-widest mb-2 flex items-center gap-2">
                        <i data-lucide="arrow-up-circle" class="w-4 h-4 text-rose-500"></i> Total Withdrawn
                    </p>
                    <h4 class="text-4xl font-black text-white leading-none">
                        {{ $settings['platform_currency_symbol'] ?? '$' }}{{ number_format($stats['total_withdrawn'], 2) }}
                    </h4>
                    <p class="text-[10px] text-rose-500 font-bold mt-4 uppercase">{{ $stats['pending_withdrawals'] }} Pending Requests</p>
                </div>

                <div class="glass p-8 rounded-[2rem] border-l-4 border-blue-500 relative group overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-24 h-24 bg-blue-500/10 rounded-full blur-2xl group-hover:bg-blue-500/20 transition-all"></div>
                    <p class="text-xs font-black text-slate-500 uppercase tracking-widest mb-2 flex items-center gap-2">
                        <i data-lucide="layers" class="w-4 h-4 text-blue-500"></i> Active Investments
                    </p>
                    <h4 class="text-4xl font-black text-white leading-none">
                        {{ $stats['active_investments'] }} / {{ $stats['total_investments'] }}
                    </h4>
                    <p class="text-[10px] text-blue-500 font-bold mt-4 uppercase">Volume: {{ $settings['platform_currency_symbol'] ?? '$' }}{{ number_format($stats['total_investment_amount'], 2) }}</p>
                </div>

                <div class="glass p-8 rounded-[2rem] border-l-4 border-purple-600 relative group overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-24 h-24 bg-purple-600/10 rounded-full blur-2xl group-hover:bg-purple-600/20 transition-all"></div>
                    <p class="text-xs font-black text-slate-500 uppercase tracking-widest mb-2 flex items-center gap-2">
                        <i data-lucide="users" class="w-4 h-4 text-purple-600"></i> Team Impact
                    </p>
                    <h4 class="text-4xl font-black text-white leading-none">
                        {{ number_format($stats['total_team_size']) }}
                    </h4>
                    <p class="text-[10px] text-purple-400 font-bold mt-4 uppercase">Business: {{ $settings['platform_currency_symbol'] ?? '$' }}{{ number_format($stats['team_investment_volume'], 2) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Financials Tab -->
    <div id="content-financials" class="tab-content hidden animate-in fade-in slide-in-from-bottom-4 duration-500">
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-8">
            <!-- Deposits List -->
            <div class="glass rounded-[2rem] overflow-hidden">
                <div class="p-8 border-b border-white/5 flex items-center justify-between">
                    <h3 class="font-black flex items-center gap-3 uppercase italic text-sm tracking-widest">
                        <i data-lucide="arrow-down-to-line" class="w-5 h-5 text-emerald-500"></i> Recent Deposits
                    </h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-black/20 text-slate-500 uppercase font-black tracking-widest">
                            <tr>
                                <th class="px-6 py-4">Amount</th>
                                <th class="px-6 py-4">Method</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4 text-right">Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @forelse($user->deposits()->latest()->limit(10)->get() as $dep)
                            <tr class="hover:bg-white/[0.02]">
                                <td class="px-6 py-4 font-black text-slate-200">{{ $settings['platform_currency_symbol'] ?? '$' }}{{ number_format($dep->amount, 2) }}</td>
                                <td class="px-6 py-4 text-slate-400">{{ $dep->payment_method }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-0.5 rounded text-[9px] font-black uppercase {{ $dep->status == 'approved' ? 'bg-emerald-500/10 text-emerald-500' : 'bg-amber-500/10 text-amber-500' }}">
                                        {{ $dep->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right text-slate-500">{{ $dep->created_at->format('d M, y') }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="p-10 text-center italic text-slate-600">No deposits found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Withdrawals List -->
            <div class="glass rounded-[2rem] overflow-hidden">
                <div class="p-8 border-b border-white/5 flex items-center justify-between">
                    <h3 class="font-black flex items-center gap-3 uppercase italic text-sm tracking-widest">
                        <i data-lucide="arrow-up-from-line" class="w-5 h-5 text-rose-500"></i> Recent Withdrawals
                    </h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-black/20 text-slate-500 uppercase font-black tracking-widest">
                            <tr>
                                <th class="px-6 py-4">Amount</th>
                                <th class="px-6 py-4">Method</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4 text-right">Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @forelse($user->withdrawals()->latest()->limit(10)->get() as $with)
                            <tr class="hover:bg-white/[0.02]">
                                <td class="px-6 py-4 font-black text-slate-200">{{ $settings['platform_currency_symbol'] ?? '$' }}{{ number_format($with->amount, 2) }}</td>
                                <td class="px-6 py-4 text-slate-400">{{ $with->payment_method }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-0.5 rounded text-[9px] font-black uppercase {{ $with->status == 'approved' ? 'bg-emerald-500/10 text-emerald-500' : ($with->status == 'pending' ? 'bg-amber-500/10 text-amber-500' : 'bg-rose-500/10 text-rose-500') }}">
                                        {{ $with->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right text-slate-500">{{ $with->created_at->format('d M, y') }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="p-10 text-center italic text-slate-600">No withdrawals found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Investments Tab -->
    <div id="content-investments" class="tab-content hidden animate-in fade-in slide-in-from-bottom-4 duration-500">
        <div class="glass rounded-[2rem] overflow-hidden">
            <div class="p-8 border-b border-white/5 flex items-center justify-between">
                <h3 class="font-black flex items-center gap-3 uppercase italic text-sm tracking-widest">
                    <i data-lucide="gem" class="w-5 h-5 text-blue-500"></i> Investment Portfolio
                </h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-black/20 text-slate-500 uppercase text-[10px] font-black tracking-widest">
                        <tr>
                            <th class="px-8 py-5">Investment ID</th>
                            <th class="px-8 py-5">Amount</th>
                            <th class="px-8 py-5">Plan</th>
                            <th class="px-8 py-5">Returns (ROI)</th>
                            <th class="px-8 py-5">Status</th>
                            <th class="px-8 py-5 text-right">Activated At</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @forelse($user->investments->sortByDesc('created_at') as $inv)
                        <tr class="hover:bg-white/[0.02]">
                            <td class="px-8 py-5 font-mono text-xs text-slate-400">#INV-{{ str_pad($inv->id, 6, '0', STR_PAD_LEFT) }}</td>
                            <td class="px-8 py-5 font-black text-slate-200">{{ $settings['platform_currency_symbol'] ?? '$' }}{{ number_format($inv->amount, 2) }}</td>
                            <td class="px-8 py-5">
                                <span class="bg-blue-500/10 text-blue-400 border border-blue-500/20 text-[10px] px-3 py-1 rounded-lg uppercase font-black">
                                    {{ $inv->weekly_roi_percentage }}% Weekly
                                </span>
                            </td>
                            <td class="px-8 py-5 text-emerald-400 font-bold">
                                {{ $settings['platform_currency_symbol'] ?? '$' }}{{ number_format($inv->roiIncomes->sum('roi_amount'), 2) }}
                            </td>
                            <td class="px-8 py-5">
                                <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase {{ $inv->status == 'active' ? 'bg-emerald-500/10 text-emerald-500' : 'bg-slate-800 text-slate-500' }}">
                                    {{ $inv->status }}
                                </span>
                            </td>
                            <td class="px-8 py-5 text-right text-xs text-slate-500 uppercase font-bold">{{ $inv->created_at->format('d M, Y • H:i') }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="p-20 text-center italic text-slate-600">No active or past investments found for this user.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Network Tab -->
    <div id="content-network" class="tab-content hidden animate-in fade-in slide-in-from-bottom-4 duration-500">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Referrer Info -->
            <div class="lg:col-span-1 space-y-6">
                <div class="glass p-6 rounded-3xl border-l-4 border-purple-500">
                    <p class="text-[10px] text-slate-500 font-black uppercase tracking-widest mb-1">Direct Referrer</p>
                    <p class="text-xl font-black text-white">{{ $user->upline->name ?? 'System Admin' }}</p>
                    <p class="text-[10px] text-purple-400 font-bold mt-2 uppercase italic">{{ $user->upline->email ?? 'ROOT' }}</p>
                </div>
                
                <div class="glass p-6 rounded-3xl">
                    <h4 class="text-xs font-black uppercase tracking-widest text-slate-200 mb-4 border-b border-white/5 pb-2">Network Summary</h4>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-[10px] text-slate-500 font-black uppercase">Direct Referrals</span>
                            <span class="text-sm font-black text-white">{{ $stats['direct_referrals'] }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-[10px] text-slate-500 font-black uppercase">Total Team Size</span>
                            <span class="text-sm font-black text-white">{{ number_format($stats['total_team_size']) }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-[10px] text-slate-500 font-black uppercase">Team Volume</span>
                            <span class="text-sm font-black text-emerald-400">{{ $settings['platform_currency_symbol'] ?? '$' }}{{ number_format($stats['team_investment_volume'], 2) }}</span>
                        </div>
                    </div>
                </div>
                
                <a href="{{ route('admin.network.index', ['search' => $user->email]) }}" class="btn-gradient w-full py-4 rounded-3xl flex items-center justify-center gap-3 font-black uppercase italic text-xs tracking-widest shadow-xl shadow-purple-600/20">
                    <i data-lucide="network" class="w-4 h-4"></i> Interactive Tree View
                </a>
            </div>

            <!-- Referrals List -->
            <div class="lg:col-span-3 glass rounded-[2rem] overflow-hidden">
                <div class="p-8 border-b border-white/5">
                    <h3 class="font-black uppercase italic text-sm tracking-widest text-slate-200">Direct Downlines</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-black/20 text-slate-500 uppercase text-[10px] font-black tracking-widest">
                            <tr>
                                <th class="px-8 py-5">Name</th>
                                <th class="px-8 py-5">Email</th>
                                <th class="px-8 py-5">Status</th>
                                <th class="px-8 py-5">Investment</th>
                                <th class="px-8 py-5 text-right">Joined</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @forelse($user->referrals as $ref)
                            <tr class="hover:bg-white/[0.02]">
                                <td class="px-8 py-5 font-black text-slate-200">{{ $ref->name }}</td>
                                <td class="px-8 py-5 text-slate-400">{{ $ref->email }}</td>
                                <td class="px-8 py-5">
                                    <span class="px-2 py-1 rounded text-[9px] font-black uppercase {{ $ref->status == 'active' ? 'bg-emerald-500/10 text-emerald-500' : 'bg-rose-500/10 text-rose-500' }}">
                                        {{ $ref->status }}
                                    </span>
                                </td>
                                <td class="px-8 py-5 font-bold text-slate-300">
                                    {{ $settings['platform_currency_symbol'] ?? '$' }}{{ number_format($ref->investments()->sum('amount'), 2) }}
                                </td>
                                <td class="px-8 py-5 text-right text-xs text-slate-500">{{ $ref->created_at->format('d M, Y') }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="p-20 text-center italic text-slate-600">No direct referrals yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings Tab -->
    <div id="content-earnings" class="tab-content hidden animate-in fade-in slide-in-from-bottom-4 duration-500">
        <div class="glass rounded-[2rem] overflow-hidden">
            <div class="p-8 border-b border-white/5 flex items-center justify-between">
                <h3 class="font-black flex items-center gap-3 uppercase italic text-sm tracking-widest">
                    <i data-lucide="trending-up" class="w-5 h-5 text-purple-400"></i> Full Earnings Activity
                </h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-black/20 text-slate-500 uppercase text-[10px] font-black tracking-widest">
                        <tr>
                            <th class="px-8 py-5">Type</th>
                            <th class="px-8 py-5">Amount</th>
                            <th class="px-8 py-5">Description</th>
                            <th class="px-8 py-5">Source</th>
                            <th class="px-8 py-5 text-right">Timestamp</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @forelse($earnings as $earn)
                        <tr class="hover:bg-white/[0.02]">
                            <td class="px-8 py-5">
                                <span class="px-3 py-1 rounded-lg text-[9px] font-black uppercase {{ $earn->type == 'ROI' ? 'bg-amber-500/10 text-amber-500' : 'bg-purple-600/10 text-purple-400' }}">
                                    {{ $earn->type }}
                                </span>
                            </td>
                            <td class="px-8 py-5 font-black text-slate-200">
                                {{ $settings['platform_currency_symbol'] ?? '$' }}{{ number_format($earn->amount, 2) }}
                            </td>
                            <td class="px-8 py-5 text-slate-400 italic text-xs">
                                {{ $earn->description }}
                            </td>
                            <td class="px-8 py-5">
                                <span class="font-bold text-slate-300">{{ $earn->from }}</span>
                            </td>
                            <td class="px-8 py-5 text-right text-xs text-slate-500 font-bold uppercase">
                                {{ $earn->date->format('d M y • H:i') }}
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="p-20 text-center italic text-slate-600">No earnings recorded.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Transactions Tab -->
    <div id="content-transactions" class="tab-content hidden animate-in fade-in slide-in-from-bottom-4 duration-500">
        <div class="glass rounded-[2rem] overflow-hidden">
            <div class="p-8 border-b border-white/5 flex items-center justify-between">
                <h3 class="font-black flex items-center gap-3 uppercase italic text-sm tracking-widest text-slate-200">
                    <i data-lucide="list" class="w-5 h-5 text-indigo-400"></i> Full Wallet Ledger
                </h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-black/20 text-slate-500 uppercase text-[10px] font-black tracking-widest">
                        <tr>
                            <th class="px-8 py-5">Date</th>
                            <th class="px-8 py-5">Description</th>
                            <th class="px-8 py-5">Amount</th>
                            <th class="px-8 py-5">Direction</th>
                            <th class="px-8 py-5 text-right">Balance After</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @forelse($user->transactions()->latest()->limit(50)->get() as $tx)
                        <tr class="hover:bg-white/[0.02]">
                            <td class="px-8 py-5 text-slate-500 text-xs font-bold">{{ $tx->created_at->format('d M y • H:i') }}</td>
                            <td class="px-8 py-5">
                                <p class="text-slate-200 font-medium">{{ $tx->description }}</p>
                                <p class="text-[10px] text-slate-500 uppercase font-black tracking-tighter">{{ $tx->type }}</p>
                            </td>
                            <td class="px-8 py-5 font-black {{ $tx->direction == 'in' ? 'text-emerald-500' : 'text-rose-500' }}">
                                {{ $tx->direction == 'in' ? '+' : '-' }}{{ $settings['platform_currency_symbol'] ?? '$' }}{{ number_format($tx->amount, 2) }}
                            </td>
                            <td class="px-8 py-5">
                                <span class="px-2 py-0.5 rounded text-[9px] font-black uppercase {{ $tx->direction == 'in' ? 'bg-emerald-500/10 text-emerald-500' : 'bg-rose-500/10 text-rose-500' }}">
                                    {{ $tx->direction }}
                                </span>
                            </td>
                            <td class="px-8 py-5 text-right font-bold text-slate-300">
                                {{ $settings['platform_currency_symbol'] ?? '$' }}{{ number_format($tx->balance_after, 2) }}
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="p-20 text-center italic text-slate-600">No transactions recorded for this wallet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Vouchers Tab -->
    <div id="content-vouchers" class="tab-content hidden animate-in fade-in slide-in-from-bottom-4 duration-500">
        <div class="glass rounded-[2rem] overflow-hidden">
            <div class="p-8 border-b border-white/5 flex items-center justify-between">
                <h3 class="font-black flex items-center gap-3 uppercase italic text-sm tracking-widest">
                    <i data-lucide="ticket" class="w-5 h-5 text-amber-500"></i> My Vouchers
                </h3>
                <div class="flex gap-4">
                    <div class="text-right">
                        <p class="text-[10px] text-slate-500 font-black uppercase">Total Vouchers</p>
                        <p class="text-lg font-black text-white">{{ $stats['vouchers_count'] }}</p>
                    </div>
                    <div class="text-right border-l border-white/10 pl-4">
                        <p class="text-[10px] text-slate-500 font-black uppercase">Redeemed</p>
                        <p class="text-lg font-black text-amber-400">{{ $stats['vouchers_redeemed'] }}</p>
                    </div>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-black/20 text-slate-500 uppercase text-[10px] font-black tracking-widest">
                        <tr>
                            <th class="px-8 py-5">Voucher Code</th>
                            <th class="px-8 py-5">Value</th>
                            <th class="px-8 py-5">Status</th>
                            <th class="px-8 py-5">Created</th>
                            <th class="px-8 py-5 text-right">Redeemed At</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @forelse($user->vouchers as $vouch)
                        <tr class="hover:bg-white/[0.02]">
                            <td class="px-8 py-5 font-mono font-bold text-amber-400">{{ $vouch->code }}</td>
                            <td class="px-8 py-5 font-black text-slate-200">{{ $settings['platform_currency_symbol'] ?? '$' }}{{ number_format($vouch->amount, 2) }}</td>
                            <td class="px-8 py-5">
                                <span class="px-2 py-0.5 rounded text-[9px] font-black uppercase {{ $vouch->used_at ? 'bg-rose-500/10 text-rose-500' : 'bg-emerald-500/10 text-emerald-500' }}">
                                    {{ $vouch->used_at ? 'Redeemed' : 'Active' }}
                                </span>
                            </td>
                            <td class="px-8 py-5 text-slate-500 text-xs">{{ $vouch->created_at->format('d M, Y') }}</td>
                            <td class="px-8 py-5 text-right text-xs font-bold {{ $vouch->used_at ? 'text-slate-300' : 'text-slate-600' }}">
                                {{ $vouch->used_at ? $vouch->used_at->format('d M Y • H:i') : 'Not Redeemed' }}
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="p-20 text-center italic text-slate-600">No vouchers found for this user.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .tab-btn.active {
        border-bottom-color: #a855f7;
        color: #a855f7;
    }
    .no-scrollbar::-webkit-scrollbar {
        display: none;
    }
    .no-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>

<script>
    function switchTab(tabId) {
        // Hide all contents
        document.querySelectorAll('.tab-content').forEach(content => {
            content.classList.add('hidden');
            content.classList.remove('block');
        });
        
        // Show active content
        document.getElementById('content-' + tabId).classList.remove('hidden');
        document.getElementById('content-' + tabId).classList.add('block');
        
        // Reset all buttons
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.remove('border-purple-500', 'text-purple-400');
            btn.classList.add('border-transparent', 'text-slate-500');
        });
        
        // Set active button
        const activeBtn = document.getElementById('tab-' + tabId);
        activeBtn.classList.remove('border-transparent', 'text-slate-500');
        activeBtn.classList.add('border-purple-500', 'text-purple-400');
        
        // Re-create icons for new content
        if (window.lucide) {
            window.lucide.createIcons();
        }
    }
</script>
@endsection
