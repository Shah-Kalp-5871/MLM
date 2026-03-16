@extends('layouts.admin')

@section('content')
    <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-10">
        @csrf
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-8">
            
            <!-- General Config -->
            <div class="glass p-8 rounded-3xl space-y-6">
                <h3 class="font-bold flex items-center gap-2 border-b border-[#1f1f1f] pb-4">
                    <i data-lucide="globe" class="w-4 h-4 text-blue-500"></i>
                    Platform Identity
                </h3>
                <div class="space-y-4">
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">Platform Name</label>
                        <input type="text" name="platform_name" value="NexaNet MLM" class="w-full bg-[#121212] border border-[#1f1f1f] rounded-xl px-4 py-2.5 text-sm focus:border-purple-600 outline-none">
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">Support Email</label>
                        <input type="email" name="support_email" value="support@nexanet.com" class="w-full bg-[#121212] border border-[#1f1f1f] rounded-xl px-4 py-2.5 text-sm focus:border-purple-600 outline-none">
                    </div>
                </div>
            </div>

            <!-- Financial Config -->
            <div class="glass p-8 rounded-3xl space-y-6">
                <h3 class="font-bold flex items-center gap-2 border-b border-[#1f1f1f] pb-4">
                    <i data-lucide="calculator" class="w-4 h-4 text-green-500"></i>
                    Financial Limits & Fees
                </h3>
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">Min Withdrawal</label>
                        <input type="text" name="min_withdrawal" value="200" class="w-full bg-[#121212] border border-[#1f1f1f] rounded-xl px-4 py-2.5 text-sm focus:border-purple-600 outline-none">
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">Withdrawal Fee (%)</label>
                        <input type="text" name="withdrawal_fee" value="5" class="w-full bg-[#121212] border border-[#1f1f1f] rounded-xl px-4 py-2.5 text-sm focus:border-purple-600 outline-none">
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">Deposit Minimum</label>
                        <input type="text" name="min_deposit" value="500" class="w-full bg-[#121212] border border-[#1f1f1f] rounded-xl px-4 py-2.5 text-sm focus:border-purple-600 outline-none">
                    </div>
                     <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">ROI Distribution Day</label>
                        <select name="roi_day" class="w-full bg-[#121212] border border-[#1f1f1f] rounded-xl px-4 py-2.5 text-sm focus:border-purple-600 outline-none appearance-none">
                            <option value="monday">Monday</option>
                            <option value="sunday">Sunday</option>
                        </select>
                    </div>
                </div>
            </div>

        </div>

        <div class="flex items-center justify-end">
            <button type="submit" class="btn-gradient px-12 py-3 rounded-2xl text-sm font-bold shadow-xl shadow-purple-600/20">
                Save System Configurations
            </button>
        </div>
    </form>
@endsection
