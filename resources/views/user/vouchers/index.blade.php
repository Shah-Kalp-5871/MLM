@extends('layouts.user')

@section('content')
<div class="space-y-10">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-white">My Vouchers</h1>
            <p class="text-slate-400 text-sm italic">Earned from network milestones or transferred rewards.</p>
        </div>
        <a href="{{ route('vouchers.redeem') }}" class="px-8 py-4 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white font-black uppercase tracking-widest transition-all shadow-xl shadow-emerald-900/20 flex items-center gap-3">
            <i data-lucide="zap" class="w-4 h-4"></i> Redeem Code
        </a>
    </div>

    <!-- Active Vouchers (Earned) -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @php $activeVouchers = $vouchers->where('status', 'unused'); @endphp
        @forelse($activeVouchers as $voucher)
        <div class="glass relative overflow-hidden group">
            <div class="absolute -right-10 -top-10 w-40 h-40 bg-purple-600/10 rounded-full blur-3xl group-hover:bg-purple-600/20 transition-all"></div>
            
            <div class="p-8 relative">
                <div class="flex items-center justify-between mb-6">
                    <div class="w-12 h-12 rounded-2xl bg-purple-600/20 border border-purple-500/30 flex items-center justify-center">
                        <i data-lucide="ticket" class="w-6 h-6 text-purple-400"></i>
                    </div>
                    <span class="text-[10px] px-3 py-1 rounded-full uppercase tracking-widest font-black bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">Ready to Use</span>
                </div>

                <div class="space-y-1">
                    <h3 class="text-3xl font-black text-white">{{ $settings['platform_currency_symbol'] ?? '$' }}{{ number_format($voucher->amount, 0) }}</h3>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-widest">Earned Reward</p>
                </div>

                <div class="mt-8 pt-6 border-t border-white/5">
                    <div class="bg-black/40 border border-white/10 rounded-xl p-3 flex items-center justify-between">
                        <code class="text-sm font-mono text-purple-300">{{ $voucher->code }}</code>
                        <button onclick="navigator.clipboard.writeText('{{ $voucher->code }}'); this.innerHTML='<i data-lucide=\'check\' class=\'w-4 h-4 text-emerald-400\'></i>'; setTimeout(()=>this.innerHTML='<i data-lucide=\'copy\' class=\'w-4 h-4\'></i>', 2000)" class="text-slate-500 hover:text-white transition-colors">
                            <i data-lucide="copy" class="w-4 h-4"></i>
                        </button>
                    </div>
                    <p class="text-[10px] text-slate-500 mt-3 text-center italic">Transferable: Send this code to anyone!</p>
                </div>
            </div>
        </div>
        @empty
        @endforelse
    </div>

    <!-- History Tabs -->
    <div class="space-y-6">
        <h3 class="text-lg font-bold text-white uppercase tracking-tight flex items-center gap-2">
            <i data-lucide="history" class="w-5 h-5 text-slate-500"></i> 
            Voucher Transactions
        </h3>

        <!-- Earned Vouchers Table -->
        <div class="glass rounded-3xl overflow-hidden">
            <div class="p-6 border-b border-white/5 bg-white/[0.02]">
                <h4 class="text-xs font-black uppercase tracking-widest text-slate-400">Vouchers You Earned</h4>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-[#0c0c0c] text-slate-500 uppercase text-[10px] font-bold">
                        <tr>
                            <th class="px-6 py-4">Code</th>
                            <th class="px-6 py-4">Value</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4">Used By</th>
                            <th class="px-6 py-4">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @forelse($vouchers as $v)
                        <tr class="hover:bg-white/[0.01] transition-colors">
                            <td class="px-6 py-4 font-mono text-purple-400">{{ $v->code }}</td>
                            <td class="px-6 py-4 font-bold text-white">{{ $settings['platform_currency_symbol'] ?? '$' }}{{ number_format($v->amount, 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($v->status == 'unused')
                                    <span class="px-2 py-0.5 rounded-full text-[9px] font-black uppercase bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">Unused</span>
                                @else
                                    <span class="px-2 py-0.5 rounded-full text-[9px] font-black uppercase bg-white/5 text-slate-500 border border-white/10">Used</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($v->used_by)
                                    <div class="flex items-center gap-2">
                                        <div class="w-5 h-5 rounded-full bg-slate-800 flex items-center justify-center text-[8px] font-bold text-slate-500">
                                            {{ substr($v->redeemer?->name, 0, 1) }}
                                        </div>
                                        <span class="text-xs text-slate-400">{{ $v->used_by == auth()->id() ? 'You' : $v->redeemer?->name }}</span>
                                    </div>
                                @else
                                    <span class="text-[10px] text-slate-600 italic">Not yet used</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-slate-500 text-xs">{{ $v->created_at->format('d M Y') }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="px-6 py-10 text-center text-slate-600 italic">You haven't earned any reward vouchers yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Redeemed Vouchers Table -->
        <div class="glass rounded-3xl overflow-hidden mt-8">
            <div class="p-6 border-b border-white/5 bg-white/[0.02]">
                <h4 class="text-xs font-black uppercase tracking-widest text-slate-400">Vouchers You Redeemed</h4>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-[#0c0c0c] text-slate-500 uppercase text-[10px] font-bold">
                        <tr>
                            <th class="px-6 py-4">Code</th>
                            <th class="px-6 py-4">Value</th>
                            <th class="px-6 py-4">Earned By</th>
                            <th class="px-6 py-4">Redeemed At</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @forelse($redeemedVouchers as $rv)
                        <tr class="hover:bg-white/[0.01] transition-colors">
                            <td class="px-6 py-4 font-mono text-emerald-400">{{ $rv->code }}</td>
                            <td class="px-6 py-4 font-bold text-white">{{ $settings['platform_currency_symbol'] ?? '$' }}{{ number_format($rv->amount, 2) }}</td>
                            <td class="px-6 py-4">
                                <span class="text-xs text-slate-400">
                                    {{ $rv->owner_id == auth()->id() ? 'Self' : ($rv->owner?->name ?? 'System') }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-slate-500 text-xs">{{ $rv->used_at?->format('d M Y H:i') }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="px-6 py-10 text-center text-slate-600 italic">You haven't redeemed any vouchers yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

