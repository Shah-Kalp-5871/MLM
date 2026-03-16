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
                <span class="text-2xl font-black">+242</span>
                <span class="text-xs text-green-500 font-bold flex items-center gap-1">
                    <i data-lucide="trending-up" class="w-3 h-3"></i> 14%
                </span>
            </div>
            <div class="w-full bg-slate-800 h-1 mt-4 rounded-full overflow-hidden">
                <div class="bg-purple-500 h-full w-[65%]"></div>
            </div>
        </div>
        <div class="glass p-6 rounded-3xl border-b-4 border-blue-500">
            <h4 class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2">Revenue Velocity</h4>
            <div class="flex items-center justify-between">
                <span class="text-2xl font-black">₹42,500</span>
                <span class="text-xs text-blue-500 font-bold uppercase">Average/Day</span>
            </div>
            <div class="w-full bg-slate-800 h-1 mt-4 rounded-full overflow-hidden">
                <div class="bg-blue-500 h-full w-[45%]"></div>
            </div>
        </div>
        <div class="glass p-6 rounded-3xl border-b-4 border-green-500">
            <h4 class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2">Retention Rate</h4>
            <div class="flex items-center justify-between">
                <span class="text-2xl font-black">94.2%</span>
                <span class="text-xs text-slate-500 font-bold uppercase">Optimal</span>
            </div>
            <div class="w-full bg-slate-800 h-1 mt-4 rounded-full overflow-hidden">
                <div class="bg-green-500 h-full w-[94%]"></div>
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
                <span class="text-[10px] font-bold text-slate-500 uppercase">Last 30 Days</span>
            </div>
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded-full bg-purple-500"></div>
                        <span class="text-xs text-slate-300">ROI Payouts</span>
                    </div>
                    <span class="text-xs font-bold text-slate-200">72%</span>
                </div>
                <div class="w-full bg-slate-800 h-2 rounded-full overflow-hidden">
                    <div class="bg-purple-500 h-full w-[72%]"></div>
                </div>
                
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded-full bg-blue-500"></div>
                        <span class="text-xs text-slate-300">Level Commissions</span>
                    </div>
                    <span class="text-xs font-bold text-slate-200">18%</span>
                </div>
                <div class="w-full bg-slate-800 h-2 rounded-full overflow-hidden">
                    <div class="bg-blue-500 h-full w-[18%]"></div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded-full bg-amber-500"></div>
                        <span class="text-xs text-slate-300">Club Vouchers Issued</span>
                    </div>
                    <span class="text-xs font-bold text-slate-200">10%</span>
                </div>
                <div class="w-full bg-slate-800 h-2 rounded-full overflow-hidden">
                    <div class="bg-amber-500 h-full w-[10%]"></div>
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
                        <tr class="hover:bg-white/[0.02]">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-slate-800 border border-[#1f1f1f] flex items-center justify-center text-[10px] font-bold">RK</div>
                                    <span class="font-bold text-slate-300">Rahul Kumar</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 font-black">₹42,000</td>
                            <td class="px-6 py-4 text-right font-bold text-purple-400">1,242</td>
                        </tr>
                        <tr class="hover:bg-white/[0.02]">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-slate-800 border border-[#1f1f1f] flex items-center justify-center text-[10px] font-bold">SG</div>
                                    <span class="font-bold text-slate-300">Sneha Gupta</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 font-black">₹38,500</td>
                            <td class="px-6 py-4 text-right font-bold text-purple-400">842</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection