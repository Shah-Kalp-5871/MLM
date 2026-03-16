@extends('layouts.user')

@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:32px">
  <div>
    <h2 style="font-size:1.8rem;color:var(--navy);font-weight:800;margin-bottom:8px">
      <i class="fa-solid fa-money-bill-transfer" style="color:var(--green);margin-right:8px"></i> Deposit History
    </h2>
    <p style="color:var(--text-muted)">Manage and view all your deposit records.</p>
  </div>
</div>

<div class="card">
  <div class="table-responsive">
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Amount</th>
          <th>Method</th>
          <th>Status</th>
          <th>Date</th>
        </tr>
      </thead>
      <tbody>
        @forelse($deposits as $d)
        <tr>
          <td class="font-bold">#DP-{{ $d->id }}</td>
          <td class="font-mono text-emerald-600">$settings['platform_currency_symbol']{{ number_format($d->amount, 2) }}</td>
          <td>{{ ucfirst($d->method) }}</td>
          <td>
            @if($d->status == 'approved')
              <span class="badge badge-success">Approved</span>
            @elseif($d->status == 'pending')
              <span class="badge badge-warning">Pending</span>
            @else
              <span class="badge badge-danger">Rejected</span>
            @endif
          </td>
          <td class="text-xs text-gray-500">{{ $d->created_at->format('d M Y') }}</td>
        </tr>
        @empty
        <tr>
          <td colspan="5" class="text-center py-4 text-gray-500 italic">No deposits found.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
  @if($deposits->hasPages())
  <div class="card-footer">
    {{ $deposits->links() }}
  </div>
  @endif
</div>
@endsection

