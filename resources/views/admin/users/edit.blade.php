@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">
    <div class="flex items-center gap-4">
        <a href="/admin/users" class="w-10 h-10 rounded-xl glass border border-[#1f1f1f] flex items-center justify-center text-slate-400 hover:text-white transition-all">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
        </a>
        <div>
            <h1 class="text-2xl font-bold tracking-tight">Modify Member Profile</h1>
            <p class="text-slate-400 text-sm">Update credentials and status for User #1284.</p>
        </div>
    </div>

    <div class="glass p-8 rounded-[2.5rem] shadow-2xl relative overflow-hidden">
        <div class="absolute -left-20 -top-20 w-64 h-64 bg-purple-600/5 rounded-full blur-3xl"></div>
        
        <form class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Basic Details -->
            <div class="space-y-6">
                <h3 class="text-xs font-bold text-slate-500 uppercase tracking-widest border-b border-[#1f1f1f] pb-3">Basic Information</h3>
                
                <div class="space-y-2">
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1">Full Name</label>
                    <input type="text" value="Rahul Kumar" class="w-full bg-[#0c0c0c] border border-[#1f1f1f] rounded-2xl px-5 py-3.5 text-sm focus:border-purple-600 outline-none transition-all">
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1">Email (Primary)</label>
                    <input type="email" value="rahul@example.com" class="w-full bg-[#0c0c0c] border border-[#1f1f1f] rounded-2xl px-5 py-3.5 text-sm focus:border-purple-600 outline-none transition-all">
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1">Phone Number</label>
                    <input type="text" value="+91 98765 43210" class="w-full bg-[#0c0c0c] border border-[#1f1f1f] rounded-2xl px-5 py-3.5 text-sm focus:border-purple-600 outline-none transition-all">
                </div>
            </div>

            <!-- Overrides -->
            <div class="space-y-6">
                <h3 class="text-xs font-bold text-slate-500 uppercase tracking-widest border-b border-[#1f1f1f] pb-3">Administrative Overrides</h3>
                
                <div class="space-y-2">
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1">Referral Code Override</label>
                    <input type="text" value="NEXA8821" class="w-full bg-[#0c0c0c] border border-[#1f1f1f] rounded-2xl px-5 py-3.5 text-sm font-mono focus:border-purple-600 outline-none transition-all text-purple-400">
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1">Change Upline ID</label>
                    <input type="text" placeholder="ROOT" class="w-full bg-[#0c0c0c] border border-[#1f1f1f] rounded-2xl px-5 py-3.5 text-sm focus:border-purple-600 outline-none transition-all">
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1">Member Status</label>
                    <select class="w-full bg-[#0c0c0c] border border-[#1f1f1f] rounded-2xl px-5 py-3.5 text-sm focus:border-purple-600 outline-none transition-all appearance-none">
                        <option selected>Active Member</option>
                        <option>Suspended (Payment Issue)</option>
                        <option>Banned (TOS Violation)</option>
                    </select>
                </div>
            </div>

            <div class="md:col-span-2 pt-6 border-t border-[#1f1f1f] flex items-center justify-between">
                <button type="button" class="text-red-500 font-bold text-xs uppercase tracking-widest hover:underline px-2">Reset Account MFA</button>
                <div class="flex items-center gap-4">
                    <button type="button" onclick="location.href='/admin/users'" class="text-slate-400 font-bold text-xs uppercase tracking-widest px-6 py-3 hover:text-white transition-all">Cancel</button>
                    <button type="submit" class="btn-gradient px-10 py-4 rounded-2xl font-bold text-sm shadow-xl shadow-purple-600/10">Update Member</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection