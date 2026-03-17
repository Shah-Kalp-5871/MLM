@extends('layouts.user')

@section('content')
<div class="flex justify-between items-center mb-8">
    <div>
        <h1 class="text-2xl font-bold text-white tracking-tight">Investments</h1>
        <p class="text-xs text-gray-500 font-medium uppercase tracking-widest mt-1">Manage your active plans</p>
    </div>
    <a href="{{ route('invest.create') }}" class="px-6 py-3 rounded-xl bg-purple-600 hover:bg-purple-500 text-white text-xs font-bold uppercase tracking-wider transition-all shadow-lg shadow-purple-900/40 flex items-center gap-2"><i data-lucide="plus" class="w-4 h-4"></i> Invest Now</a>
</div>

@php
    $activeInvestments = auth()->user()->investments()->where('status', 'active')->get();
    $totalInvestment = $activeInvestments->sum('amount');
    $activeCount = $activeInvestments->count();
    $globalROI = $settings['weekly_roi_percentage'];
    
    $expectedWeekly = 0;
    foreach($activeInvestments as $inv) {
        $expectedWeekly += $inv->amount * ($inv->weekly_roi_percentage / 100);
    }
@endphp

<div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
    <div class="glass-panel p-6 rounded-2xl border border-purple-500/20 flex flex-col justify-center">
        <h2 class="text-sm font-bold text-white uppercase tracking-wider mb-2">ROI Transparency</h2>
        <p class="text-xs text-gray-400 leading-relaxed mb-4">
            Each investment earns a fixed weekly ROI. Your profit is credited to your wallet exactly 7 days after approval.
        </p>
        <div class="flex gap-4">
            <div class="bg-black/30 p-4 rounded-xl border border-white/5 flex-1">
                <p class="text-[10px] text-gray-500 uppercase font-bold mb-1">Global Active Rate</p>
                <p class="text-white font-black text-xl">{{ $globalROI }}% <span class="text-[10px] text-purple-400 uppercase ml-1 tracking-tighter">Per Week</span></p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
        <div class="glass-panel p-6 rounded-2xl border-l-4 border-l-purple-500">
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Total Investment</p>
            <h3 class="text-2xl font-black text-white">{{ $settings['platform_currency_symbol'] ?? '$' }}{{ number_format($totalInvestment, 2) }}</h3>
        </div>
        <div class="glass-panel p-6 rounded-2xl border-l-4 border-l-emerald-500">
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Active Packages</p>
            <h3 class="text-2xl font-black text-white">{{ $activeCount }}</h3>
        </div>
        <div class="glass-panel p-6 rounded-2xl border-l-4 border-l-amber-500 sm:col-span-2">
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Total Weekly Profit (Auto-Credit)</p>
            <h3 class="text-2xl font-black text-white">{{ $settings['platform_currency_symbol'] ?? '$' }}{{ number_format($expectedWeekly, 2) }}</h3>
        </div>
    </div>
</div>

<!-- Active Plans Section (Priority) -->
<div class="flex items-center gap-3 mb-6">
    <div class="w-2 h-8 bg-emerald-500 rounded-full shadow-[0_0_15px_rgba(16,185,129,0.5)]"></div>
    <h2 class="text-lg font-bold text-white uppercase tracking-tight">Active Plans</h2>
</div>

