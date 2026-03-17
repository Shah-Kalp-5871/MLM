@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Voucher Report</h1>
            <p class="text-slate-500 text-sm">Full lifecycle tracking of all platform vouchers.</p>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Total Generated</p>
            <h3 class="text-2xl font-bold text-slate-800">{{ $stats['total_generated'] }}</h3>
        </div>
        <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Total Value</p>
            <h3 class="text-2xl font-bold text-emerald-600">${{ number_format($stats['total_value'], 2) }}</h3>
        </div>
        <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Vouchers Used</p>
            <h3 class="text-2xl font-bold text-blue-600">{{ $stats['total_used'] }}</h3>
        </div>
        <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Unused Value</p>
            <h3 class="text-2xl font-bold text-orange-600">${{ number_format($stats['unused_value'], 2) }}</h3>
        </div>
    </div>

    <!-- Vouchers Table -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
            <h3 class="font-bold text-slate-700">All Vouchers</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50 text-slate-500 uppercase text-[10px] font-black">
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
                <tbody class="divide-y divide-slate-100">
                    @forelse($vouchers as $v)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 font-mono font-bold text-indigo-600">{{ $v->code }}</td>
                        <td class="px-6 py-4 font-bold text-slate-800">${{ number_format($v->amount, 2) }}</td>
                        <td class="px-6 py-4">
                            @if($v->status == 'unused')
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase bg-emerald-100 text-emerald-600 border border-emerald-200">Unused</span>
                            @else
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase bg-slate-100 text-slate-400 border border-slate-200">Used</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-col">
                                <span class="font-bold text-slate-700">{{ $v->owner?->name }}</span>
                                <span class="text-[10px] text-slate-400 tracking-tighter">{{ $v->owner?->email }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if($v->used_by)
                                <div class="flex flex-col">
                                    <span class="font-bold text-blue-600">{{ $v->redeemer?->name }}</span>
                                    <span class="text-[10px] text-slate-400 tracking-tighter">{{ $v->redeemer?->email }}</span>
                                </div>
                            @else
                                <span class="text-xs text-slate-300 italic">No redeemer yet</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-slate-500 text-xs">{{ $v->created_at->format('d M Y H:i') }}</td>
                        <td class="px-6 py-4 text-slate-500 text-xs">
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
        <div class="p-4 border-t border-slate-100 bg-slate-50/30">
            {{ $vouchers->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
