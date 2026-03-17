@extends('layouts.user')

@section('content')
<div class="mb-8 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold text-white tracking-tight">Wallet</h1>
        <p class="text-xs text-gray-500 font-medium uppercase tracking-widest mt-1">Transaction History</p>
    </div>
    <a href="{{ route('invest.create') }}" class="px-6 py-3 rounded-xl bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-500 hover:to-indigo-500 text-white text-xs font-bold uppercase tracking-wider transition-all shadow-lg shadow-purple-900/40 flex items-center gap-2 animate-pulse hover:animate-none border border-purple-400/30">
        <i data-lucide="plus-circle" class="w-4 h-4"></i> Invest Now
    </a>
</div>

<div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
    <div class="glass-panel p-8 rounded-2xl relative overflow-hidden group border-l-[6px] border-l-emerald-500">
        <div class="absolute right-0 top-0 w-32 h-32 bg-emerald-500/10 rounded-full blur-[40px] pointer-events-none"></div>
        <p class="text-[10px] font-bold text-emerald-400 uppercase tracking-widest mb-2">Available Balance</p>
        <h3 class="text-4xl font-black text-white">{{ $settings['platform_currency_symbol'] ?? '$' }}{{ number_format($wallet->balance ?? 0, 2) }}</h3>
        <p class="text-[10px] text-gray-500 mt-2 font-medium uppercase tracking-widest">Withdrawal Profit (ROI + Level)</p>
    </div>
    <div class="glass-panel p-8 rounded-2xl">
        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Total Earnings</p>
        <h3 class="text-3xl font-bold text-gray-300">{{ $settings['platform_currency_symbol'] ?? '$' }}{{ number_format(($wallet->total_roi_earned ?? 0) + ($wallet->total_level_earned ?? 0), 2) }}</h3>
    </div>
    <div class="glass-panel p-8 rounded-2xl">
        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Total Withdrawn</p>
        <h3 class="text-3xl font-bold text-gray-300">{{ $settings['platform_currency_symbol'] ?? '$' }}{{ number_format($wallet->total_withdrawn ?? 0, 2) }}</h3>
    </div>
</div>

<div class="glass-panel p-4 rounded-xl mb-8 border border-purple-500/20 bg-purple-500/5 flex items-start gap-4">
    <div class="w-10 h-10 rounded-lg bg-purple-500/10 flex items-center justify-center flex-shrink-0">
        <i data-lucide="info" class="w-5 h-5 text-purple-400"></i>
    </div>
    <div>
        <h4 class="text-xs font-bold text-white uppercase tracking-wider mb-1">Quick Note</h4>
        <p class="text-[11px] text-gray-400 leading-relaxed">Your wallet balance consists of weekly ROI and Level Commissions. Club Milestone Rewards are kept in your <a href="{{ route('vouchers.index') }}" class="text-amber-500 hover:underline">Voucher Wallet</a>.</p>
    </div>
</div>

<div class="glass-panel rounded-2xl overflow-hidden mb-10">
    <div class="p-6 border-b border-white/5 bg-white/[0.02]">
        <h2 class="text-sm font-bold text-white uppercase tracking-wider">Wallet Transactions</h2>
    </div>
    <div class="table-wrapper p-4">
        <table>
            <thead>
                <tr>
                    <th>Type</th>
                    <th>Amount</th>
                    <th>Description</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $tx)
                <tr>
                    <td>
                        <span class="px-3 py-1 bg-emerald-500/20 text-emerald-400 text-[10px] font-bold uppercase rounded-full">
                            {{ str_replace('_', ' ', $tx->type) }}
                        </span>
                    </td>
                    <td class="{{ $tx->direction === 'credit' ? 'text-emerald-400' : 'text-rose-400' }} font-bold font-mono">
                        {{ $tx->direction === 'credit' ? '+' : '-' }} {{ $settings['platform_currency_symbol'] ?? '$' }}{{ number_format($tx->amount, 2) }}
                    </td>
                    <td class="text-white">{{ $tx->description }}</td>
                    <td class="text-xs text-gray-500">{{ $tx->created_at?->format('d M Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-8 text-gray-500 italic">No transactions found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-4 border-t border-white/5 flex justify-center bg-white/[0.01]">
        {{ $transactions->links() }}
    </div>
</div>

@endsection
