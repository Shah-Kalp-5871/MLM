@extends('layouts.admin')

@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:32px">
  <div>
    <h2 style="font-size:1.8rem;color:var(--navy);font-weight:800;margin-bottom:8px">
      <i class="fa-solid fa-chart-line" style="color:var(--green);margin-right:8px"></i> All Investments
    </h2>
    <p style="color:var(--text-muted)">Manage and view all users investments.</p>
  </div>
</div>

<div class="card">
  <div class="table-responsive">
    <table>
      <thead>
        <tr>
          <th>User</th>
          <th>Package</th>
          <th>Amount</th>
          <th>Status</th>
          <th>Date</th>
        </tr>
      </thead>
      <tbody>
        @forelse($investments as $inv)
        <tr>
          <td>
            <div class="font-bold text-navy">{{ $inv->user->name ?? 'Deleted User' }}</div>
            <div class="text-xs text-gray-500">{{ $inv->user->email ?? '' }}</div>
          </td>
          <td>{{ $inv->package->name ?? 'N/A' }}</td>
          <td class="font-mono text-emerald-600 font-bold">₹{{ number_format($inv->amount, 2) }}</td>
          <td>
            @if($inv->status == 'active')
              <span class="badge badge-success">Active</span>
            @else
              <span class="badge badge-secondary">{{ ucfirst($inv->status) }}</span>
            @endif
          </td>
          <td class="text-xs text-gray-500">{{ $inv->created_at->format('d M Y') }}</td>
        </tr>
        @empty
        <tr>
          <td colspan="5" class="text-center py-4 text-gray-500 italic">No investments found.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
  @if($investments->hasPages())
  <div class="card-footer">
    {{ $investments->links() }}
  </div>
  @endif
</div>
@endsection
