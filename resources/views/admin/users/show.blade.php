@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    <!-- Breadcrumbs & Actions -->
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-slate-500">
            <a href="/admin/users" class="hover:text-purple-400">Users</a>
            <i data-lucide="chevron-right" class="w-3 h-3"></i>
            <span class="text-slate-200">User Profile #1284</span>
        </div>
        <div class="flex items-center gap-3">
             <button class="bg-red-500/10 text-red-500 border border-red-500/20 px-4 py-2 rounded-xl text-xs font-bold hover:bg-red-500 hover:text-white transition-all">Block User</button>
             <button class="btn-gradient px-6 py-2 rounded-xl text-xs font-bold shadow-lg shadow-purple-600/10">Reset Password</button>
        </div>
    </div>

    <!-- Profile Header -->
    <div class="glass p-8 rounded-[2rem] flex flex-col md:flex-row items-center gap-8 relative overflow-hidden">
        <div class="absolute -right-20 -top-20 w-64 h-64 bg-purple-600/10 rounded-full blur-3xl"></div>
        <div class="w-32 h-32 rounded-3xl bg-gradient-to-br from-slate-800 to-slate-900 border-2 border-[#1f1f1f] flex items-center justify-center text-4xl font-black text-slate-200 shadow-2xl">RK</div>
        <div class="flex-1 text-center md:text-left">
            <h1 class="text-3xl font-black text-white">Rahul Kumar</h1>
            <p class="text-slate-400 font-medium">rahul@example.com • +91 98765 43210</p>
            <div class="flex flex-wrap items-center justify-center md:justify-start gap-4 mt-4">
                <span class="badge-active text-[10px] px-3 py-1 rounded-full uppercase font-black">Active Member</span>
                <span class="bg-purple-600/10 text-purple-400 border border-purple-600/20 text-[10px] px-3 py-1 rounded-full uppercase font-black italic">Ref: NEXA8821</span>
                <span class="text-xs text-slate-500 font-bold uppercase tracking-tighter">Joined 12 Mar 2026</span>
            </div>
        </div>
        <div class="grid grid-cols-2 gap-4 w-full md:w-auto">
            <div class="glass p-4 rounded-2xl text-center border-[#1f1f1f]">
                <p class="text-[10px] text-slate-500 font-bold uppercase">Balance</p>
                <p class="text-xl font-black text-green-400">₹1,240</p>
            </div>
            <div class="glass p-4 rounded-2xl text-center border-[#1f1f1f]">
                <p class="text-[10px] text-slate-500 font-bold uppercase">Network</p>
                <p class="text-xl font-black text-blue-400">128</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Network Stats -->
        <div class="lg:col-span-2 space-y-8">
            <div class="glass rounded-3xl overflow-hidden">
                <div class="p-6 border-b border-[#1f1f1f]">
                    <h3 class="font-bold flex items-center gap-2 tracking-tight">
                        <i data-lucide="bar-chart-3" class="w-4 h-4 text-purple-400"></i>
                         Business Volume Analytics
                    </h3>
                </div>
                <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-slate-500 uppercase">Direct Business</span>
                            <span class="text-lg font-black text-slate-200">₹14,500</span>
                        </div>
                        <div class="w-full bg-slate-800 rounded-full h-1.5">
                            <div class="bg-blue-500 h-1.5 rounded-full" style="width: 65%"></div>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-slate-500 uppercase">Team Business</span>
                            <span class="text-lg font-black text-slate-200">₹1,42,000</span>
                        </div>
                        <div class="w-full bg-slate-800 rounded-full h-1.5">
                            <div class="bg-purple-600 h-1.5 rounded-full" style="width: 82%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity Table -->
            <div class="glass rounded-3xl overflow-hidden">
                <div class="p-6 border-b border-[#1f1f1f]">
                    <h3 class="font-bold tracking-tight">Sub-Network Activity</h3>
                </div>
                <table class="w-full text-left text-sm">
                     <thead class="bg-[#0c0c0c] text-slate-500 uppercase text-[10px] font-bold">
                        <tr>
                            <th class="px-6 py-4">Direct Member</th>
                            <th class="px-6 py-4">Investment</th>
                            <th class="px-6 py-4">Earnings to Upline</th>
                            <th class="px-6 py-4">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#1f1f1f]">
                        <tr>
                            <td class="px-6 py-4 font-medium">Amit Singh</td>
                            <td class="px-6 py-4 text-slate-400">₹1,000 (Pro)</td>
                            <td class="px-6 py-4 text-green-400 font-bold">₹200 (L1)</td>
                            <td class="px-6 py-4">
                                <span class="badge-active text-[10px] px-2 py-0.5 rounded-full uppercase font-bold">Active</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Sidebar Details -->
        <div class="space-y-6">
            <div class="glass p-6 rounded-3xl space-y-6">
                <h3 class="font-bold border-b border-[#1f1f1f] pb-4">Upline Information</h3>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl glass border border-[#1f1f1f] flex items-center justify-center font-bold text-slate-500">ROOT</div>
                    <div>
                        <p class="text-sm font-bold">System Admin</p>
                        <p class="text-[10px] text-slate-500 font-bold uppercase tracking-widest">Master Node</p>
                    </div>
                </div>
            </div>

            <div class="glass p-6 rounded-3xl space-y-6">
                <h3 class="font-bold border-b border-[#1f1f1f] pb-4">Security & Logs</h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between text-xs">
                        <span class="text-slate-500">Last Login IP</span>
                        <span class="font-mono text-slate-300">192.168.1.1</span>
                    </div>
                    <div class="flex items-center justify-between text-xs">
                        <span class="text-slate-500">Devices</span>
                        <span class="text-slate-300">Windows/Chrome</span>
                    </div>
                    <div class="flex items-center justify-between text-xs">
                        <span class="text-slate-500">KYC Status</span>
                        <span class="text-green-500 font-bold uppercase">Verified</span>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
