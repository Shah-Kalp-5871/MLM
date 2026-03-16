@extends('layouts.admin')

@section('content')
<div class="space-y-10">
    
    <!-- Highlighted Payment Approvals -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Pending Deposits -->
        <div class="glass p-8 rounded-[2rem] border border-amber-500/20 bg-amber-500/5 relative overflow-hidden group">
            <div class="absolute -right-10 -top-10 w-40 h-40 bg-amber-500/10 rounded-full blur-3xl"></div>
            <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="flex items-center gap-6">
                    <div class="w-16 h-16 rounded-2xl bg-amber-500/10 flex items-center justify-center text-amber-500 border border-amber-500/20 shadow-2xl">
                        <i data-lucide="arrow-down-circle" class="w-8 h-8"></i>
                    </div>
                    <div>
                        <h3 class="text-amber-500 font-black uppercase tracking-widest text-xs">Pending Deposits</h3>
                        <p class="text-3xl font-black text-white mt-1">{{ $stats['pending_deposits_count'] }} <span class="text-sm font-medium text-slate-400">Total Requests</span></p>
                        <p class="text-xl font-bold text-amber-500/80">{{ $settings['platform_currency_symbol'] ?? '$' }}{{ number_format($stats['pending_deposits_amount'], 2) }}</p>
                    </div>
                </div>
                <a href="{{ route('admin.deposits.index') }}" class="w-full md:w-auto px-8 py-4 rounded-2xl bg-amber-500 text-black font-black text-sm hover:scale-105 transition-all shadow-xl shadow-amber-500/20 text-center">Approve Payments</a>
            </div>
        </div>

        <!-- Pending Withdrawals -->
        <div class="glass p-8 rounded-[2rem] border border-red-500/20 bg-red-500/5 relative overflow-hidden group">
            <div class="absolute -right-10 -top-10 w-40 h-40 bg-red-500/10 rounded-full blur-3xl"></div>
            <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="flex items-center gap-6">
                    <div class="w-16 h-16 rounded-2xl bg-red-500/10 flex items-center justify-center text-red-500 border border-red-500/20 shadow-2xl">
                        <i data-lucide="arrow-up-circle" class="w-8 h-8"></i>
                    </div>
                    <div>
                        <h3 class="text-red-500 font-black uppercase tracking-widest text-xs">Pending Withdrawals</h3>
                        <p class="text-3xl font-black text-white mt-1">{{ $stats['pending_withdrawals_count'] }} <span class="text-sm font-medium text-slate-400">Review Required</span></p>
                        <p class="text-xl font-bold text-red-500/80">{{ $settings['platform_currency_symbol'] ?? '$' }}{{ number_format($stats['pending_withdrawals_amount'], 2) }}</p>
                    </div>
                </div>
                <a href="{{ route('admin.withdrawals.index') }}" class="w-full md:w-auto px-8 py-4 rounded-2xl bg-red-500 text-white font-black text-sm hover:scale-105 transition-all shadow-xl shadow-red-500/20 text-center">Review Withdrawals</a>
            </div>
        </div>
    </div>

    <!-- Quick Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
        <div class="stats-card p-6 rounded-2xl relative overflow-hidden group">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-purple-600/10 flex items-center justify-center text-purple-500">
                    <i data-lucide="users" class="w-6 h-6"></i>
                </div>
                <div>
                    <h3 class="text-slate-400 text-xs font-bold uppercase tracking-tighter">Total Users</h3>
                    <p class="text-2xl font-black">{{ number_format($stats['total_users']) }}</p>
                </div>
            </div>
        </div>

        <div class="stats-card p-6 rounded-2xl relative overflow-hidden group">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-blue-600/10 flex items-center justify-center text-blue-500">
                    <i data-lucide="wallet" class="w-6 h-6"></i>
                </div>
                <div>
                    <h3 class="text-slate-400 text-xs font-bold uppercase tracking-tighter">Total Deposits</h3>
                    <p class="text-2xl font-black">{{ $settings['platform_currency_symbol'] ?? '$' }}{{ number_format($stats['total_deposits'], 2) }}</p>
                </div>
            </div>
        </div>

        <div class="stats-card p-6 rounded-2xl relative overflow-hidden group">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-green-600/10 flex items-center justify-center text-green-500">
                    <i data-lucide="database" class="w-6 h-6"></i>
                </div>
                <div>
                    <h3 class="text-slate-400 text-xs font-bold uppercase tracking-tighter">Total Investments</h3>
                    <p class="text-2xl font-black">{{ $settings['platform_currency_symbol'] ?? '$' }}{{ number_format($stats['total_investments'], 2) }}</p>
                </div>
            </div>
        </div>

        <div class="stats-card p-6 rounded-2xl relative overflow-hidden group">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-emerald-600/10 flex items-center justify-center text-emerald-500">
                    <i data-lucide="trending-up" class="w-6 h-6"></i>
                </div>
                <div>
                    <h3 class="text-slate-400 text-xs font-bold uppercase tracking-tighter">Total ROI Paid</h3>
                    <p class="text-2xl font-black">{{ $settings['platform_currency_symbol'] ?? '$' }}{{ number_format($stats['total_roi_paid'], 2) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Activity Feed -->
        <div class="lg:col-span-1 glass rounded-3xl p-6 h-fit">
            <div class="flex items-center justify-between mb-6">
                <h3 class="font-bold flex items-center gap-2">
                    <i data-lucide="activity" class="w-4 h-4 text-purple-400"></i>
                    Recent Activity
                </h3>
            </div>
            <div class="space-y-6">
                @foreach($recent_activity as $act)
                <div class="flex gap-4 relative last:after:hidden after:absolute after:left-[1.25rem] after:top-10 after:bottom-[-1.5rem] after:w-px after:bg-[#1f1f1f]">
                    <div class="w-10 h-10 rounded-full flex-shrink-0 bg-slate-900 border border-[#1f1f1f] flex items-center justify-center relative z-10">
                        @if($act['type'] == 'Deposit') <i data-lucide="plus-circle" class="w-4 h-4 text-emerald-500"></i>
                        @elseif($act['type'] == 'Withdrawal') <i data-lucide="minus-circle" class="w-4 h-4 text-red-500"></i>
                        @elseif($act['type'] == 'Registration') <i data-lucide="user-plus" class="w-4 h-4 text-blue-500"></i>
                        @else <i data-lucide="zap" class="w-4 h-4 text-amber-500"></i> @endif
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-200">{{ $act['user'] }} <span class="text-slate-500 font-normal">initiated a</span> {{ $act['type'] }}</p>
                        @if($act['amount'])
                        <p class="text-[10px] font-black text-slate-400 mt-1 uppercase">{{ $settings['platform_currency_symbol'] ?? '$' }}{{ number_format($act['amount'], 2) }}</p>
                        @endif
                        <p class="text-[10px] text-slate-600 mt-0.5">{{ $act['time'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Quick Tables -->
        <div class="lg:col-span-2 glass rounded-3xl overflow-hidden self-start">
             <div class="p-6 border-b border-[#1f1f1f] flex items-center justify-between">
                <h3 class="font-bold flex items-center gap-2">
                    <i data-lucide="user-plus" class="w-4 h-4 text-blue-500"></i>
                    Recent Registrations
                </h3>
                <a href="{{ route('admin.users.index') }}" class="text-xs text-purple-400 hover:text-purple-300 font-bold uppercase tracking-wider">Manage Users</a>
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
                        <tr class="hover:bg-white/[0.01]">
                            <td class="px-6 py-4">
                                <span class="font-medium text-slate-200">{{ $u->name }}</span>
                            </td>
                            <td class="px-6 py-4 text-slate-400 text-xs italic">
                                {{ $u->upline ? $u->upline->name : 'Direct' }}
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

