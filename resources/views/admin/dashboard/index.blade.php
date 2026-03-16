@extends('layouts.admin')

@section('content')
<div class="space-y-10">
    
    <!-- Hero Section -->
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
        <div>
            <h1 class="text-3xl font-extrabold tracking-tight">Platform Overview</h1>
            <p class="text-slate-400 mt-1">Real-time control center for NexaNet MLM ecosystem.</p>
        </div>
        <div class="flex items-center gap-3">
            <button class="bg-[#121212] border border-[#1f1f1f] px-4 py-2 rounded-xl text-sm font-medium hover:border-slate-700 transition-all flex items-center gap-2">
                <i data-lucide="download" class="w-4 h-4"></i> Export Report
            </button>
            <button class="btn-gradient px-6 py-2 rounded-xl text-sm font-bold shadow-lg shadow-purple-600/10 flex items-center gap-2">
                <i data-lucide="zap" class="w-4 h-4"></i> Run ROI Batch
            </button>
        </div>
    </div>

    <!-- Quick Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
        <!-- Card 1 -->
        <div class="stats-card p-6 rounded-2xl relative overflow-hidden group">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-purple-600/10 rounded-full blur-3xl group-hover:bg-purple-600/20 transition-all"></div>
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-xl bg-purple-600/10 flex items-center justify-center text-purple-500">
                    <i data-lucide="users" class="w-6 h-6"></i>
                </div>
            </div>
            <h3 class="text-slate-400 text-sm font-medium">Total Network Users</h3>
            <p class="text-2xl font-bold mt-1">{{ number_format($stats['total_users']) }}</p>
        </div>

        <!-- Card 2 -->
        <div class="stats-card p-6 rounded-2xl relative overflow-hidden group">
             <div class="absolute -right-4 -top-4 w-24 h-24 bg-blue-600/10 rounded-full blur-3xl group-hover:bg-blue-600/20 transition-all"></div>
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-xl bg-blue-600/10 flex items-center justify-center text-blue-500">
                    <i data-lucide="wallet" class="w-6 h-6"></i>
                </div>
            </div>
            <h3 class="text-slate-400 text-sm font-medium">Total Approved Deposits</h3>
            <p class="text-2xl font-bold mt-1">₹{{ number_format($stats['total_business'], 2) }}</p>
        </div>

        <!-- Card 3 -->
        <div class="stats-card p-6 rounded-2xl relative overflow-hidden group">
             <div class="absolute -right-4 -top-4 w-24 h-24 bg-green-600/10 rounded-full blur-3xl group-hover:bg-green-600/20 transition-all"></div>
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-xl bg-green-600/10 flex items-center justify-center text-green-500">
                    <i data-lucide="database" class="w-6 h-6"></i>
                </div>
            </div>
            <h3 class="text-slate-400 text-sm font-medium">Active Investments</h3>
            <p class="text-2xl font-bold mt-1">₹{{ number_format($stats['active_investments'], 2) }}</p>
        </div>

        <!-- Card 4 -->
        <div class="stats-card p-6 rounded-2xl relative overflow-hidden group border border-amber-500/10">
             <div class="absolute -right-4 -top-4 w-24 h-24 bg-amber-600/10 rounded-full blur-3xl group-hover:bg-amber-600/20 transition-all"></div>
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-xl bg-amber-600/10 flex items-center justify-center text-amber-500">
                    <i data-lucide="clock" class="w-6 h-6"></i>
                </div>
            </div>
            <h3 class="text-slate-400 text-sm font-medium">Pending Approvals</h3>
            <p class="text-2xl font-bold mt-1">{{ $stats['pending_deposits'] + $stats['withdrawals_pending'] }}</p>
        </div>
    </div>

    <!-- Tables Grid -->
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-8">
        
        <!-- Pending Deposits -->
        <div class="glass rounded-3xl overflow-hidden">
            <div class="p-6 border-b border-[#1f1f1f] flex items-center justify-between">
                <h3 class="font-bold flex items-center gap-2">
                    <i data-lucide="clock" class="w-4 h-4 text-amber-500"></i>
                    Pending Payment Approvals
                </h3>
                <a href="/admin/deposits" class="text-xs text-purple-400 hover:text-purple-300 font-bold uppercase tracking-wider">View All</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-[#0c0c0c] text-slate-500 uppercase text-[10px] font-bold">
                        <tr>
                            <th class="px-6 py-4">User</th>
                            <th class="px-6 py-4">Package</th>
                            <th class="px-6 py-4">Amount</th>
                            <th class="px-6 py-4">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#1f1f1f]">
                        @forelse($recent_deposits as $dep)
                        <tr>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-slate-800 border border-[#1f1f1f] flex items-center justify-center text-[10px] font-bold">
                                        {{ substr($dep->user->name, 0, 2) }}
                                    </div>
                                    <span class="font-medium">{{ $dep->user->name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4"><span class="text-slate-400">{{ $dep->method }}</span></td>
                            <td class="px-6 py-4 font-bold">₹{{ number_format($dep->amount, 2) }}</td>
                            <td class="px-6 py-4">
                                <a href="/admin/deposits" class="text-purple-500 hover:text-purple-400 font-bold text-xs uppercase tracking-wider underline">Review</a>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="px-6 py-8 text-center text-slate-500 italic">No pending deposits.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Recent Registered Users -->
        <div class="glass rounded-3xl overflow-hidden">
            <div class="p-6 border-b border-[#1f1f1f] flex items-center justify-between">
                <h3 class="font-bold flex items-center gap-2">
                    <i data-lucide="user-plus" class="w-4 h-4 text-blue-500"></i>
                    Recent Registrations
                </h3>
                <a href="/admin/users" class="text-xs text-purple-400 hover:text-purple-300 font-bold uppercase tracking-wider">Manage Users</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-[#0c0c0c] text-slate-500 uppercase text-[10px] font-bold">
                        <tr>
                            <th class="px-6 py-4">Member</th>
                            <th class="px-6 py-4">Upline</th>
                            <th class="px-6 py-4">Date</th>
                            <th class="px-6 py-4">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#1f1f1f]">
                        @forelse($recent_users as $u)
                        <tr>
                            <td class="px-6 py-4">
                                <span class="font-medium text-slate-200">{{ $u->name }}</span>
                            </td>
                            <td class="px-6 py-4 text-slate-400 text-xs truncate max-w-[100px]">
                                {{ $u->upline ? $u->upline->referral_code : 'Direct' }}
                            </td>
                            <td class="px-6 py-4 text-xs text-slate-500">{{ $u->created_at->diffForHumans() }}</td>
                            <td class="px-6 py-4">
                                <span class="badge-{{ $u->status == 'active' ? 'active' : 'pending' }} text-[10px] px-2 py-0.5 rounded-full uppercase font-bold">
                                    {{ $u->status }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="px-6 py-8 text-center text-slate-500 italic">No recent registrations.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection