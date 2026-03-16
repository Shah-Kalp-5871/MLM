@extends('layouts.admin')

@section('content')
<div class="space-y-10">
    <div>
        <h1 class="text-2xl font-bold tracking-tight">Global System Settings</h1>
        <p class="text-slate-400 text-sm">Fine-tune platform parameters, ROI timings, and financial limits.</p>
    </div>

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
                    <input type="text" value="NexaNet MLM" class="w-full bg-[#121212] border border-[#1f1f1f] rounded-xl px-4 py-2.5 text-sm focus:border-purple-600 outline-none">
                </div>
                <div class="space-y-2">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">Support Email</label>
                    <input type="email" value="support@nexanet.com" class="w-full bg-[#121212] border border-[#1f1f1f] rounded-xl px-4 py-2.5 text-sm focus:border-purple-600 outline-none">
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
                    <input type="text" value="₹200" class="w-full bg-[#121212] border border-[#1f1f1f] rounded-xl px-4 py-2.5 text-sm focus:border-purple-600 outline-none">
                </div>
                <div class="space-y-2">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">Withdrawal Fee (%)</label>
                    <input type="text" value="5" class="w-full bg-[#121212] border border-[#1f1f1f] rounded-xl px-4 py-2.5 text-sm focus:border-purple-600 outline-none">
                </div>
                <div class="space-y-2">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">Deposit Minimum</label>
                    <input type="text" value="₹500" class="w-full bg-[#121212] border border-[#1f1f1f] rounded-xl px-4 py-2.5 text-sm focus:border-purple-600 outline-none">
                </div>
                 <div class="space-y-2">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">ROI Distribution Day</label>
                    <select class="w-full bg-[#121212] border border-[#1f1f1f] rounded-xl px-4 py-2.5 text-sm focus:border-purple-600 outline-none appearance-none">
                        <option>Monday</option>
                        <option>Sunday</option>
                    </select>
                </div>
            </div>
        </div>

    </div>

    <div class="flex items-center justify-end">
        <button class="btn-gradient px-12 py-3 rounded-2xl text-sm font-bold shadow-xl shadow-purple-600/20">
            Save System Configurations
        </button>
    </div>
</div>
@endsection
