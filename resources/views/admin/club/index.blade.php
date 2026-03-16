@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight">Club Milestone Tracking</h1>
            <p class="text-slate-400 text-sm">Monitor business volume targets and milestone achievements.</p>
        </div>
        <div class="flex items-center gap-3">
             <a href="{{ route('admin.club-milestones.index') }}" class="bg-purple-600/10 text-purple-400 border border-purple-600/20 px-4 py-2 rounded-xl text-sm font-bold hover:bg-purple-600/20 transition-all">Configure Milestones</a>
        </div>
    </div>

    <!-- Active Qualifications -->
    <div class="glass rounded-3xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-[#0c0c0c] text-slate-500 uppercase text-[10px] font-bold">
                    <tr>
                        <th class="px-6 py-4">User</th>
                        <th class="px-6 py-4">Direct Business</th>
                        <th class="px-6 py-4">Team Business</th>
                        <th class="px-6 py-4">Current Milestone</th>
                        <th class="px-6 py-4">Next Goal Progress</th>
                        <th class="px-6 py-4 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#1f1f1f]">
                    @forelse($users as $user)
                    <tr>
                        <td class="px-6 py-4 font-bold text-slate-200">{{ $user->name }}</td>
                        <td class="px-6 py-4 font-bold text-blue-400">₹{{ number_format($user->direct_business, 2) }}</td>
                        <td class="px-6 py-4 font-bold text-indigo-400">₹{{ number_format($user->total_business, 2) }}</td>
                        <td class="px-6 py-4 font-bold text-purple-400 italic">
                            {{ $user->clubQualification->milestone->name ?? 'None' }}
                        </td>
                        <td class="px-6 py-4">
                            @if($user->clubQualification)
                            @php
                                $nextTarget = $user->clubQualification->milestone->direct_business_target ?? 0;
                                $progress = $nextTarget > 0 ? min(100, round(($user->direct_business / $nextTarget) * 100)) : 100;
                            @endphp
                            <div class="space-y-1">
                                <div class="w-full bg-slate-800 rounded-full h-1.5">
                                    <div class="bg-purple-600 h-1.5 rounded-full" style="width: {{ $progress }}%"></div>
                                </div>
                                <span class="text-[9px] text-slate-500 font-bold uppercase tracking-widest">{{ $progress }}% ACCURACY</span>
                            </div>
                            @else
                            <span class="text-[9px] text-slate-600 uppercase font-bold tracking-widest">Qualification Pending</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <button class="text-purple-500 hover:text-purple-400 font-bold text-xs uppercase tracking-wider underline">Issue Voucher</button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-slate-500 font-bold">No active club qualifications found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-4">
        {{ $users->links() }}
    </div>
</div>
@endsection