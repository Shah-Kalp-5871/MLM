@extends('layouts.user')
@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:32px">
  <div>
    <h2 style="font-size:1.8rem;color:var(--navy);font-weight:800;margin-bottom:8px">
      <i class="fa-solid fa-layer-group" style="color:var(--green);margin-right:8px"></i> Level Income
    </h2>
    <p style="color:var(--text-muted)">Manage and view all records.</p>
  </div>
  
</div>
<div class="card">
  <div class="table-responsive">
    <table>
      <thead><tr><th>From User</th><th>Level</th><th>ROI Reference</th><th>Commission</th><th>Date</th></tr></thead>
      <tbody>
        @forelse($commissions as $c)
        <tr>
          <td>{{ $c->fromUser->name ?? 'System' }}</td>
          <td>Level {{ $c->level }}</td>
          <td>{{ $c->roiIncome->week_number ?? 'N/A' }}</td>
          <td>{{ $settings['platform_currency_symbol'] ?? '$' }}{{ number_format($c->amount, 2) }}</td>
          <td>{{ $c->created_at ? \Carbon\Carbon::parse($c->created_at)->format('M d, Y') : 'N/A' }}</td>
        </tr>
        @empty
        <tr>
          <td colspan="5" style="text-align:center;color:var(--text-muted)">No records found.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
