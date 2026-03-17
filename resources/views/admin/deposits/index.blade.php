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
                            <button onclick="viewProof('{{ asset('storage/' . $dep->payment_proof) }}')" class="bg-purple-600/10 text-purple-400 hover:bg-purple-600/20 px-3 py-1 rounded-lg text-xs font-bold transition-all border border-purple-600/20">View Proof</button>
                            @else
                            <span class="text-[10px] text-slate-600 italic">No proof uploaded</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-xs text-slate-400">{{ $dep->created_at->diffForHumans() }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-3">
                                @if($dep->status == 'pending')
                                <form action="{{ route('admin.deposits.approve', $dep->id) }}" method="POST" id="approve-form-{{ $dep->id }}">
                                    @csrf
                                    <button type="button" onclick="confirmApproval({{ $dep->id }})" class="px-4 py-2 rounded-xl bg-green-500/10 text-green-500 hover:bg-green-500 hover:text-white transition-all border border-green-500/20 text-[10px] font-black uppercase">
                                        Approve
                                    </button>
                                </form>
                                <button onclick="openRejectModal({{ $dep->id }}, '{{ $dep->user->name }}')" class="px-4 py-2 rounded-xl bg-red-500/10 text-red-500 hover:bg-red-500 hover:text-white transition-all border border-red-500/20 text-[10px] font-black uppercase">
                                    Reject
                                </button>
                                @else
                                <span class="text-[10px] font-bold uppercase {{ $dep->status == 'approved' ? 'text-green-500' : 'text-red-500' }}">{{ $dep->status }}</span>
                                @endif
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
        @if($deposits->hasPages())
        <div class="p-6 border-t border-[#1f1f1f] flex items-center justify-between">
            <span class="text-xs text-slate-500 font-medium">
                Showing {{ $deposits->firstItem() }} to {{ $deposits->lastItem() }} of {{ $deposits->total() }} deposits
            </span>
            <div>
                {{ $deposits->links() }}
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Proof Modal -->
<div id="proofModal" class="fixed inset-0 bg-black/90 backdrop-blur-xl hidden z-[100] flex items-center justify-center p-4">
    <div class="max-w-4xl w-full">
        <div class="flex justify-end mb-4">
            <button onclick="closeModal('proofModal')" class="text-white hover:text-purple-400"><i data-lucide="x" class="w-8 h-8"></i></button>
        </div>
        <img id="proofImage" src="" class="w-full max-h-[80vh] object-contain rounded-2xl shadow-2xl border border-white/10">
    </div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="fixed inset-0 bg-black/80 backdrop-blur-sm hidden z-[100] flex items-center justify-center p-4">
    <div class="max-w-md w-full glass p-8 rounded-3xl border border-white/10 shadow-2xl animate-in zoom-in duration-300">
        <h3 class="text-xl font-bold text-white mb-2">Reject Deposit</h3>
        <p class="text-sm text-slate-400 mb-6">User: <span id="rejectUserName" class="text-white font-bold"></span></p>
        
        <form id="rejectForm" action="" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="text-[10px] uppercase font-bold text-slate-500 tracking-widest px-1">Reason for Rejection</label>
                <textarea name="reason" rows="3" class="w-full bg-black/40 border border-white/10 rounded-2xl px-5 py-3.5 text-slate-200 text-sm focus:border-red-500 focus:outline-none transition-all" placeholder="e.g. Screenshot pixelated, Please re-upload clear proof." required></textarea>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="button" onclick="closeModal('rejectModal')" class="flex-1 py-4 rounded-2xl bg-slate-800 text-white text-xs font-black uppercase tracking-widest transition-all">Cancel</button>
                <button type="submit" class="flex-1 py-4 rounded-2xl bg-red-600 hover:bg-red-500 text-white text-xs font-black uppercase tracking-widest transition-all shadow-xl shadow-red-900/40">Confirm Reject</button>
            </div>
        </form>
    </div>
</div>

<script>
    function confirmApproval(id) {
        Swal.fire({
            title: 'Approve Deposit?',
            text: "The amount will be added to the user's wallet and the investment will be activated.",
            icon: 'warning',
            showCancelButton: true,
            background: '#0f0f0f',
            color: '#fff',
            confirmButtonColor: '#10b981',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, Approve!',
            customClass: {
                popup: 'glass rounded-3xl border border-white/10 shadow-2xl',
                confirmButton: 'rounded-xl px-6 py-3 font-bold text-xs uppercase',
                cancelButton: 'rounded-xl px-6 py-3 font-bold text-xs uppercase'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`approve-form-${id}`).submit();
            }
        })
    }

    function viewProof(url) {
        document.getElementById('proofImage').src = url;
        document.getElementById('proofModal').classList.remove('hidden');
    }
    
    function openRejectModal(id, name) {
        document.getElementById('rejectUserName').innerText = name;
        document.getElementById('rejectForm').action = `/admin/deposits/${id}/reject`;
        document.getElementById('rejectModal').classList.remove('hidden');
    }
    
    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
    }

    // Success Message Handling
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success!',
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

