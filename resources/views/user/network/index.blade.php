@extends('layouts.user')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold text-white tracking-tight">My Network</h1>
    <p class="text-xs text-gray-500 font-medium uppercase tracking-widest mt-1">View your downline team</p>
</div>

<div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
    <div class="glass-panel p-6 rounded-2xl">
        <i data-lucide="users" class="w-6 h-6 text-purple-400 mb-3"></i>
        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Direct Referrals</p>
        <h3 class="text-xl font-black text-white">4</h3>
    </div>
    <div class="glass-panel p-6 rounded-2xl">
        <i data-lucide="network" class="w-6 h-6 text-blue-400 mb-3"></i>
        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Total Team Members</p>
        <h3 class="text-xl font-black text-white">24</h3>
    </div>
    <div class="glass-panel p-6 rounded-2xl">
        <i data-lucide="dollar-sign" class="w-6 h-6 text-emerald-400 mb-3"></i>
        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Team Investment Volume</p>
        <h3 class="text-xl font-black text-white">₹45,000.00</h3>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
    <!-- Direct vs Team Explanation -->
    <div class="glass-panel rounded-2xl p-6 border border-white/10 flex flex-col justify-center">
        <h2 class="text-sm font-bold text-white uppercase tracking-wider mb-4">Understanding Your Network</h2>
        
        <div class="mb-6">
            <h3 class="text-xs font-bold text-purple-400 uppercase tracking-widest mb-1">What is Direct Business?</h3>
            <p class="text-xs text-gray-400 mb-2">Total deposits made by users you directly referred.</p>
            <div class="bg-black/30 p-3 rounded-xl border border-white/5 font-mono text-[10px] text-gray-300">
                You referred:<br>
                A → $2000<br>
                B → $1500<br>
                C → $1500<br>
                <div class="mt-1 text-purple-400 font-bold">Direct Business = $5000</div>
            </div>
        </div>

        <div>
            <h3 class="text-xs font-bold text-blue-400 uppercase tracking-widest mb-1">What is Team Business?</h3>
            <p class="text-xs text-gray-400 mb-2">Total deposits from your entire referral network (all levels).</p>
            <div class="bg-black/30 p-3 rounded-xl border border-white/5 font-mono text-[10px] text-gray-300">
                You<br>
                ├ A ($500)<br>
                │ └ C ($500)<br>
                └ B ($500)<br>
                <div class="mt-1 text-blue-400 font-bold">Team Business = $1500 (A+B+C)</div>
            </div>
        </div>
    </div>

    <!-- Tree Structure -->
    <div class="glass-panel rounded-2xl p-6 border border-white/10">
        <h2 class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-4">Live Network Tree</h2>
        <div class="bg-[#0f111a] p-6 rounded-xl border border-white/5 font-mono text-xs leading-8 text-gray-300 overflow-x-auto h-[320px] overflow-y-auto">
            <div class="text-purple-400 font-bold mb-2">You (Kalp Shah)</div>
            <div class="ml-4 border-l border-white/10 pl-4 py-1">
                <div class="text-white relative"><span class="absolute -left-5 top-4 w-4 border-t border-white/10"></span> ├ Rahul <span class="text-emerald-400 text-[10px]">($500)</span> <span class="text-gray-500 text-[10px]">Lv1</span></div>
                <div class="ml-4 border-l border-white/10 pl-4 py-1">
                    <div class="text-gray-400 relative"><span class="absolute -left-5 top-4 w-4 border-t border-white/10"></span> └ Amit <span class="text-emerald-400 text-[10px]">($500)</span> <span class="text-gray-500 text-[10px]">Lv2</span></div>
                </div>
                <div class="text-white relative"><span class="absolute -left-5 top-4 w-4 border-t border-white/10"></span> └ Neha <span class="text-emerald-400 text-[10px]">($2000)</span> <span class="text-gray-500 text-[10px]">Lv1</span></div>
                <div class="ml-4 border-l border-white/10 pl-4 py-1">
                    <div class="text-gray-400 relative"><span class="absolute -left-5 top-4 w-4 border-t border-white/10"></span> └ Vikram <span class="text-emerald-400 text-[10px]">($500)</span> <span class="text-gray-500 text-[10px]">Lv2</span></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="glass-panel rounded-2xl overflow-hidden">
    <div class="p-6 border-b border-white/5 bg-white/[0.02]">
        <h2 class="text-sm font-bold text-white uppercase tracking-wider">Team Matrix List</h2>
    </div>
    <div class="table-wrapper p-4">
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Level</th>
                    <th>Join Date</th>
                    <th>Investment</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="font-bold text-white flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-purple-500/20 text-purple-400 flex items-center justify-center text-xs">R</div> Rahul
                    </td>
                    <td><span class="px-2 py-1 bg-white/10 rounded text-[10px] font-bold uppercase">Level 1</span></td>
                    <td class="text-xs">01 Mar 2026</td>
                    <td class="font-mono text-emerald-400">₹5,000</td>
                </tr>
                <tr>
                    <td class="font-bold text-white flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-blue-500/20 text-blue-400 flex items-center justify-center text-xs">N</div> Neha
                    </td>
                    <td><span class="px-2 py-1 bg-white/10 rounded text-[10px] font-bold uppercase">Level 1</span></td>
                    <td class="text-xs">05 Mar 2026</td>
                    <td class="font-mono text-emerald-400">₹2,000</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="p-4 border-t border-white/5 flex justify-center bg-white/[0.01]">
        <div class="pagination">
            <a href="#">&laquo; Prev</a>
            <a href="#" class="active">1</a>
            <a href="#">2</a>
            <a href="#">Next &raquo;</a>
        </div>
    </div>
</div>

@endsection