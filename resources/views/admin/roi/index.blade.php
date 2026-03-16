@extends('layouts.app')
@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:32px">
  <div>
    <h2 style="font-size:1.8rem;color:var(--navy);font-weight:800;margin-bottom:8px">
      <i class="fa-solid fa-chart-line" style="color:var(--green);margin-right:8px"></i> Distributed ROI
    </h2>
    <p style="color:var(--text-muted)">History of all ROI payouts across the network.</p>
  </div>
  <button class="btn btn-primary"><i class="fa-solid fa-bolt"></i> Run ROI Script Menually</button>
</div>
<div class="card">
  <div class="table-responsive">
    <table>
      <thead><tr><th>ID</th><th>User</th><th>Investment</th><th>ROI Amount</th><th>Week</th><th>Date</th></tr></thead>
      <tbody>
        <tr><td>1024</td><td>John Doe</td><td>$1,000</td><td>$25.00</td><td>Week 14</td><td>Oct 14, 2026</td></tr>
        <tr><td>1025</td><td>Alice Smith</td><td>$500</td><td>$12.50</td><td>Week 14</td><td>Oct 14, 2026</td></tr>
      </tbody>
    </table>
  </div>
</div>
@endsection