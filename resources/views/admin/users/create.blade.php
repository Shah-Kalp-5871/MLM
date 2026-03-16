@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.users.index') }}" class="w-10 h-10 rounded-xl glass border border-[#1f1f1f] flex items-center justify-center text-slate-400 hover:text-white transition-all">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
        </a>
        <div>
            <h1 class="text-2xl font-bold tracking-tight">Onboard New Member</h1>
            <p class="text-slate-400 text-sm">Manually register a user into the MLM ecosystem.</p>
        </div>
    </div>

    <div class="glass p-8 rounded-[2.5rem] shadow-2xl relative overflow-hidden">
        <div class="absolute -right-20 -bottom-20 w-64 h-64 bg-blue-600/5 rounded-full blur-3xl"></div>
        
        <form class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Personal Info -->
            <div class="space-y-6">
                <h3 class="text-xs font-bold text-slate-500 uppercase tracking-widest border-b border-[#1f1f1f] pb-3">Personal Details</h3>
                
                <div class="space-y-2">
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1">Full Name</label>
                    <input type="text" placeholder="John Doe" class="w-full bg-[#0c0c0c] border border-[#1f1f1f] rounded-2xl px-5 py-3.5 text-sm focus:border-purple-600 outline-none transition-all">
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1">Email Address</label>
                    <input type="email" placeholder="john@example.com" class="w-full bg-[#0c0c0c] border border-[#1f1f1f] rounded-2xl px-5 py-3.5 text-sm focus:border-purple-600 outline-none transition-all">
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1">Phone Number</label>
                    <input type="text" placeholder="+91 98765 43210" class="w-full bg-[#0c0c0c] border border-[#1f1f1f] rounded-2xl px-5 py-3.5 text-sm focus:border-purple-600 outline-none transition-all">
                </div>
            </div>

            <!-- Network Info -->
            <div class="space-y-6">
                <h3 class="text-xs font-bold text-slate-500 uppercase tracking-widest border-b border-[#1f1f1f] pb-3">Network Placement</h3>
                
                <div class="space-y-2">
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1">Upline / Referrer ID</label>
                    <div class="relative">
                        <input type="text" placeholder="NEXA2938" class="w-full bg-[#0c0c0c] border border-[#1f1f1f] rounded-2xl px-5 py-3.5 text-sm focus:border-purple-600 outline-none transition-all">
                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-[10px] font-bold text-green-500 uppercase">Valid</span>
                    </div>
                    <p class="text-[10px] text-slate-500 ml-1 italic">Leave empty for direct company registration (Root node).</p>
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1">Temporary Password</label>
                    <input type="password" placeholder="••••••••" class="w-full bg-[#0c0c0c] border border-[#1f1f1f] rounded-2xl px-5 py-3.5 text-sm focus:border-purple-600 outline-none transition-all">
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1">Account Status</label>
                    <select class="w-full bg-[#0c0c0c] border border-[#1f1f1f] rounded-2xl px-5 py-3.5 text-sm focus:border-purple-600 outline-none transition-all appearance-none">
                        <option>Active</option>
                        <option>Pending Verification</option>
                        <option>Blocked/Disabled</option>
                    </select>
                </div>
            </div>

            <div class="md:col-span-2 pt-6 border-t border-[#1f1f1f] flex items-center justify-end gap-4">
                <button type="button" onclick="location.href='/admin/users'" class="text-slate-400 font-bold text-xs uppercase tracking-widest px-6 py-3 hover:text-white transition-all">Cancel</button>
                <button type="submit" class="btn-gradient px-10 py-4 rounded-2xl font-bold text-sm shadow-xl shadow-purple-600/10">Register Member</button>
            </div>
        </form>
    </div>
</div>
@endsection
