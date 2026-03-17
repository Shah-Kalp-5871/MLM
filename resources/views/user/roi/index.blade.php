@extends('layouts.user')
@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:32px">
  <div>
    <h2 style="font-size:1.8rem;color:var(--navy);font-weight:800;margin-bottom:8px">
      <i class="fa-solid fa-chart-line" style="color:var(--green);margin-right:8px"></i> ROI History
    </h2>
    <p style="color:var(--text-muted)">Manage and view all records.</p>
  </div>
  
</div>
<div class="card">
  <div class="table-responsive">
    <table>
      <thead><tr><th>Week</th><th>Investment</th><th>ROI %</th><th>ROI Amount</th><th>Date</th></tr></thead>
      <tbody>
        @forelse($roi_records as $roi)
        <tr>
          <td>Week {{ $roi->week_number }}</td>
          <td>Investment ({{ $settings['platform_currency_symbol'] ?? '$' }}{{ number_format($roi->investment_amount ?? 0, 2) }})</td>
          <td>{{ $roi->roi_percentage }}%</td>
          <td>{{ $settings['platform_currency_symbol'] ?? '$' }}{{ number_format($roi->roi_amount, 2) }}</td>
          <td>{{ $roi->distributed_at ? \Carbon\Carbon::parse($roi->distributed_at)->format('M d, Y') : 'N/A' }}</td>
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
