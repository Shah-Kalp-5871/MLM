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
    {{-- Flash Messages --}}
    @if(session('error'))
    <div class="p-4 rounded-2xl border border-red-500/30 bg-red-500/10 text-red-400 text-sm font-medium">
        {{ session('error') }}
    </div>
    @endif
    @if(session('success'))
    <div class="p-4 rounded-2xl border border-emerald-500/30 bg-emerald-500/10 text-emerald-400 text-sm font-medium">
        {{ session('success') }}
    </div>
    @endif

    {{-- Validation Errors --}}
    @if($errors->any())
    <div class="p-4 rounded-2xl border border-red-500/30 bg-red-500/10 text-red-400 text-sm">
        <ul class="list-disc list-inside space-y-1">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

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
                    <input type="number" name="amount" min="{{ $settings['min_withdrawal'] ?? 200 }}" step="0.01" class="w-full bg-black/40 border border-white/10 rounded-2xl px-6 py-4 text-white text-sm focus:border-emerald-500 focus:outline-none transition-all placeholder:text-gray-600" placeholder="{{ $settings['min_withdrawal'] ?? '200.00' }}" required>
                    <p class="text-[10px] text-gray-500 mt-2 ml-1 italic">Minimum withdrawal amount: {{ $settings['platform_currency_symbol'] ?? '$' }}{{ number_format($settings['min_withdrawal'] ?? 200, 2) }}</p>
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-3 ml-1">Select Payment Method</label>
                    <select name="payment_method" class="w-full bg-black/40 border border-white/10 rounded-2xl px-6 py-4 text-white text-sm focus:border-emerald-500 focus:outline-none transition-all appearance-none cursor-pointer" required>
                        <option value="usdt_trc20">USDT TRC20</option>
                        <option value="bank_transfer">Bank Transfer (IMPS/NEFT)</option>
                        <option value="upi">UPI ID</option>
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
                            <p class="text-[9px] text-gray-500 mt-0.5 uppercase tracking-tighter">{{ str_replace('_', ' ', $w->payment_method) }}</p>
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

<script>
document.getElementById('withdrawalForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const form = this;
    const amount = parseFloat(document.querySelector('input[name="amount"]').value);
    const method = document.querySelector('select[name="payment_method"]').value;
    const address = document.querySelector('input[name="wallet_address"]').value;
    const availableBalance = {{ $wallet->balance ?? 0 }};
    const hasPendingWithdrawal = {{ $withdrawals->where('status', 'pending')->count() > 0 ? 'true' : 'false' }};

    if (hasPendingWithdrawal) {
        Swal.fire({
            icon: 'error',
            title: 'Request Denied',
            text: 'You already have a pending withdrawal request. Please wait for admin approval.',
            background: '#0f0f0f',
            color: '#fff',
            confirmButtonColor: '#10b981',
            customClass: { popup: 'glass rounded-3xl border border-white/10' }
        });
        return;
    }

    if (!amount || !address) {
        Swal.fire({
            icon: 'warning',
            title: 'Missing Fields',
            text: 'Please fill in all fields before proceeding.',
            background: '#0f0f0f',
            color: '#fff',
            confirmButtonColor: '#10b981',
            customClass: { popup: 'glass rounded-3xl border border-white/10' }
        });
        return;
    }

    if (amount > availableBalance) {
        Swal.fire({
            icon: 'error',
            title: 'Insufficient Balance',
            text: 'You only have {{ $settings["platform_currency_symbol"] ?? "$" }}' + availableBalance.toFixed(2) + ' available in your profit wallet.',
            background: '#0f0f0f',
            color: '#fff',
            confirmButtonColor: '#10b981',
            customClass: { popup: 'glass rounded-3xl border border-white/10' }
        });
        return;
    }

    Swal.fire({
        title: 'Confirm Withdrawal',
        html: `
            <div class="text-left space-y-4 p-4 bg-white/5 rounded-2xl border border-white/10 mt-4">
                <div class="flex justify-between items-center border-b border-white/5 pb-2">
                    <span class="text-[10px] text-gray-500 uppercase font-black tracking-widest">Amount</span>
                    <span class="text-sm font-bold text-emerald-400 font-mono">{{ $settings["platform_currency_symbol"] ?? "$" }}${amount.toFixed(2)}</span>
                </div>
                <div class="flex justify-between items-center border-b border-white/5 pb-2">
                    <span class="text-[10px] text-gray-500 uppercase font-black tracking-widest">Method</span>
                    <span class="text-sm font-bold text-white uppercase">${method.replace('_', ' ')}</span>
                </div>
                <div class="flex flex-col gap-1">
                    <span class="text-[10px] text-gray-500 uppercase font-black tracking-widest">Destination</span>
                    <span class="text-[11px] font-mono text-gray-400 break-all">${address}</span>
                </div>
            </div>
        `,
        icon: 'question',
        showCancelButton: true,
        background: '#0f0f0f',
        color: '#fff',
        confirmButtonColor: '#10b981',
        cancelButtonColor: '#ef4444',
        confirmButtonText: 'Yes, Process It!',
        cancelButtonText: 'Cancel',
        customClass: {
            popup: 'glass rounded-3xl border border-white/10 shadow-2xl',
            confirmButton: 'rounded-xl px-6 py-3 font-bold text-xs uppercase',
            cancelButton: 'rounded-xl px-6 py-3 font-bold text-xs uppercase'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
});
</script>
@endsection
