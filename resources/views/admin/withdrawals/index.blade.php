@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight">Withdrawal Requests</h1>
            <p class="text-slate-400 text-sm">Approve and track payout requests efficiently.</p>
        </div>
        <div class="flex items-center gap-3">
             <span class="text-xs font-bold text-amber-500 bg-amber-500/10 px-3 py-1.5 rounded-full border border-amber-500/20">{{ $pendingCount }} PENDING WITHDRAWALS</span>
             <button class="bg-[#121212] border border-[#1f1f1f] px-4 py-2 rounded-xl text-sm font-medium hover:border-slate-700 transition-all flex items-center gap-2">
                <i data-lucide="download" class="w-4 h-4"></i> Export Batch
            </button>
        </div>
    </div>

    <!-- Active Requests -->
    <div class="glass rounded-3xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-[#0c0c0c] text-slate-500 uppercase text-[10px] font-bold">
                    <tr>
                        <th class="px-6 py-4">User</th>
                        <th class="px-6 py-4">Wallet Balance</th>
                        <th class="px-6 py-4">Request Amount</th>
                        <th class="px-6 py-4">Fee (5%)</th>
                        <th class="px-6 py-4">Net Payout</th>
                        <th class="px-6 py-4">Method</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#1f1f1f]">
                    @forelse ($withdrawals as $withdrawal)
                    <tr class="hover:bg-white/[0.02] transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <span class="font-medium text-slate-200">{{ $withdrawal->user->name ?? 'Deleted User' }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-slate-400">{{ $settings['platform_currency_symbol'] ?? '$' }}{{ number_format($withdrawal->user?->wallet?->balance ?? 0, 2) }}</td>
                        <td class="px-6 py-4 font-bold">{{ $settings['platform_currency_symbol'] ?? '$' }}{{ number_format($withdrawal->amount, 2) }}</td>
                        <td class="px-6 py-4 text-red-500/70">{{ $settings['platform_currency_symbol'] ?? '$' }}{{ number_format($withdrawal->amount * 0.05, 2) }}</td>
                        <td class="px-6 py-4 text-green-400">{{ $settings['platform_currency_symbol'] ?? '$' }}{{ number_format($withdrawal->amount * 0.95, 2) }}</td>
                        <td class="px-6 py-4">
                            <span class="text-xs text-slate-500 bg-slate-800/10 px-2 py-1 rounded border border-[#1f1f1f]">{{ $withdrawal->payment_method }}</span>
                        </td>
                        <td class="px-6 py-4">
                            @if($withdrawal->status == 'pending')
                                <span class="badge-pending text-[10px] px-2 py-0.5 rounded-full uppercase font-bold">Pending</span>
                            @elseif($withdrawal->status == 'approved')
                                <span class="badge-active text-[10px] px-2 py-0.5 rounded-full uppercase font-bold">Paid</span>
                            @else
                                <span class="bg-red-500/10 text-red-500 text-[10px] px-2 py-0.5 rounded-full uppercase font-bold border border-red-500/20">{{ $withdrawal->status }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            @if($withdrawal->status == 'pending')
                            <div class="flex justify-end gap-2">
                                <form action="{{ route('admin.withdrawals.approve', $withdrawal->id) }}" method="POST" id="approve-withdrawal-{{ $withdrawal->id }}">
                                    @csrf
                                    <button type="button" onclick="confirmWithdrawal({{ $withdrawal->id }})" class="text-purple-500 hover:text-purple-400 font-bold text-xs uppercase tracking-wider underline">Mark as Paid</button>
                                </form>
                            </div>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="8" class="px-6 py-12 text-center text-slate-500 italic">No withdrawal requests found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-[#1f1f1f]">
            {{ $withdrawals->links() }}
        </div>
    </div>
</div>
<script>
    function confirmWithdrawal(id) {
        Swal.fire({
            title: 'Confirm Payment?',
            text: "Mark this withdrawal as paid. Ensure you have transferred the funds to the user's address.",
            icon: 'info',
            showCancelButton: true,
            background: '#0f0f0f',
            color: '#fff',
            confirmButtonColor: '#8b5cf6',
            cancelButtonColor: '#374151',
            confirmButtonText: 'Yes, Paid!',
            customClass: {
                popup: 'glass rounded-3xl border border-white/10 shadow-2xl',
                confirmButton: 'rounded-xl px-6 py-3 font-bold text-xs uppercase',
                cancelButton: 'rounded-xl px-6 py-3 font-bold text-xs uppercase'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`approve-withdrawal-${id}`).submit();
            }
        })
    }

    // Success Message Handling
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Processed!',
            text: "{{ session('success') }}",
            background: '#0f0f0f',
            color: '#fff',
            timer: 3000,
            showConfirmButton: false,
            customClass: {
                popup: 'glass rounded-3xl border border-white/10'
            }
        });
    @endif
</script>
@endsection
