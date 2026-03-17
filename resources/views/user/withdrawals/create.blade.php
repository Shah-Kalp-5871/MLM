@extends('layouts.user')

@section('content')
<div class="mb-8 flex justify-between items-center text-white">
    <div>
        <h1 class="text-2xl font-bold tracking-tight uppercase">Request Withdrawal</h1>
        <p class="text-xs text-gray-500 font-medium uppercase tracking-widest mt-1">Cash out your profit earnings</p>
    </div>
    <a href="{{ route('wallet.index') }}" class="px-6 py-3 rounded-xl glass-panel text-white text-xs font-bold uppercase tracking-wider hover:bg-white/10 transition-all flex items-center gap-2"><i data-lucide="arrow-left" class="w-4 h-4"></i> Back</a>
</div>

<div class="max-w-2xl mx-auto space-y-8">
    <!-- Balance Summary -->
    <div class="glass-panel rounded-3xl p-8 border border-emerald-500/20 bg-emerald-500/5 flex items-center justify-between">
        <div>
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Available Profit</p>
            <h3 class="text-3xl font-black text-white">{{ $settings['platform_currency_symbol'] ?? '$' }}{{ number_format($wallet->balance ?? 0, 2) }}</h3>
        </div>
        <div class="w-14 h-14 rounded-2xl bg-emerald-500/10 flex items-center justify-center text-emerald-400">
            <i data-lucide="wallet" class="w-8 h-8"></i>
        </div>
    </div>

    <!-- Form -->
    <div class="glass-panel rounded-3xl p-10 border border-white/5 shadow-2xl relative overflow-hidden group">
        <form id="withdrawalForm" class="space-y-8 relative z-10" action="{{ route('withdraw.store') }}" method="POST">
            @csrf
            <div class="space-y-6">
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-3 ml-1">Withdrawal Amount ({{ $settings['platform_currency_symbol'] ?? '$' }})</label>
                    <input type="number" name="amount" min="{{ $settings['min_withdrawal'] ?? 10 }}" step="0.01" class="w-full bg-black/40 border border-white/10 rounded-2xl px-6 py-4 text-white text-sm focus:border-emerald-500 focus:outline-none transition-all placeholder:text-gray-600" placeholder="{{ $settings['min_withdrawal'] ?? '100.00' }}" required>
                    <p class="text-[10px] text-gray-500 mt-2 ml-1 italic">Minimum withdrawal amount: {{ $settings['platform_currency_symbol'] ?? '$' }}{{ number_format($settings['min_withdrawal'] ?? 10, 2) }}</p>
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-3 ml-1">Select Payment Method</label>
                    <select name="payment_method" class="w-full bg-black/40 border border-white/10 rounded-2xl px-6 py-4 text-white text-sm focus:border-emerald-500 focus:outline-none transition-all appearance-none cursor-pointer" required>
                        <option value="USDT TRC20">USDT TRC20</option>
                        <option value="Bank Transfer">Bank Transfer (IMPS/NEFT)</option>
                        <option value="UPI">UPI ID</option>
                    </select>
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-3 ml-1">Destination Address / Details</label>
                    <input type="text" name="wallet_address" class="w-full bg-black/40 border border-white/10 rounded-2xl px-6 py-4 text-white text-sm focus:border-emerald-500 focus:outline-none transition-all placeholder:text-gray-600 font-mono" placeholder="Enter Wallet Address or Bank AC/IFSC" required>
                </div>
            </div>

            <button type="submit" class="w-full py-4 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white text-xs font-black uppercase tracking-[0.2em] transition-all shadow-xl shadow-emerald-900/40 flex items-center justify-center gap-3">
                Process Withdrawal <i data-lucide="download" class="w-4 h-4"></i>
            </button>
        </form>
    </div>

    <!-- Warning -->
    <div class="p-6 rounded-2xl border border-amber-500/10 bg-amber-500/5 flex items-start gap-4">
        <i data-lucide="alert-circle" class="w-5 h-5 text-amber-500 flex-shrink-0 mt-0.5"></i>
        <p class="text-[11px] text-gray-400 leading-relaxed">Please ensure your destination details are correct. Settlements may take up to 24-48 business hours. <br> <span class="text-white font-bold underline">Vouchers cannot be withdrawn.</span></p>
    </div>

    <!-- Recent Withdrawals -->
    <div class="glass-panel rounded-2xl overflow-hidden border border-white/5">
        <div class="p-6 border-b border-white/5 bg-white/[0.02] flex justify-between items-center">
            <h2 class="text-sm font-bold text-white uppercase tracking-wider">Recent Withdrawals</h2>
            <a href="{{ route('withdrawals.index') }}" class="text-[10px] text-emerald-400 font-bold uppercase hover:underline">View All</a>
        </div>
        <div class="table-wrapper p-4">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-[10px] font-bold text-gray-500 uppercase tracking-widest border-b border-white/5">
                        <th class="pb-4 pl-2">Amount</th>
                        <th class="pb-4">Status</th>
                        <th class="pb-4">Date</th>
                        <th class="pb-4 text-right pr-2">Action</th>
                    </tr>
                </thead>
                <tbody class="text-xs">
                    @forelse($withdrawals as $w)
                    <tr class="border-b border-white/5 last:border-0 group">
                        <td class="py-4 pl-2">
                            <span class="font-bold text-white font-mono">{{ $settings['platform_currency_symbol'] ?? '$' }}{{ number_format($w->amount, 2) }}</span>
                            <p class="text-[9px] text-gray-500 mt-0.5 uppercase tracking-tighter">{{ $w->payment_method }}</p>
                        </td>
                        <td class="py-4">
                            @if($w->status == 'approved')
                                <span class="px-2 py-0.5 bg-emerald-500/20 text-emerald-400 text-[9px] font-bold uppercase rounded-full">Completed</span>
                            @elseif($w->status == 'pending')
                                <span class="px-2 py-0.5 bg-amber-500/20 text-amber-400 text-[9px] font-bold uppercase rounded-full">Pending</span>
                            @else
                                <span class="px-2 py-0.5 bg-red-500/20 text-red-400 text-[9px] font-bold uppercase rounded-full">{{ ucfirst($w->status) }}</span>
                            @endif
                        </td>
                        <td class="py-4 text-gray-400">{{ $w->created_at->format('d M') }}</td>
                        <td class="py-4 text-right pr-2">
                            <a href="{{ route('withdrawals.receipt', $w->id) }}" target="_blank" class="p-2 rounded-lg bg-white/5 text-gray-400 hover:text-emerald-400 transition-all inline-block" title="Download Receipt">
                                <i data-lucide="file-text" class="w-4 h-4"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-8 text-gray-500 italic">No recent withdrawals.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>

