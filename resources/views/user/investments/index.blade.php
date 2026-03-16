@extends('layouts.user')

@section('content')
<div class="flex justify-between items-center mb-8">
    <div>
        <h1 class="text-2xl font-bold text-white tracking-tight">Investments</h1>
        <p class="text-xs text-gray-500 font-medium uppercase tracking-widest mt-1">Manage your active plans</p>
    </div>
    <a href="/user/investments/create" class="px-6 py-3 rounded-xl bg-purple-600 hover:bg-purple-500 text-white text-xs font-bold uppercase tracking-wider transition-all shadow-lg shadow-purple-900/40 flex items-center gap-2"><i data-lucide="plus" class="w-4 h-4"></i> Invest Now</a>
</div>

@php
    $totalInvestment = auth()->user()->investments()->where('status', 'active')->sum('amount');
    $activeCount = auth()->user()->investments()->where('status', 'active')->count();
    $minROI = $settings['weekly_roi_min'] ?? 3;
    $maxROI = $settings['weekly_roi_max'] ?? 3.5;
    $expectedWeekly = $totalInvestment * ($minROI / 100);
@endphp

<div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
    <div class="glass-panel p-6 rounded-2xl border border-purple-500/20 flex flex-col justify-center">
        <h2 class="text-sm font-bold text-white uppercase tracking-wider mb-2">ROI Explanation</h2>
        <p class="text-xs text-gray-400 leading-relaxed mb-4">
            Your investment generates passive weekly ROI based on the package value.
        </p>
        <div class="flex gap-4">
            <div class="bg-black/30 p-3 rounded-xl border border-white/5 flex-1">
                <p class="text-[10px] text-gray-500 uppercase font-bold mb-1">Weekly ROI</p>
                <p class="text-white font-black">{{ $minROI }}% – {{ $maxROI }}%</p>
            </div>
            <div class="bg-black/30 p-3 rounded-xl border border-white/5 flex-1">
                <p class="text-[10px] text-gray-500 uppercase font-bold mb-1">Monthly ROI</p>
                <p class="text-white font-black">{{ $minROI * 4 }}% – {{ $maxROI * 4 }}%</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
        <div class="glass-panel p-6 rounded-2xl border-l-4 border-l-purple-500">
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Total Investment</p>
            <h3 class="text-2xl font-black text-white">$settings['platform_currency_symbol']{{ number_format($totalInvestment, 2) }}</h3>
        </div>
        <div class="glass-panel p-6 rounded-2xl border-l-4 border-l-emerald-500">
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Active Packages</p>
            <h3 class="text-2xl font-black text-white">{{ $activeCount }}</h3>
        </div>
        <div class="glass-panel p-6 rounded-2xl border-l-4 border-l-amber-500 sm:col-span-2">
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Expected Weekly Profit</p>
            <h3 class="text-2xl font-black text-white">$settings['platform_currency_symbol']{{ number_format($expectedWeekly, 2) }} – $settings['platform_currency_symbol']{{ number_format($totalInvestment * ($maxROI / 100), 2) }}</h3>
        </div>
    </div>
</div>

<div class="glass-panel rounded-2xl overflow-hidden">
    <div class="table-wrapper p-4">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Package</th>
                    <th>Amount</th>
                    <th>ROI %</th>
                    <th>Status</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($investments as $inv)
                <tr>
                    <td class="font-mono text-gray-400 text-xs">#INV-{{ $inv->id }}</td>
                    <td class="font-bold text-white">{{ $inv->package->name ?? 'Custom' }}</td>
                    <td class="font-bold text-white">$settings['platform_currency_symbol']{{ number_format($inv->amount, 2) }}</td>
                    <td class="text-xs">{{ $inv->daily_roi_percentage * 7 }}% Weekly</td>
                    <td>
                        <span class="px-3 py-1 bg-emerald-500/20 text-emerald-400 text-[10px] font-bold uppercase rounded-full">
                            {{ ucfirst($inv->status) }}
                        </span>
                    </td>
                    <td class="text-xs">{{ $inv->created_at->format('d M Y') }}</td>
                    <td class="text-xs text-gray-500">{{ $inv->matures_at ? \Carbon\Carbon::parse($inv->matures_at)->format('d M Y') : 'N/A' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-8 text-gray-500 italic">No investments found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-4 border-t border-white/5 flex justify-center bg-white/[0.01]">
        {{ $investments->links() }}
    </div>
</div>
@endsection
