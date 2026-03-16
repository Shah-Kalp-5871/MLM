@extends('layouts.admin')

@section('content')
<div class="space-y-10">
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
        <div>
            <h1 class="text-2xl font-bold tracking-tight">ROI Engine Control</h1>
            <p class="text-slate-400 text-sm">Automate and monitor weekly profit distribution.</p>
        </div>
        <div class="flex items-center gap-3">
             <form action="{{ url('admin/roi/run') }}" method="POST">
                @csrf
                <button type="submit" class="btn-gradient px-8 py-3 rounded-2xl text-sm font-bold shadow-xl shadow-purple-600/20 flex items-center gap-2">
                    <i data-lucide="play" class="w-4 h-4"></i> Execute ROI Distribution
                </button>
             </form>
        </div>
    </div>

    <!-- ROI Metrics -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="glass p-6 rounded-2xl border-l-4 border-purple-600">
            <h4 class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Next Payout</h4>
            <div class="flex items-end justify-between">
                <span class="text-2xl font-bold">{{ $next_payout }}</span>
                <span class="text-[10px] text-purple-400 font-bold uppercase tracking-widest">In {{ $days_left }} days</span>
            </div>
        </div>
        <div class="glass p-6 rounded-2xl border-l-4 border-blue-600">
            <h4 class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Eligible Amount</h4>
            <div class="flex items-end justify-between">
                <span class="text-2xl font-bold text-blue-400">{{ $settings['platform_currency_symbol'] ?? '$' }}{{ number_format($eligible_amount, 2) }}</span>
                <span class="text-[10px] text-blue-400 font-bold uppercase tracking-widest">{{ $total_investments }} Active Assets</span>
            </div>
        </div>
        <div class="glass p-6 rounded-2xl border-l-4 border-green-600">
            <h4 class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Engine Status</h4>
            <div class="flex items-end justify-between">
                <span class="text-2xl font-bold text-green-500">OPTIMAL</span>
                <span class="text-[10px] text-slate-500 font-bold uppercase tracking-widest">Scheduler Live</span>
            </div>
        </div>
    </div>

    <!-- ROI History -->
    <div class="glass rounded-3xl overflow-hidden">
        <div class="p-6 border-b border-[#1f1f1f] flex items-center justify-between">
            <h3 class="font-bold flex items-center gap-2">
                <i data-lucide="history" class="w-4 h-4 text-slate-500"></i>
                Distribution Logs
            </h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-[#0c0c0c] text-slate-500 uppercase text-[10px] font-bold">
                    <tr>
                        <th class="px-6 py-4">Batch ID</th>
                        <th class="px-6 py-4">Execution Date</th>
                        <th class="px-6 py-4">Total Distributed</th>
                        <th class="px-6 py-4">Accounts Paid</th>
                        <th class="px-6 py-4">Level Commission Triggered</th>
                        <th class="px-6 py-4">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#1f1f1f]">
                    @forelse($roi_history as $inc)
                    <tr>
                        <td class="px-6 py-4 font-mono text-xs text-purple-400">#ROI-{{ $inc->id }}</td>
                        <td class="px-6 py-4 text-slate-400">{{ $inc->distributed_at ? \Carbon\Carbon::parse($inc->distributed_at)->format('d M Y, h:i A') : 'N/A' }}</td>
                        <td class="px-6 py-4 font-bold text-green-400">{{ $settings['platform_currency_symbol'] ?? '$' }}{{ number_format($inc->roi_amount, 2) }}</td>
                        <td class="px-6 py-4">{{ $inc->investment?->user?->name ?? 'N/A' }}</td>
                        <td class="px-6 py-4 text-blue-400 font-bold">INV-{{ $inc->investment_id }}</td>
                        <td class="px-6 py-4">
                            <span class="badge-active text-[10px] px-2 py-0.5 rounded-full uppercase font-bold">Completed</span>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="px-6 py-12 text-center text-slate-500 italic">No ROI records found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-[#1f1f1f]">
            {{ $roi_history->links() }}
        </div>
    </div>
</div>
@endsection

