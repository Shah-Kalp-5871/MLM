@extends('layouts.user')

@section('content')
<div class="space-y-10">
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-white">My Vouchers</h1>
            <p class="text-slate-400 text-sm">Reward vouchers earned through network growth and milestones.</p>
        </div>
    </div>

    <!-- Active Vouchers -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @php $activeVouchers = $vouchers->where('status', 'unused'); @endphp
        @forelse($activeVouchers as $voucher)
        <div class="glass relative overflow-hidden group">
            <!-- Decorative Background -->
            <div class="absolute -right-10 -top-10 w-40 h-40 bg-purple-600/10 rounded-full blur-3xl group-hover:bg-purple-600/20 transition-all"></div>
            
            <div class="p-8 relative">
                <div class="flex items-center justify-between mb-6">
                    <div class="w-12 h-12 rounded-2xl bg-purple-600/20 border border-purple-500/30 flex items-center justify-center">
                        <i data-lucide="ticket" class="w-6 h-6 text-purple-400"></i>
                    </div>
                    <span class="badge-active text-[10px] px-3 py-1 rounded-full uppercase tracking-widest font-black">Ready to Use</span>
                </div>

                <div class="space-y-1">
                    <h3 class="text-3xl font-black text-white">{{ $settings['platform_currency_symbol'] ?? '$' }}{{ number_format($voucher->amount, 0) }}</h3>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-widest">Club Reward Voucher</p>
                </div>

                <div class="mt-8 pt-6 border-t border-white/5">
                    <div class="bg-black/40 border border-white/10 rounded-xl p-3 flex items-center justify-between">
                        <code class="text-sm font-mono text-purple-300">{{ $voucher->code }}</code>
                        <button onclick="navigator.clipboard.writeText('{{ $voucher->code }}')" class="text-slate-500 hover:text-white transition-colors">
                            <i data-lucide="copy" class="w-4 h-4"></i>
                        </button>
                    </div>
                    <p class="text-[10px] text-slate-500 mt-3 text-center italic">Use this code for reinvestment or purchases.</p>
                </div>
            </div>
        </div>
        @empty
        <!-- Empty state handled in History if needed, but a blank grid is fine too -->
        @endforelse
    </div>

    <!-- Voucher History -->
    <div class="glass rounded-3xl overflow-hidden mt-10">
        <div class="p-6 border-b border-white/5 bg-white/[0.02]">
            <h3 class="font-bold flex items-center gap-2 text-white">
                <i data-lucide="history" class="w-4 h-4 text-slate-400"></i>
                Voucher History
            </h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-[#0c0c0c] text-slate-500 uppercase text-[10px] font-bold">
                    <tr>
                        <th class="px-6 py-4">Voucher Code</th>
                        <th class="px-6 py-4">Value</th>
                        <th class="px-6 py-4">Type</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Generated</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($vouchers as $v)
                    <tr class="hover:bg-white/[0.01] transition-colors">
                        <td class="px-6 py-4 font-mono text-purple-400 text-xs">{{ $v->code }}</td>
                        <td class="px-6 py-4 font-bold text-white">{{ $settings['platform_currency_symbol'] ?? '$' }}{{ number_format($v->amount, 2) }}</td>
                        <td class="px-6 py-4">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">{{ str_replace('_', ' ', $v->type) }}</span>
                        </td>
                        <td class="px-6 py-4">
                            @if($v->status == 'unused')
                                <span class="text-[10px] font-bold uppercase tracking-widest text-emerald-400">Unused</span>
                            @else
                                <span class="text-[10px] font-bold uppercase tracking-widest text-slate-600">Used ({{ $v->used_at?->format('d M Y') }})</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-slate-500 text-xs">{{ $v->created_at->format('d M Y') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-600 italic">No vouchers found in your history.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-white/5">
            {{ $vouchers->links() }}
        </div>
    </div>
</div>
@endsection
