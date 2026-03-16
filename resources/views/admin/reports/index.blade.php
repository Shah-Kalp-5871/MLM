@extends('layouts.admin')

@section('content')
<div class="space-y-10">
    <div>
        <h1 class="text-2xl font-bold tracking-tight">Platform Analytics & Reports</h1>
        <p class="text-slate-400 text-sm">Deep dive into financial performance and network growth metrics.</p>
    </div>

    <!-- Analytics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="glass p-6 rounded-3xl border-b-4 border-purple-500">
            <h4 class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2">Network Growth (MTD)</h4>
            <div class="flex items-center justify-between">
                <span class="text-2xl font-black">+{{ $stats['monthly_users'] }}</span>
                <span class="text-xs text-green-500 font-bold flex items-center gap-1">
                    <i data-lucide="trending-up" class="w-3 h-3"></i> 100%
                </span>
            </div>
            <div class="w-full bg-slate-800 h-1 mt-4 rounded-full overflow-hidden">
                <div class="bg-purple-500 h-full w-[100%]"></div>
            </div>
        </div>
        <div class="glass p-6 rounded-3xl border-b-4 border-blue-500">
            <h4 class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2">Revenue Velocity</h4>
            <div class="flex items-center justify-between">
                <span class="text-2xl font-black">{{ $settings['platform_currency_symbol'] ?? '$' }}{{ number_format($stats['daily_avg_revenue'], 2) }}</span>
                <span class="text-xs text-blue-500 font-bold uppercase">Average/Day</span>
            </div>
            <div class="w-full bg-slate-800 h-1 mt-4 rounded-full overflow-hidden">
                <div class="bg-blue-500 h-full w-[50%]"></div>
            </div>
        </div>
        <div class="glass p-6 rounded-3xl border-b-4 border-green-500">
            <h4 class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2">Retention Rate</h4>
            <div class="flex items-center justify-between">
                <span class="text-2xl font-black">100%</span>
                <span class="text-xs text-slate-500 font-bold uppercase">Optimal</span>
            </div>
            <div class="w-full bg-slate-800 h-1 mt-4 rounded-full overflow-hidden">
                <div class="bg-green-500 h-full w-[100%]"></div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Financial Distribution Report -->
        <div class="glass p-8 rounded-3xl space-y-6">
            <div class="flex items-center justify-between border-b border-[#1f1f1f] pb-4">
                <h3 class="font-bold flex items-center gap-2">
                    <i data-lucide="pie-chart" class="w-4 h-4 text-purple-500"></i>
                    Payout Composition
                </h3>
                <span class="text-[10px] font-bold text-slate-500 uppercase">System Life</span>
            </div>
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded-full bg-purple-500"></div>
                        <span class="text-xs text-slate-300">ROI Payouts</span>
                    </div>
                    <span class="text-xs font-bold text-slate-200">{{ $stats['payouts']['roi'] }}%</span>
                </div>
                <div class="w-full bg-slate-800 h-2 rounded-full overflow-hidden">
                    <div class="bg-purple-500 h-full w-[{{ $stats['payouts']['roi'] }}%]"></div>
                </div>
                
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded-full bg-blue-500"></div>
                        <span class="text-xs text-slate-300">Level Commissions</span>
                    </div>
                    <span class="text-xs font-bold text-slate-200">{{ $stats['payouts']['level'] }}%</span>
                </div>
                <div class="w-full bg-slate-800 h-2 rounded-full overflow-hidden">
                    <div class="bg-blue-500 h-full w-[{{ $stats['payouts']['level'] }}%]"></div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded-full bg-amber-500"></div>
                        <span class="text-xs text-slate-300">Club Vouchers Issued</span>
                    </div>
                    <span class="text-xs font-bold text-slate-200">{{ $stats['payouts']['vouchers'] }}%</span>
                </div>
                <div class="w-full bg-slate-800 h-2 rounded-full overflow-hidden">
                    <div class="bg-amber-500 h-full w-[{{ $stats['payouts']['vouchers'] }}%]"></div>
                </div>
            </div>
        </div>

        <!-- Top Performers -->
        <div class="glass rounded-3xl overflow-hidden flex flex-col">
            <div class="p-6 border-b border-[#1f1f1f]">
                <h3 class="font-bold flex items-center gap-2">
                    <i data-lucide="medal" class="w-4 h-4 text-amber-500"></i>
                    Top Network Leaders
                </h3>
            </div>
            <div class="flex-1 overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-[#0c0c0c] text-slate-500 uppercase text-[10px] font-bold">
                        <tr>
                            <th class="px-6 py-4">Leader</th>
                            <th class="px-6 py-4">Direct BV</th>
                            <th class="px-6 py-4 text-right">Team Size</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#1f1f1f]">
                        @forelse($leaders as $leader)
                        <tr class="hover:bg-white/[0.02]">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-slate-800 border border-[#1f1f1f] flex items-center justify-center text-[10px] font-bold uppercase">
                                        {{ substr($leader->name, 0, 1) }}{{ substr(strrchr($leader->name, ' '), 1, 1) }}
                                    </div>
                                    <span class="font-bold text-slate-300">{{ $leader->name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 font-black">{{ $settings['platform_currency_symbol'] ?? '$' }}{{ number_format($leader->direct_bv, 2) }}</td>
                            <td class="px-6 py-4 text-right font-bold text-purple-400">{{ $leader->referrals_count }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-6 py-12 text-center text-slate-500">No leaders identified yet.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div></div>
</div>
@endsection