<div class="glass-panel rounded-3xl overflow-hidden border border-white/5 relative mb-12">
    <div class="table-wrapper p-4">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Plan Details</th>
                    <th>Amount</th>
                    <th>ROI Rate</th>
                    <th>Status</th>
                    <th>Start Date</th>
                    <th class="text-right">Next Payout</th>
                </tr>
            </thead>
            <tbody>
                @forelse($investments as $inv)
                <tr class="hover:bg-white/[0.02] transition-colors">
                    <td class="font-mono text-gray-500 text-[10px]">#PLAT-{{ $inv->id }}</td>
                    <td>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-emerald-500/10 flex items-center justify-center text-emerald-500">
                                <i data-lucide="gem" class="w-4 h-4"></i>
                            </div>
                            <span class="font-bold text-white">Compound ROI Plan</span>
                        </div>
                    </td>
                    <td class="font-bold text-white">{{ $settings['platform_currency_symbol'] ?? '$' }}{{ number_format($inv->amount, 2) }}</td>
                    <td class="text-xs">
                        <span class="text-emerald-400 font-bold">{{ $inv->weekly_roi_percentage }}%</span>
                        <span class="text-gray-500 ml-1">Weekly</span>
                    </td>
                    <td>
                        <span class="px-3 py-1 bg-emerald-500/10 text-emerald-500 text-[10px] font-black uppercase rounded-full border border-emerald-500/20">
                            {{ ucfirst($inv->status) }}
                        </span>
                    </td>
                    <td class="text-xs text-gray-400 font-medium">{{ $inv->created_at->format('d M, Y') }}</td>
                    <td class="text-right">
                        <div class="flex flex-col items-end">
                            <span class="text-xs text-white font-bold">{{ \Carbon\Carbon::parse($inv->next_payout_at)->format('d M') }}</span>
                            <span class="text-[9px] text-indigo-400 font-bold uppercase tracking-tighter">In {{ now()->diffInDays($inv->next_payout_at) }} Days</span>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-12 text-gray-500 italic font-medium">No active investment plans found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($investments->hasPages())
    <div class="p-6 border-t border-white/5 flex justify-center bg-white/[0.01]">
        {{ $investments->links() }}
    </div>
    @endif
</div>

