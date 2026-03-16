@extends('layouts.app')
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
      <tbody><tr><td>Week 14</td><td>Starter Pack ($1,000)</td><td>2.5%</td><td>$25.00</td><td>Oct 14, 2026</td></tr><tr><td>Week 13</td><td>Starter Pack ($1,000)</td><td>2.5%</td><td>$25.00</td><td>Oct 07, 2026</td></tr></tbody>
    </table>
  </div>
</div>
@endsection