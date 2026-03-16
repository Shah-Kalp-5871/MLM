@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight">Voucher Management</h1>
            <p class="text-slate-400 text-sm">Issue and track non-withdrawable club vouchers.</p>
        </div>
        <div class="flex items-center gap-3">
             <a href="{{ route('admin.vouchers.create') }}" class="btn-gradient px-6 py-2 rounded-xl text-sm font-bold shadow-lg shadow-purple-600/10 flex items-center gap-2">
                <i data-lucide="plus" class="w-4 h-4"></i> Generate Voucher
            </a>
        </div>
    </div>

    <!-- Voucher Inventory -->
    <div class="glass rounded-3xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-[#0c0c0c] text-slate-500 uppercase text-[10px] font-bold">
                    <tr>
                        <th class="px-6 py-4">Voucher Code</th>
                        <th class="px-6 py-4">Value</th>
                        <th class="px-6 py-4">Assigned To</th>
                        <th class="px-6 py-4">Type</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Created</th>
                        <th class="px-6 py-4 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#1f1f1f]">
                    @if(count($vouchers) > 0)
                        @foreach($vouchers as $voucher)
                        <tr>
                            <td class="px-6 py-4 font-mono text-purple-400 font-bold">{{ $voucher->code }}</td>
                            <td class="px-6 py-4 font-bold text-slate-200">$settings['platform_currency_symbol']{{ number_format($voucher->value, 2) }}</td>
                            <td class="px-6 py-4 text-slate-400">{{ $voucher->assignedUser->name ?? 'Unassigned' }}</td>
                            <td class="px-6 py-4"><span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">{{ $voucher->type }}</span></td>
                            <td class="px-6 py-4">
                                <span class="badge {{ $voucher->status == 'unused' ? 'badge-pending' : 'badge-success' }} text-[10px] px-2 py-0.5 rounded-full uppercase font-bold">{{ $voucher->status }}</span>
                            </td>
                            <td class="px-6 py-4 text-xs text-slate-400">{{ $voucher->created_at->diffForHumans() }}</td>
                            <td class="px-6 py-4 text-right">
                                <form action="{{ route('admin.vouchers.destroy', $voucher->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-slate-500 hover:text-red-500 transition-all">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-slate-500 font-bold">No vouchers found in the inventory.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-4">
        {{ $vouchers->links() }}
    </div>
</div>
@endsection
