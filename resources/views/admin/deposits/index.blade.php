@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight">Deposit Approvals</h1>
            <p class="text-slate-400 text-sm">Review manual payment proofs and activate investments.</p>
        </div>
        <div class="flex items-center gap-3">
            <span class="text-xs font-bold text-amber-500 bg-amber-500/10 px-3 py-1.5 rounded-full border border-amber-500/20">{{ $pendingCount }} PENDING DEPOSITS</span>
        </div>
    </div>

    <!-- Active Queue -->
    <div class="glass rounded-3xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-[#0c0c0c] text-slate-500 uppercase text-[10px] font-bold">
                    <tr>
                        <th class="px-6 py-4">User</th>
                        <th class="px-6 py-4">Amount</th>
                        <th class="px-6 py-4">Transaction Info</th>
                        <th class="px-6 py-4 text-center">Proof</th>
                        <th class="px-6 py-4">Submitted</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#1f1f1f]">
                    @forelse($deposits as $dep)
                    <tr class="hover:bg-white/[0.02] transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-slate-800 border border-[#1f1f1f] flex items-center justify-center text-xs font-black">
                                    {{ $dep->user ? substr($dep->user->name, 0, 2) : '??' }}
                                </div>
                                <div class="flex flex-col">
                                    <span class="font-bold text-slate-200">{{ $dep->user->name ?? 'Deleted User' }}</span>
                                    <span class="text-[10px] text-slate-500">{{ $dep->user->email ?? 'N/A' }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 font-bold text-green-400">{{ $settings['platform_currency_symbol'] ?? '$' }}{{ number_format($dep->amount, 2) }}</td>
                        <td class="px-6 py-4">
                            <div class="flex flex-col">
                                <span class="text-xs text-slate-300">{{ $dep->payment_method }}</span>
                                <span class="text-[10px] text-slate-500 font-mono">{{ $dep->transaction_hash }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($dep->payment_proof)
                            <a href="{{ asset('storage/' . $dep->payment_proof) }}" target="_blank" class="bg-purple-600/10 text-purple-400 hover:bg-purple-600/20 px-3 py-1 rounded-lg text-xs font-bold transition-all border border-purple-600/20">View Proof</a>
                            @else
                            <span class="text-[10px] text-slate-600 italic">No proof uploaded</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-xs text-slate-400">{{ $dep->created_at->diffForHumans() }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-3">
                                @if($dep->status == 'pending')
                                <form action="{{ route('admin.deposits.approve', $dep->id) }}" method="POST">
                                    @csrf
                                    <button class="px-4 py-2 rounded-xl bg-green-500/10 text-green-500 hover:bg-green-500 hover:text-white transition-all border border-green-500/20 text-[10px] font-black uppercase" title="Approve">
                                        Approve
                                    </button>
                                </form>
                                <form action="{{ route('admin.deposits.reject', $dep->id) }}" method="POST">
                                    @csrf
                                    <button class="px-4 py-2 rounded-xl bg-red-500/10 text-red-500 hover:bg-red-500 hover:text-white transition-all border border-red-500/20 text-[10px] font-black uppercase" title="Reject">
                                        Reject
                                    </button>
                                </form>
                                @endif
                                <a href="{{ route('admin.users.show', $dep->user_id) }}" class="px-4 py-2 rounded-xl bg-purple-600/10 text-purple-400 hover:bg-purple-600 hover:text-white transition-all border border-purple-600/20 text-[10px] font-black uppercase">
                                    View User
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-slate-500 italic">No deposits found in this queue.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
