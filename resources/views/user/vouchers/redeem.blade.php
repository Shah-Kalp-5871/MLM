@extends('layouts.user')

@section('content')
<div class="max-w-2xl mx-auto space-y-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-white tracking-tight">Redeem Voucher</h1>
            <p class="text-xs text-gray-500 font-medium uppercase tracking-widest mt-1">Convert code to instant investment</p>
        </div>
        <a href="{{ route('vouchers.index') }}" class="text-xs font-bold text-emerald-400 uppercase tracking-widest hover:text-emerald-300 transition-all flex items-center gap-2">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> My Vouchers
        </a>
    </div>

    @if(session('error'))
    <div class="p-4 rounded-2xl border border-red-500/30 bg-red-500/10 text-red-400 text-sm font-medium animate-in fade-in slide-in-from-top-4">
        {{ session('error') }}
    </div>
    @endif

    <div class="glass p-10 rounded-3xl border border-white/5 relative overflow-hidden group">
        <div class="absolute -top-24 -right-24 w-48 h-48 bg-emerald-600/10 rounded-full blur-3xl group-hover:bg-emerald-600/20 transition-all"></div>
        
        <form action="{{ route('vouchers.redeem.submit') }}" method="POST" class="relative z-10 space-y-8">
            @csrf
            
            <div class="text-center space-y-4 mb-8">
                <div class="w-20 h-20 rounded-3xl bg-emerald-500/10 flex items-center justify-center text-emerald-500 mx-auto border border-emerald-500/20 shadow-lg shadow-emerald-500/5">
                    <i data-lucide="ticket" class="w-10 h-10"></i>
                </div>
                <h2 class="text-xl font-bold text-white uppercase tracking-tight">Enter Voucher Code</h2>
                <p class="text-gray-400 text-sm max-w-xs mx-auto">Voucher codes are one-time use and instantly create a new active investment for you.</p>
            </div>

            <div class="space-y-4">
                <div class="relative">
                    <input type="text" name="code" placeholder="CLUBX-XXXXXXXX" 
                        class="w-full bg-black/40 border-2 border-white/5 focus:border-emerald-500/50 rounded-2xl px-6 py-5 text-2xl font-black text-white text-center focus:outline-none transition-all placeholder:text-gray-800 uppercase tracking-[0.2em]"
                        required autocomplete="off">
                </div>
                <p class="text-[10px] text-gray-500 text-center uppercase tracking-widest font-bold">Anyone with this code can use it. Keep it secure.</p>
            </div>

            <button type="submit" class="w-full py-5 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white font-black uppercase tracking-[0.3em] transition-all shadow-2xl shadow-emerald-900/40 transform active:scale-[0.98] flex items-center justify-center gap-3">
                Redeem & Invest Now <i data-lucide="zap" class="w-4 h-4"></i>
            </button>
        </form>
    </div>

    <!-- Info Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="p-6 rounded-2xl bg-white/5 border border-white/10">
            <div class="flex items-center gap-3 mb-3">
                <div class="p-2 rounded-lg bg-emerald-500/10 text-emerald-400">
                    <i data-lucide="refresh-cw" class="w-4 h-4"></i>
                </div>
                <h4 class="text-sm font-bold text-white uppercase tracking-wider">Transferable</h4>
            </div>
            <p class="text-xs text-gray-400 leading-relaxed">Vouchers aren't locked to your account. You can give or sell your code to any other user on the platform.</p>
        </div>
        <div class="p-6 rounded-2xl bg-white/5 border border-white/10">
            <div class="flex items-center gap-3 mb-3">
                <div class="p-2 rounded-lg bg-blue-500/10 text-blue-400">
                    <i data-lucide="check-circle" class="w-4 h-4"></i>
                </div>
                <h4 class="text-sm font-bold text-white uppercase tracking-wider">Instant ROI</h4>
            </div>
            <p class="text-xs text-gray-400 leading-relaxed">Redeeming a voucher creates an active investment immediately. No admin approval required for vouchers.</p>
        </div>
    </div>
</div>
@endsection
