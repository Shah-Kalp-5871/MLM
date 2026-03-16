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
            <h3 class="text-3xl font-black text-white">₹{{ number_format($wallet->balance ?? 0, 2) }}</h3>
        </div>
        <div class="w-14 h-14 rounded-2xl bg-emerald-500/10 flex items-center justify-center text-emerald-400">
            <i data-lucide="wallet" class="w-8 h-8"></i>
        </div>
    </div>

    <!-- Form -->
    <div class="glass-panel rounded-3xl p-10 border border-white/5 shadow-2xl relative overflow-hidden group">
        <form class="space-y-8 relative z-10" action="{{ route('withdraw.store') }}" method="POST">
            @csrf
            <div class="space-y-6">
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-3 ml-1">Withdrawal Amount (₹)</label>
                    <input type="number" name="amount" min="{{ $settings['min_withdrawal'] ?? 10 }}" step="0.01" class="w-full bg-black/40 border border-white/10 rounded-2xl px-6 py-4 text-white text-sm focus:border-emerald-500 focus:outline-none transition-all placeholder:text-gray-600" placeholder="{{ $settings['min_withdrawal'] ?? '100.00' }}" required>
                    <p class="text-[10px] text-gray-500 mt-2 ml-1 italic">Minimum withdrawal amount: ₹{{ number_format($settings['min_withdrawal'] ?? 10, 2) }}</p>
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
</div>
@endsection