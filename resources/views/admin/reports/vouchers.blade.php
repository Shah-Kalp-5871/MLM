@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-white">Voucher Report</h1>
            <p class="text-muted text-sm italic">Full lifecycle tracking of all platform vouchers.</p>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="stats-card p-6 rounded-2xl glass">
            <p class="text-[10px] font-bold text-muted uppercase tracking-widest mb-1">Total Generated</p>
            <h3 class="text-2xl font-bold text-white">{{ $stats['total_generated'] }}</h3>
        </div>
        <div class="stats-card p-6 rounded-2xl glass border-l-2 border-l-emerald-500/50">
            <p class="text-[10px] font-bold text-muted uppercase tracking-widest mb-1">Total Value</p>
            <h3 class="text-2xl font-bold text-emerald-400">${{ number_format($stats['total_value'], 2) }}</h3>
        </div>
        <div class="stats-card p-6 rounded-2xl glass border-l-2 border-l-blue-500/50">
            <p class="text-[10px] font-bold text-muted uppercase tracking-widest mb-1">Vouchers Used</p>
            <h3 class="text-2xl font-bold text-blue-400">{{ $stats['total_used'] }}</h3>
        </div>
        <div class="stats-card p-6 rounded-2xl glass border-l-2 border-l-orange-500/50">
            <p class="text-[10px] font-bold text-muted uppercase tracking-widest mb-1">Unused Value</p>
            <h3 class="text-2xl font-bold text-orange-400">${{ number_format($stats['unused_value'], 2) }}</h3>
        </div>
    </div>

    <!-- Vouchers Table -->
    <div class="glass rounded-2xl overflow-hidden shadow-2xl">
        <div class="p-6 border-b border-white/5 flex justify-between items-center bg-white/5">
            <h3 class="font-bold text-white">All Vouchers</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-[#0c0c0c] text-muted uppercase text-[10px] font-black tracking-widest">
                    <tr>
                        <th class="px-6 py-4">Code</th>
                        <th class="px-6 py-4">Value</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Owner (Earned)</th>
                        <th class="px-6 py-4">Redeemer (Used By)</th>
                        <th class="px-6 py-4">Generated</th>
                        <th class="px-6 py-4">Used At</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($vouchers as $v)
                    <tr class="hover:bg-white/[0.02] transition-colors group">
                        <td class="px-6 py-4 font-mono font-bold text-purple-400">{{ $v->code }}</td>
                        <td class="px-6 py-4 font-bold text-white">${{ number_format($v->amount, 2) }}</td>
                        <td class="px-6 py-4">
                            @if($v->status == 'unused')
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">Unused</span>
                            @else
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase bg-white/5 text-slate-500 border border-white/10">Used</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-col">
                                <span class="font-bold text-slate-200">{{ $v->owner?->name }}</span>
                                <span class="text-[10px] text-muted tracking-tighter">{{ $v->owner?->email }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if($v->used_by)
                                <div class="flex flex-col text-blue-400">
                                    <span class="font-bold">{{ $v->redeemer?->name }}</span>
                                    <span class="text-[10px] text-muted tracking-tighter">{{ $v->redeemer?->email }}</span>
                                </div>
                            @else
                                <span class="text-xs text-slate-500 italic">No redeemer yet</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-muted text-xs">{{ $v->created_at->format('d M Y H:i') }}</td>
                        <td class="px-6 py-4 text-muted text-xs">
                            {{ $v->used_at ? $v->used_at->format('d M Y H:i') : '-' }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-slate-400 italic">No vouchers found in the system.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($vouchers->hasPages())
        <div class="p-4 border-t border-white/5 bg-black/20">
            {{ $vouchers->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