<script>
    const availableBalance = {{ $wallet->balance ?? 0 }};
    const hasPendingWithdrawal = {{ $withdrawals->where('status', 'pending')->count() > 0 ? 'true' : 'false' }};

document.getElementById('withdrawalForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    if (hasPendingWithdrawal) {
        Swal.fire({
            title: 'Action Not Allowed',
            text: 'You already have a pending withdrawal request. Please wait for admin approval.',
            icon: 'error',
            background: '#0a0b14',
            color: '#fff',
            confirmButtonColor: '#ef4444',
            customClass: {
                title: 'text-xl font-bold',
                popup: 'border border-rose-500/20 rounded-2xl',
            }
        });
        return;
    }

    const amount = parseFloat(document.querySelector('input[name="amount"]').value);
    const method = document.querySelector('select[name="payment_method"]').value;
    const address = document.querySelector('input[name="wallet_address"]').value;
    
    if(!amount || !address) return; // Let HTML5 validation handle empty fields first
    
    if (amount > availableBalance) {
        Swal.fire({
            title: 'Insufficient Balance',
            text: 'You cannot withdraw more than your available balance.',
            icon: 'error',
            background: '#0a0b14',
            color: '#fff',
            confirmButtonColor: '#ef4444',
            customClass: {
                title: 'text-xl font-bold',
                popup: 'border border-rose-500/20 rounded-2xl',
            }
        });
        return;
    }
    
    Swal.fire({
        title: 'Confirm Withdrawal',
        html: `Are you sure you want to withdraw <strong class="text-emerald-400">${amount}</strong> to your <strong class="text-white">${method}</strong> account (<span class="font-mono text-xs text-gray-400">${address}</span>)?<br><br><span class="text-xs text-rose-400">This action cannot be undone.</span>`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#10b981',
        cancelButtonColor: '#3f3f46',
        confirmButtonText: 'Yes, Process It',
        background: '#0a0b14',
        color: '#fff',
        customClass: {
            title: 'text-xl font-bold',
            popup: 'border border-white/10 rounded-2xl',
        }
    }).then((result) => {
        if (result.isConfirmed) {
            this.submit();
        }
    });
});
</script>
@endsection
