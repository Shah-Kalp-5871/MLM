@extends('layouts.user')

@section('content')
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
    <div>
        <h1 class="text-2xl font-bold text-white tracking-tight">Withdrawals</h1>
        <p class="text-xs text-gray-500 font-medium uppercase tracking-widest mt-1">Cash out your earnings</p>
    </div>
    <a href="{{ route('withdraw.create') }}" class="w-full sm:w-auto px-8 py-3 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white text-xs font-bold uppercase tracking-wider transition-all shadow-lg shadow-emerald-900/40 text-center">Request Withdrawal</a>
</div>


<div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
    <div class="glass-panel p-6 rounded-2xl bg-[#0a0f18] border border-emerald-500/20">
        <p class="text-[10px] font-bold text-emerald-400 uppercase tracking-widest mb-1">Available to Withdraw</p>
        <h3 class="text-2xl font-black text-white">{{ $settings['platform_currency_symbol'] ?? '$' }}{{ number_format($wallet->balance, 2) }}</h3>
    </div>
    <div class="glass-panel p-6 rounded-2xl border-l-[3px] border-emerald-500">
        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Total Withdrawn</p>
        <h3 class="text-2xl font-black text-white">{{ $settings['platform_currency_symbol'] ?? '$' }}{{ number_format($wallet->total_withdrawn, 2) }}</h3>
    </div>
    <div class="glass-panel p-6 rounded-2xl border-l-[3px] border-amber-500">
        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Pending Amount</p>
        <h3 class="text-2xl font-black text-white">{{ $settings['platform_currency_symbol'] ?? '$' }}{{ number_format($withdrawals->where('status', 'pending')->sum('amount'), 2) }}</h3>
    </div>
</div>

<div class="glass-panel rounded-2xl overflow-hidden">
    <div class="p-6 border-b border-white/5 bg-white/[0.02]">
        <h2 class="text-sm font-bold text-white uppercase tracking-wider">Withdrawal History</h2>
    </div>
    <div class="table-wrapper p-4">
        <table>
            <thead>
                <tr>
                    <th>Amount</th>
                    <th>Method</th>
                    <th>Status</th>
                    <th class="text-right">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($withdrawals as $w)
                <tr>
                    <td class="font-bold text-white font-mono">{{ $settings['platform_currency_symbol'] ?? '$' }}{{ number_format($w->amount, 2) }}</td>
                    <td>{{ strtoupper(str_replace('_', ' ', $w->payment_method)) }}</td>
                    <td>
                        @if($w->status == 'approved')
                            <span class="px-3 py-1 bg-emerald-500/20 text-emerald-400 text-[10px] font-bold uppercase rounded-full">Completed</span>
                        @elseif($w->status == 'pending')
                            <span class="px-3 py-1 bg-amber-500/20 text-amber-400 text-[10px] font-bold uppercase rounded-full">Pending</span>
                        @else
                            <span class="px-3 py-1 bg-red-500/20 text-red-400 text-[10px] font-bold uppercase rounded-full">{{ ucfirst($w->status) }}</span>
                        @endif
                    </td>
                    <td class="text-xs text-gray-500">{{ $w->created_at->format('d M Y') }}</td>
                    <td class="text-right">
                        <a href="{{ route('withdrawals.receipt', $w->id) }}" target="_blank" class="px-3 py-1.5 rounded-lg bg-white/5 text-xs text-gray-400 hover:text-emerald-400 hover:bg-emerald-500/10 transition-all flex items-center gap-2 justify-end" title="Download Receipt">
                            <span class="hidden sm:inline">Receipt</span> <i data-lucide="file-text" class="w-3.5 h-3.5"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-4 text-gray-500 italic">No withdrawals found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-4 border-t border-white/5 flex justify-center bg-white/[0.01]">
        {{ $withdrawals->links() }}
    </div>
</div>
@endsection
