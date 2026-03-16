@extends('layouts.admin')

@section('content')
<div class="max-w-2xl mx-auto space-y-8">
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.vouchers.index') }}" class="w-10 h-10 rounded-xl glass border border-[#1f1f1f] flex items-center justify-center text-slate-400 hover:text-white transition-all">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
        </a>
        <div>
            <h1 class="text-2xl font-bold tracking-tight">Generate New Voucher</h1>
            <p class="text-slate-400 text-sm">Create pre-paid value coupons for club rewards or manual credit.</p>
        </div>
    </div>

    <div class="glass p-10 rounded-[2.5rem] shadow-2xl relative overflow-hidden">
        <div class="absolute -right-16 -top-16 w-64 h-64 bg-amber-600/5 rounded-full blur-3xl"></div>
        
        <form action="{{ route('admin.vouchers.store') }}" method="POST" class="space-y-8">
            @csrf
            <div class="space-y-6">
                <div class="space-y-2">
                    <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest ml-1">Voucher Value (INR)</label>
                    <div class="relative">
                        <span class="absolute left-5 top-1/2 -translate-y-1/2 text-slate-500 font-bold">$settings['platform_currency_symbol']</span>
                        <input type="number" name="value" placeholder="500" class="w-full bg-[#0c0c0c] border border-[#1f1f1f] rounded-2xl pl-10 pr-5 py-4 text-lg font-black text-slate-200 focus:border-amber-500 outline-none transition-all" required>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest ml-1">Voucher Type</label>
                    <select name="type" class="w-full bg-[#0c0c0c] border border-[#1f1f1f] rounded-2xl px-5 py-4 text-sm focus:border-amber-500 outline-none appearance-none" required>
                        <option value="club_reward">Standard Club Reward</option>
                        <option value="promotion">Special Promotion</option>
                        <option value="manual">Manual Adjustment Credit</option>
                    </select>
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest ml-1">Assign to User (Optional)</label>
                    <select name="assigned_to" class="w-full bg-[#0c0c0c] border border-[#1f1f1f] rounded-2xl px-5 py-4 text-sm focus:border-amber-500 outline-none appearance-none">
                        <option value="">Select User</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->referral_code }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest ml-1">Voucher Code (Optional - leave blank for auto-gen)</label>
                    <input type="text" name="code" placeholder="Leave blank to auto-generate" class="w-full bg-[#0c0c0c] border border-[#1f1f1f] rounded-2xl px-5 py-4 text-sm focus:border-amber-500 outline-none transition-all">
                </div>

                <div class="p-6 bg-amber-500/5 rounded-3xl border border-amber-500/10">
                    <div class="flex items-start gap-4">
                        <i data-lucide="info" class="w-5 h-5 text-amber-500 mt-1"></i>
                        <p class="text-[11px] text-amber-500/80 leading-relaxed font-medium">
                            Once generated, vouchers are permanently added to the system ledger. Vouchers are non-withdrawable and can only be used for internal package investments or peer-to-peer transfers if enabled.
                        </p>
                    </div>
                </div>
            </div>

            <button type="submit" class="w-full bg-gradient-to-r from-amber-600 to-orange-600 py-4 rounded-2xl font-bold text-sm shadow-xl shadow-amber-900/10 hover:opacity-90 active:scale-[0.98] transition-all">
                Generate & Secure Voucher Code
            </button>
        </form>
    </div>
</div>
@endsection