@if($rejectedDeposits->isNotEmpty())
<div class="mb-12 animate-in slide-in-from-top-4 duration-500">
    <div class="flex items-center gap-3 mb-6">
        <div class="w-2 h-8 bg-rose-500 rounded-full shadow-[0_0_15px_rgba(244,63,94,0.5)]"></div>
        <h2 class="text-lg font-bold text-white uppercase tracking-tight">Recent Rejections</h2>
        <span class="px-3 py-1 bg-rose-500/10 border border-rose-500/20 text-rose-500 text-[10px] font-black rounded-full">{{ $rejectedDeposits->count() }} ACTION REQUIRED</span>
    </div>
    
    <div class="glass-panel rounded-3xl overflow-hidden border border-rose-500/20 bg-rose-500/5 relative">
        <div class="table-wrapper p-4">
            <table>
                <thead>
                    <tr>
                        <th class="text-rose-400">Amount</th>
                        <th class="text-rose-400">Rejection Reason</th>
                        <th class="text-rose-400 text-right">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rejectedDeposits as $deposit)
                    <tr class="hover:bg-rose-500/[0.02] transition-colors">
                        <td class="font-bold text-rose-400">{{ $settings['platform_currency_symbol'] ?? '$' }}{{ number_format($deposit->amount, 2) }}</td>
                        <td>
                            <div class="flex flex-col">
                                <span class="text-white font-medium text-xs">{{ $deposit->rejection_reason ?? 'No specific reason provided.' }}</span>
                                <span class="text-[10px] text-gray-500 uppercase font-black mt-1">Admin Feedback</span>
                            </div>
                        </td>
                        <td class="text-right text-xs text-gray-500">{{ $deposit->updated_at->format('d M, Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif

@if($pendingDeposits->isNotEmpty())
<div class="mb-12 animate-in slide-in-from-top-4 duration-500">
    <div class="flex items-center gap-3 mb-6">
        <div class="w-2 h-8 bg-amber-500 rounded-full shadow-[0_0_15px_rgba(245,158,11,0.5)]"></div>
        <h2 class="text-lg font-bold text-white uppercase tracking-tight">Pending Approvals</h2>
        <span class="px-3 py-1 bg-amber-500/10 border border-amber-500/20 text-amber-500 text-[10px] font-black rounded-full">{{ $pendingDeposits->count() }} ACTION REQUIRED</span>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($pendingDeposits as $deposit)
        <div class="glass-panel p-6 rounded-3xl border border-amber-500/20 bg-amber-500/5 relative overflow-hidden group">
            <div class="absolute -top-12 -right-12 w-32 h-32 bg-amber-500/10 rounded-full blur-2xl group-hover:bg-amber-500/20 transition-all"></div>
            <div class="relative z-10">
                <div class="flex justify-between items-start mb-4">
                    <div class="w-12 h-12 rounded-2xl bg-amber-500/20 flex items-center justify-center text-amber-500">
                        <i data-lucide="clock" class="w-6 h-6"></i>
                    </div>
                    <div class="text-right">
                        <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">Amount</p>
                        <p class="text-xl font-black text-white">{{ $settings['platform_currency_symbol'] ?? '$' }}{{ number_format($deposit->amount, 2) }}</p>
                    </div>
                </div>
                <div class="space-y-3">
                    <div class="flex justify-between text-xs">
                        <span class="text-gray-500">Method</span>
                        <span class="text-gray-300 font-bold uppercase">{{ $deposit->payment_method }}</span>
                    </div>
                    <div class="flex justify-between text-xs">
                        <span class="text-gray-500">Submitted</span>
                        <span class="text-gray-300">{{ $deposit->created_at->diffForHumans() }}</span>
                    </div>
                </div>
                <div class="mt-6 p-3 rounded-xl bg-black/40 border border-white/5 text-[10px] text-amber-500/80 italic text-center font-medium">
                    Waiting for administrator to verify your payment proof.
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif
<div class="mb-12">
    <div class="flex items-center gap-3 mb-6">
        <div class="w-2 h-8 bg-blue-500 rounded-full shadow-[0_0_15px_rgba(59,130,246,0.5)]"></div>
        <h2 class="text-lg font-bold text-white uppercase tracking-tight">Recent ROI Payouts</h2>
    </div>

    <div class="glass-panel rounded-3xl overflow-hidden border border-white/5 bg-white/[0.02] relative shadow-2xl">
        <div class="table-wrapper p-4">
            <table>
                <thead>
                    <tr class="text-[10px] uppercase tracking-widest text-gray-500 font-bold border-b border-white/5">
                        <th class="pb-4 pl-2">Date</th>
                        <th class="pb-4">Investment ID</th>
                        <th class="pb-4">ROI Amount</th>
                        <th class="pb-4 text-right pr-2">Week #</th>
                    </tr>
                </thead>
                <tbody class="text-xs">
                    @forelse($roiHistory as $history)
                    <tr class="hover:bg-white/[0.03] transition-colors border-b border-white/5 last:border-0">
                        <td class="py-4 pl-2 text-gray-400 font-medium">{{ $history->distributed_at->format('d M, Y') }}</td>
                        <td class="py-4 font-mono text-gray-500 text-[10px]">#PLAT-{{ $history->investment_id }}</td>
                        <td class="py-4 text-emerald-400 font-bold">+{{ $settings['platform_currency_symbol'] ?? '$' }}{{ number_format($history->roi_amount, 2) }}</td>
                        <td class="py-4 text-right pr-2">
                            <span class="px-2 py-0.5 bg-blue-500/10 text-blue-400 rounded-lg font-bold uppercase tracking-widest text-[9px]">Week {{ $history->week_number }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-12 text-gray-500 italic font-medium">No ROI payouts recorded yet. Your first ROI will appear 7 days after approval.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($roiHistory->isNotEmpty())
        <div class="p-4 border-t border-white/5 flex justify-center bg-white/[0.01]">
            <a href="{{ route('earnings.index') }}" class="text-[10px] font-black uppercase tracking-widest text-gray-500 hover:text-blue-400 transition-colors flex items-center gap-2">
                See Full ROI History <i data-lucide="arrow-right" class="w-3 h-3"></i>
            </a>
        </div>
        @endif
    </div>
</div>

@endsection
