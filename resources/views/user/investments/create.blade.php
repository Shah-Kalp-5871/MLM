@extends('layouts.user')

@section('content')
<div class="mb-8 flex justify-between items-center text-white">
    <div>
        <h1 class="text-2xl font-bold tracking-tight uppercase">New Investment</h1>
        <p class="text-xs text-gray-500 font-medium uppercase tracking-widest mt-1">Start growing your wealth</p>
    </div>
    <a href="{{ url('user/investments') }}" class="px-6 py-3 rounded-xl glass-panel text-white text-xs font-bold uppercase tracking-wider hover:bg-white/10 transition-all flex items-center gap-2"><i data-lucide="arrow-left" class="w-4 h-4"></i> Back</a>
</div>

<div class="glass-panel max-w-2xl mx-auto rounded-3xl p-10 border border-purple-500/20 shadow-2xl relative overflow-hidden group">
    <!-- Decor -->
    <div class="absolute -top-24 -right-24 w-48 h-48 bg-purple-600/10 rounded-full blur-3xl group-hover:bg-purple-600/20 transition-all"></div>

    <form action="{{ route('deposits.store') }}" method="POST" enctype="multipart/form-data" class="relative z-10 space-y-8">
        @csrf
        <div>
            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-3 ml-1">Choose Package</label>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                @foreach($packages as $package)
                <label class="cursor-pointer group/card">
                    <input type="radio" name="package_id" value="{{ $package->id }}" class="hidden peer" {{ $loop->first ? 'checked' : '' }}>
                    <div class="p-4 rounded-2xl glass-panel border border-white/5 peer-checked:border-purple-500 peer-checked:bg-purple-500/10 transition-all text-center">
                        <p class="text-[10px] font-bold text-gray-500 uppercase mb-1">{{ $package->name }}</p>
                        <p class="text-white font-black">$settings['platform_currency_symbol']{{ number_format($package->price, 0) }}</p>
                    </div>
                </label>
                @endforeach
            </div>
        </div>

        <div class="space-y-6">
            <div>
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-3 ml-1">Investment Amount ($settings['platform_currency_symbol'])</label>
                <input type="number" name="amount" step="0.01" class="w-full bg-black/40 border border-white/10 rounded-2xl px-6 py-4 text-white text-sm focus:border-purple-500 focus:outline-none transition-all placeholder:text-gray-600" placeholder="500.00" required>
            </div>

            <div>
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-3 ml-1">Payment Method</label>
                <select name="payment_method" class="w-full bg-black/40 border border-white/10 rounded-2xl px-6 py-4 text-white text-sm focus:border-purple-500 focus:outline-none transition-all appearance-none cursor-pointer" required>
                    <option value="USDT TRC20">USDT TRC20</option>
                    <option value="Bank Transfer">Bank Transfer</option>
                    <option value="Internal Wallet">Internal Wallet Balance</option>
                </select>
            </div>

            <div>
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-3 ml-1">Transaction Hash / Reference ID</label>
                <input type="text" name="transaction_hash" class="w-full bg-black/40 border border-white/10 rounded-2xl px-6 py-4 text-white text-sm focus:border-purple-500 focus:outline-none transition-all placeholder:text-gray-600" placeholder="Optional reference ID">
            </div>

            <div>
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-3 ml-1">Payment Proof (Screenshot)</label>
                <div onclick="document.getElementById('proof_upload').click()" class="relative group/upload h-32 border-2 border-dashed border-white/10 rounded-2xl flex flex-col items-center justify-center bg-black/20 hover:bg-black/40 hover:border-purple-500/30 transition-all cursor-pointer">
                    <i data-lucide="cloud-upload" class="w-8 h-8 text-gray-500 group-hover/upload:text-purple-400 mb-2 transition-all"></i>
                    <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest">Click to upload image</p>
                    <input type="file" id="proof_upload" name="payment_proof" class="absolute inset-0 opacity-0 cursor-pointer">
                </div>
            </div>
        </div>

        <button type="submit" class="w-full py-4 rounded-2xl bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-500 hover:to-indigo-500 text-white text-xs font-black uppercase tracking-[0.2em] transition-all shadow-xl shadow-purple-900/40 flex items-center justify-center gap-3">
            Submit Application <i data-lucide="send" class="w-4 h-4"></i>
        </button>
    </form>
</div>
@endsection

