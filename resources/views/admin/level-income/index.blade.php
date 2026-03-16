@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight">Level Commissions Audit</h1>
            <p class="text-slate-400 text-sm">Review full payout distribution across the 15-level hierarchy.</p>
        </div>
        <div class="flex items-center gap-3">
             <button class="bg-[#121212] border border-[#1f1f1f] px-4 py-2 rounded-xl text-sm font-medium hover:border-slate-700 transition-all flex items-center gap-2 text-slate-400">
                <i data-lucide="filter" class="w-4 h-4"></i> Filter by Level
            </button>
        </div>
    </div>

    <!-- History Table -->
    <div class="glass rounded-3xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-[#0c0c0c] text-slate-500 uppercase text-[10px] font-bold">
                    <tr>
                        <th class="px-6 py-4">Receiver (Upline)</th>
                        <th class="px-6 py-4">From User (Downline)</th>
                        <th class="px-6 py-4">Level</th>
                        <th class="px-6 py-4">ROI Amount</th>
                        <th class="px-6 py-4">Commission</th>
                        <th class="px-6 py-4">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#1f1f1f]">
                    @forelse ($commissions as $comm)
                    <tr class="hover:bg-white/[0.02] transition-colors">
                        <td class="px-6 py-4">
                            <span class="font-bold text-slate-200">{{ $comm->receiver->name ?? 'N/A' }}</span>
                        </td>
                        <td class="px-6 py-4 text-slate-400 font-medium">{{ $comm->fromUser->name ?? 'N/A' }}</td>
                        <td class="px-6 py-4 text-center">
                            <span class="bg-purple-600/10 text-purple-400 px-3 py-1 rounded-full text-[10px] font-bold border border-purple-600/20">L{{ $comm->level }}</span>
                        </td>
                        <td class="px-6 py-4 text-slate-500 text-xs font-mono">{{ $settings['platform_currency_symbol'] ?? '$' }}{{ number_format($comm->roi_amount ?? 0, 2) }}</td>
                        <td class="px-6 py-4 font-bold text-emerald-400">{{ $settings['platform_currency_symbol'] ?? '$' }}{{ number_format($comm->commission_amount, 2) }}</td>
                        <td class="px-6 py-4">
                            <div class="text-xs text-slate-400">{{ $comm->created_at ? $comm->created_at->format('d M Y') : 'N/A' }}</div>
                            <div class="text-[9px] text-slate-600 uppercase">{{ $comm->created_at ? $comm->created_at->diffForHumans() : '' }}</div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="px-6 py-12 text-center text-slate-500 italic">No commission records found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($commissions->hasPages())
        <div class="p-6 border-t border-[#1f1f1f]">
            {{ $commissions->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
