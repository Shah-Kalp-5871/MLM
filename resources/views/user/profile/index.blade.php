@extends('layouts.user')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold text-white tracking-tight">Account Settings</h1>
    <p class="text-xs text-gray-500 font-medium uppercase tracking-widest mt-1">Manage your profile and security</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Personal Details -->
    <div class="glass-panel rounded-2xl p-8 border hover:border-purple-500/30 transition-colors">
        <h2 class="text-sm font-bold text-white uppercase tracking-wider mb-6 flex items-center gap-2"><i data-lucide="user" class="w-4 h-4 text-purple-400"></i> Personal Information</h2>
        
        <form class="flex flex-col gap-5">
            <div>
                <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Full Name</label>
                <input type="text" class="w-full bg-black/40 border border-white/10 rounded-xl px-4 py-3 text-white text-sm focus:border-purple-500 focus:outline-none transition-colors" value="Kalp Shah">
            </div>
            <div>
                <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Email Address</label>
                <input type="email" class="w-full bg-black/40 border border-white/10 rounded-xl px-4 py-3 text-white text-sm focus:border-purple-500 focus:outline-none transition-colors" value="kalp@example.com" disabled>
                <p class="text-[10px] text-gray-500 mt-1">Contact support to change email.</p>
            </div>
            <div>
                <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Phone Number</label>
                <input type="text" class="w-full bg-black/40 border border-white/10 rounded-xl px-4 py-3 text-white text-sm focus:border-purple-500 focus:outline-none transition-colors" value="+91 9876543210">
            </div>
            <div>
                <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Withdrawal Wallet Address / UPI</label>
                <input type="text" class="w-full bg-black/40 border border-white/10 rounded-xl px-4 py-3 text-purple-300 font-mono text-xs focus:border-purple-500 focus:outline-none transition-colors" value="kalp@upi">
            </div>
            <button type="button" class="mt-4 px-6 py-3 rounded-xl bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-500 hover:to-indigo-500 text-white text-xs font-bold uppercase tracking-wider transition-all shadow-lg shadow-purple-900/40 self-start">Update Profile</button>
        </form>
    </div>

    <!-- Security -->
    <div class="glass-panel rounded-2xl p-8 border hover:border-emerald-500/30 transition-colors self-start">
        <h2 class="text-sm font-bold text-white uppercase tracking-wider mb-6 flex items-center gap-2"><i data-lucide="shield" class="w-4 h-4 text-emerald-400"></i> Password & Security</h2>
        
        <form class="flex flex-col gap-5">
            <div>
                <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Current Password</label>
                <input type="password" class="w-full bg-black/40 border border-white/10 rounded-xl px-4 py-3 text-white text-sm focus:border-emerald-500 focus:outline-none transition-colors" placeholder="••••••••">
            </div>
            <div>
                <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">New Password</label>
                <input type="password" class="w-full bg-black/40 border border-white/10 rounded-xl px-4 py-3 text-white text-sm focus:border-emerald-500 focus:outline-none transition-colors" placeholder="••••••••">
            </div>
            <div>
                <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Confirm New Password</label>
                <input type="password" class="w-full bg-black/40 border border-white/10 rounded-xl px-4 py-3 text-white text-sm focus:border-emerald-500 focus:outline-none transition-colors" placeholder="••••••••">
            </div>
            <button type="button" class="mt-4 px-6 py-3 rounded-xl bg-white/10 hover:bg-white/20 border border-white/10 text-white text-xs font-bold uppercase tracking-wider transition-all self-start">Change Password</button>
        </form>
    </div>
</div>
@endsection