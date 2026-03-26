@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold tracking-tight">Business Analytics & Reports</h1>
            <p class="text-slate-400 text-sm">Real-time performance tracking and data exports.</p>
        </div>
        <div class="flex items-center gap-3">
            <form action="{{ route('admin.reports.index') }}" method="GET" class="flex items-center gap-2 bg-[#121212] p-1 rounded-xl border border-[#1f1f1f]">
                <select name="range" onchange="this.form.submit()" class="bg-transparent text-sm border-none focus:ring-0 text-slate-300 px-3 py-1">
                    <option value="today" {{ $range == 'today' ? 'selected' : '' }}>Today</option>
                    <option value="week" {{ $range == 'week' ? 'selected' : '' }}>Last 7 Days</option>
                    <option value="month" {{ $range == 'month' ? 'selected' : '' }}>Last 30 Days</option>
                    <option value="all" {{ $range == 'all' ? 'selected' : '' }}>All Time</option>
                </select>
            </form>
            <form action="{{ route('admin.reports.trigger') }}" method="POST">
                @csrf
                <button type="submit" class="flex items-center gap-2 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white px-4 py-2 rounded-xl text-sm font-bold transition-all shadow-lg shadow-emerald-900/20" title="Run Background Report Generator">
                    <i data-lucide="play" class="w-4 h-4"></i>
                    Auto-Generate
                </button>
            </form>
            <a href="{{ route('admin.reports.export', ['range' => $range]) }}" class="flex items-center gap-2 bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-500 hover:to-blue-500 text-white px-4 py-2 rounded-xl text-sm font-bold transition-all shadow-lg shadow-purple-900/20">
                <i data-lucide="download" class="w-4 h-4"></i>
                Export PDF
            </a>
        </div>
    </div>

    <!-- Overview Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="glass p-6 rounded-3xl border-l-4 border-purple-500">
            <h4 class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">New Registrations</h4>
            <div class="text-2xl font-black text-white">{{ number_format($data['users']['new']) }}</div>
            <div class="text-[10px] text-slate-500 mt-1">Total: {{ number_format($data['users']['total']) }}</div>
        </div>
        <div class="glass p-6 rounded-3xl border-l-4 border-blue-500">
            <h4 class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Total Investments</h4>
            <div class="text-2xl font-black text-white">${{ number_format($data['investments']['total_amount'], 2) }}</div>
            <div class="text-[10px] text-slate-500 mt-1">{{ $data['investments']['total_count'] }} transactions</div>
        </div>
        <div class="glass p-6 rounded-3xl border-l-4 border-green-500">
            <h4 class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Total Payouts</h4>
            <div class="text-2xl font-black text-white">${{ number_format($data['payouts']['total'], 2) }}</div>
            <div class="text-[10px] text-slate-500 mt-1">ROI + Commissions</div>
        </div>
        <div class="glass p-6 rounded-3xl border-l-4 border-amber-500">
            <h4 class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Withdrawals (Paid)</h4>
            <div class="text-2xl font-black text-white">${{ number_format($data['withdrawals']['processed'], 2) }}</div>
            <div class="text-[10px] text-slate-500 mt-1">Pending: ${{ number_format($data['withdrawals']['pending'], 2) }}</div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Detailed Breakdown -->
        <div class="lg:col-span-2 space-y-8">
            <div class="glass p-8 rounded-3xl">
                <h3 class="font-bold text-lg mb-6 flex items-center gap-2">
                    <i data-lucide="activity" class="w-5 h-5 text-purple-500"></i>
                    Performance Breakdown
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-slate-400">ROI Distributions</span>
                            <span class="font-bold text-white">${{ number_format($data['payouts']['roi_given'], 2) }}</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-slate-400">Level Commissions</span>
                            <span class="font-bold text-white">${{ number_format($data['payouts']['level_commissions'], 2) }}</span>
                        </div>
                        <div class="h-px bg-[#1f1f1f] my-4"></div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-slate-400">Direct Business Volume</span>
                            <span class="font-bold text-white">${{ number_format($data['business']['total_direct_bv'], 2) }}</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-slate-400">Total Team Volume</span>
                            <span class="font-bold text-white">${{ number_format($data['business']['total_team_bv'], 2) }}</span>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-slate-400">Active vs Total Users</span>
                            <span class="font-bold text-white">{{ $data['users']['active'] }} / {{ $data['users']['total'] }}</span>
                        </div>
                        <div class="w-full bg-slate-800 h-2 rounded-full mt-1">
                            @php $activePercent = $data['users']['total'] > 0 ? ($data['users']['active'] / $data['users']['total']) * 100 : 0; @endphp
                            <div class="bg-green-500 h-full rounded-full" style="width: {{ $activePercent }}%"></div>
                        </div>
                        
                        <div class="mt-8">
                            <h4 class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-4">Key Performance Indicators</h4>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="bg-[#121212] p-4 rounded-2xl border border-[#1f1f1f]">
                                    <div class="text-2xl font-black text-purple-500">{{ $data['kpis']['payout_ratio'] }}%</div>
                                    <div class="text-[9px] text-slate-500 uppercase font-bold">Payout Ratio</div>
                                </div>
                                <div class="bg-[#121212] p-4 rounded-2xl border border-[#1f1f1f]">
                                    <div class="text-2xl font-black text-blue-500">{{ $data['kpis']['withdrawal_ratio'] }}%</div>
                                    <div class="text-[9px] text-slate-500 uppercase font-bold">Liquidity Ratio</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Club Performance -->
        <div class="glass p-8 rounded-3xl h-full">
            <h3 class="font-bold text-lg mb-6 flex items-center gap-2">
                <i data-lucide="award" class="w-5 h-5 text-amber-500"></i>
                Club Achievements
            </h3>
            <div class="space-y-6">
                @forelse($data['clubs'] as $level => $count)
                <div class="flex items-center justify-between group">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-amber-500/10 border border-amber-500/20 flex items-center justify-center text-amber-500 font-bold">
                            {{ $level }}
                        </div>
                        <div>
                            <div class="text-sm font-bold text-white">Level {{ $level }}</div>
                            <div class="text-[10px] text-slate-500 uppercase font-bold">Achievers</div>
                        </div>
                    </div>
                    <div class="text-xl font-black text-white">{{ $count }}</div>
                </div>
                @empty
                <div class="text-center py-12">
                    <i data-lucide="users" class="w-8 h-8 text-slate-700 mx-auto mb-3"></i>
                    <p class="text-slate-500 text-xs">No club achievements tracked in this period.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
