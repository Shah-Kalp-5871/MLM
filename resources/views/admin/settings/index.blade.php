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
                        <input type="text" name="platform_name" value="{{ $settings['platform_name'] ?? 'NexaNet MLM' }}" class="w-full bg-[#121212] border border-[#1f1f1f] rounded-xl px-4 py-2.5 text-sm focus:border-purple-600 outline-none">
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">Support Email</label>
                        <input type="email" name="support_email" value="{{ $settings['support_email'] ?? 'support@nexanet.com' }}" class="w-full bg-[#121212] border border-[#1f1f1f] rounded-xl px-4 py-2.5 text-sm focus:border-purple-600 outline-none">
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
                        <input type="text" name="min_withdrawal" value="{{ $settings['min_withdrawal'] ?? '200' }}" class="w-full bg-[#121212] border border-[#1f1f1f] rounded-xl px-4 py-2.5 text-sm focus:border-purple-600 outline-none">
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">Weekly ROI (%)</label>
                        <input type="text" name="weekly_roi_percentage" value="{{ $settings['weekly_roi_percentage'] ?? '3' }}" class="w-full bg-[#121212] border border-[#1f1f1f] rounded-xl px-4 py-2.5 text-sm focus:border-purple-600 outline-none">
                    </div>
                    <div class="space-y-2 text-right">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-widest block opacity-0">spacer</label>
                        <span class="text-[10px] text-gray-400 italic">This % applies to all new investments.</span>
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">Deposit Minimum</label>
                        <input type="text" name="min_deposit" value="{{ $settings['min_deposit'] ?? '500' }}" class="w-full bg-[#121212] border border-[#1f1f1f] rounded-xl px-4 py-2.5 text-sm focus:border-purple-600 outline-none">
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
