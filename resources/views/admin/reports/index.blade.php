@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
        <div>
            <h1 class="text-2xl font-bold tracking-tight">Business Intelligence</h1>
            <p class="text-slate-400 text-sm">Comprehensive performance metrics and growth analytics.</p>
        </div>
        <div class="flex flex-wrap items-center gap-3">
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
                    <i data-lucide="play" class="w-4 h-4 text-emerald-300"></i>
                    Auto-Generate
                </button>
            </form>
            <a href="{{ route('admin.reports.export', ['range' => $range]) }}" class="flex items-center gap-2 bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-500 hover:to-blue-500 text-white px-4 py-2 rounded-xl text-sm font-bold transition-all shadow-lg shadow-purple-900/20">
                <i data-lucide="download" class="w-4 h-4 text-purple-200"></i>
                Export PDF
            </a>
        </div>
    </div>

    <!-- Main KPIs -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- New Users Card -->
        <div class="glass p-6 rounded-2xl border-l-4 border-blue-500 hover:scale-[1.02] transition-transform cursor-pointer">
            <div class="flex items-center justify-between mb-2">
                <h4 class="text-xs font-bold text-slate-500 uppercase tracking-widest">New Registrations</h4>
                <div class="p-2 bg-blue-500/10 rounded-lg"><i data-lucide="users" class="w-4 h-4 text-blue-400"></i></div>
            </div>
            <div class="text-3xl font-bold">{{ number_format($data['users']['new']) }}</div>
            <p class="text-[10px] text-slate-500 mt-2 font-medium">Total: {{ number_format($data['users']['total']) }} members</p>
        </div>

        <!-- Volume Card -->
        <div class="glass p-6 rounded-2xl border-l-4 border-purple-500 hover:scale-[1.02] transition-transform cursor-pointer">
            <div class="flex items-center justify-between mb-2">
                <h4 class="text-xs font-bold text-slate-500 uppercase tracking-widest">Investment Volume</h4>
                <div class="p-2 bg-purple-500/10 rounded-lg"><i data-lucide="bar-chart-3" class="w-4 h-4 text-purple-400"></i></div>
            </div>
            <div class="text-3xl font-bold tracking-tight">${{ number_format($data['investments']['total_amount'], 2) }}</div>
            <p class="text-[10px] text-slate-500 mt-2 font-medium">{{ $data['investments']['total_count'] }} transactions in period</p>
        </div>

        <!-- Payouts Card -->
        <div class="glass p-6 rounded-2xl border-l-4 border-emerald-500 hover:scale-[1.02] transition-transform cursor-pointer">
            <div class="flex items-center justify-between mb-2">
                <h4 class="text-xs font-bold text-slate-500 uppercase tracking-widest">Distributed Payouts</h4>
                <div class="p-2 bg-emerald-500/10 rounded-lg"><i data-lucide="trending-up" class="w-4 h-4 text-emerald-400"></i></div>
            </div>
            <div class="text-3xl font-bold text-emerald-400">${{ number_format($data['payouts']['total'], 2) }}</div>
            <p class="text-[10px] text-emerald-500 mt-2 font-medium">{{ $data['kpis']['payout_ratio'] }}% Payout/Investment Ratio</p>
        </div>

        <!-- Withdrawals Card -->
        <div class="glass p-6 rounded-2xl border-l-4 border-red-500 hover:scale-[1.02] transition-transform cursor-pointer">
            <div class="flex items-center justify-between mb-2">
                <h4 class="text-xs font-bold text-slate-500 uppercase tracking-widest">Paid Withdrawals</h4>
                <div class="p-2 bg-red-500/10 rounded-lg"><i data-lucide="wallet" class="w-4 h-4 text-red-400"></i></div>
            </div>
            <div class="text-3xl font-bold">${{ number_format($data['withdrawals']['processed'], 2) }}</div>
            <p class="text-[10px] text-red-500 mt-2 font-medium">${{ number_format($data['withdrawals']['pending'], 2) }} currently pending</p>
        </div>
    </div>

    <!-- Charts & Secondary Metrics -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Trend Chart -->
        <div class="lg:col-span-2 glass p-8 rounded-3xl relative overflow-hidden group">
            <div class="flex items-center justify-between mb-8 relative z-10">
                <div>
                    <h3 class="font-bold text-lg">Growth Trends</h3>
                    <p class="text-xs text-slate-500">Last 7 days registration & investment velocity.</p>
                </div>
                <div class="flex gap-4">
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-purple-500"></span>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter">Investments</span>
                    </div>
                     <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-blue-500"></span>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter">Users</span>
                    </div>
                </div>
            </div>
            
            <div class="w-full h-64">
                <canvas id="trendChart"></canvas>
            </div>
        </div>

        <!-- Performance Indicators -->
        <div class="glass p-8 rounded-3xl">
            <h3 class="font-bold text-lg mb-6">Efficiency Indices</h3>
            
            <div class="space-y-8">
                <!-- KPI 1 -->
                <div>
                    <div class="flex justify-between text-xs font-bold uppercase tracking-widest mb-2">
                        <span class="text-slate-500">User Activity Rate</span>
                        <span class="text-blue-400">{{ $data['kpis']['user_activity_rate'] }}%</span>
                    </div>
                    <div class="w-full bg-[#111] h-1.5 rounded-full overflow-hidden">
                        <div class="bg-blue-500 h-full shadow-[0_0_10px_rgba(59,130,246,0.3)]" style="width: {{ $data['kpis']['user_activity_rate'] }}%"></div>
                    </div>
                </div>

                <!-- KPI 2 -->
                <div>
                    <div class="flex justify-between text-xs font-bold uppercase tracking-widest mb-2">
                        <span class="text-slate-500">Payout/Volume Ratio</span>
                        <span class="text-purple-400">{{ $data['kpis']['payout_ratio'] }}%</span>
                    </div>
                    <div class="w-full bg-[#111] h-1.5 rounded-full overflow-hidden">
                        <div class="bg-purple-500 h-full shadow-[0_0_10px_rgba(168,85,247,0.3)]" style="width: {{ $data['kpis']['payout_ratio'] > 100 ? 100 : $data['kpis']['payout_ratio'] }}%"></div>
                    </div>
                </div>

                <!-- KPI 3 -->
                <div>
                    <div class="flex justify-between text-xs font-bold uppercase tracking-widest mb-2">
                        <span class="text-slate-500">Liquidity Health</span>
                        <span class="text-emerald-400">Stable</span>
                    </div>
                    <div class="w-full bg-[#111] h-1.5 rounded-full overflow-hidden">
                        <div class="bg-emerald-500 h-full shadow-[0_0_10px_rgba(16,185,129,0.3)]" style="width: 85%"></div>
                    </div>
                </div>

                <!-- Voucher Snippet -->
                <div class="mt-8 pt-8 border-t border-[#1f1f1f]">
                    <h4 class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-4">Voucher Ecosystem</h4>
                    <div class="flex items-center justify-between p-4 bg-[#0c0c0c] rounded-2xl border border-[#1f1f1f]">
                        <div>
                            <div class="text-lg font-bold">${{ number_format($data['vouchers']['unused_value'], 2) }}</div>
                            <div class="text-[10px] text-slate-500">Unused Liability</div>
                        </div>
                        <div class="text-right">
                            <div class="text-lg font-bold text-blue-400">{{ $data['vouchers']['total_count'] }}</div>
                            <div class="text-[10px] text-slate-500">Total Issued</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Tables Section (Financial & Network) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 pb-10">
        <!-- Left: Financial -->
        <div class="glass rounded-3xl overflow-hidden self-start">
            <div class="p-6 border-b border-[#1f1f1f]">
                <h3 class="font-bold flex items-center gap-2">
                    <i data-lucide="pie-chart" class="w-4 h-4 text-emerald-400"></i>
                    Financial Reconciliation
                </h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <tbody class="divide-y divide-[#1f1f1f]">
                        <tr><td class="px-6 py-4 text-slate-400">ROI Distributions</td><td class="px-6 py-4 text-right font-bold text-emerald-400">+ ${{ number_format($data['payouts']['roi_given'], 2) }}</td></tr>
                        <tr><td class="px-6 py-4 text-slate-400">Level Commissions</td><td class="px-6 py-4 text-right font-bold text-emerald-400">+ ${{ number_format($data['payouts']['level_commissions'], 2) }}</td></tr>
                        <tr><td class="px-6 py-4 text-slate-400">Paid Withdrawals</td><td class="px-6 py-4 text-right font-bold text-red-400">- ${{ number_format($data['withdrawals']['processed'], 2) }}</td></tr>
                        <tr class="bg-black/20"><td class="px-6 py-4 text-white font-bold">Pending Withdrawal Liability</td><td class="px-6 py-4 text-right font-bold text-orange-400">${{ number_format($data['withdrawals']['pending'], 2) }}</td></tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Right: Business Volume -->
        <div class="glass rounded-3xl overflow-hidden self-start">
            <div class="p-6 border-b border-[#1f1f1f]">
                <h3 class="font-bold flex items-center gap-2">
                    <i data-lucide="layers" class="w-4 h-4 text-blue-400"></i>
                    Network Business Assets
                </h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <tbody class="divide-y divide-[#1f1f1f]">
                        <tr><td class="px-6 py-4 text-slate-400">Active Investment Capital</td><td class="px-6 py-4 text-right font-bold text-blue-400">${{ number_format($data['investments']['active_amount'], 2) }}</td></tr>
                        <tr><td class="px-6 py-4 text-slate-400">Total Direct Volume</td><td class="px-6 py-4 text-right font-bold">${{ number_format($data['business']['total_direct_bv'], 2) }}</td></tr>
                        <tr class="bg-black/20"><td class="px-6 py-4 text-white font-bold">Consolidated Team BV</td><td class="px-6 py-4 text-right font-bold text-purple-400">${{ number_format($data['business']['total_team_bv'], 2) }}</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Chart Scripts -->
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('trendChart').getContext('2d');
        
        // Gradient for Investment
        const investmentGrad = ctx.createLinearGradient(0, 0, 0, 400);
        investmentGrad.addColorStop(0, 'rgba(168, 85, 247, 0.4)');
        investmentGrad.addColorStop(1, 'rgba(168, 85, 247, 0)');

        // Gradient for Users
        const usersGrad = ctx.createLinearGradient(0, 0, 0, 400);
        usersGrad.addColorStop(0, 'rgba(59, 130, 246, 0.4)');
        usersGrad.addColorStop(1, 'rgba(59, 130, 246, 0)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($data['trends']['labels']),
                datasets: [
                    {
                        label: 'Investments ($)',
                        data: @json($data['trends']['investments']),
                        borderColor: '#a855f7',
                        backgroundColor: investmentGrad,
                        fill: true,
                        tension: 0.4,
                        borderWidth: 3,
                        pointBackgroundColor: '#a855f7',
                        pointHoverRadius: 6,
                        yAxisID: 'y'
                    },
                    {
                        label: 'New Users',
                        data: @json($data['trends']['registrations']),
                        borderColor: '#3b82f6',
                        backgroundColor: usersGrad,
                        fill: true,
                        tension: 0.4,
                        borderWidth: 3,
                        pointBackgroundColor: '#3b82f6',
                        pointHoverRadius: 6,
                        yAxisID: 'y1'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { color: '#64748b', font: { size: 10 } }
                    },
                    y: {
                        position: 'left',
                        grid: { borderDash: [5, 5], color: 'rgba(255,255,255,0.05)' },
                        ticks: { color: '#a855f7', font: { size: 10 } }
                    },
                    y1: {
                        position: 'right',
                        grid: { display: false },
                        ticks: { color: '#3b82f6', font: { size: 10 } }
                    }
                }
            }
        });
    });
</script>
@endpush
@endsection
