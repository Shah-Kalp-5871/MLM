@extends('layouts.app')
@section('content')
<h2 style="font-size:1.8rem;color:var(--navy);font-weight:800;margin-bottom:8px">
  <i class="fa-solid fa-file-invoice" style="color:var(--green);margin-right:8px"></i> System Reports
</h2>
<p style="color:var(--text-muted);margin-bottom:32px">In-depth statistical insights of the platform.</p>

<div class="grid-2">
  <div class="card">
    <div class="card-header"><div class="card-title">Top Referrers</div></div>
    <div class="table-responsive">
      <table>
        <tr><th>User</th><th>Total Invites</th></tr>
        <tr><td>Sarah Williams</td><td>84</td></tr>
        <tr><td>John Doe</td><td>42</td></tr>
        <tr><td>Mike Brown</td><td>38</td></tr>
      </table>
    </div>
  </div>
  <div class="card">
    <div class="card-header"><div class="card-title">Financial Summary</div></div>
    <div class="table-responsive">
      <table>
        <tr><th>Metric</th><th>Value</th></tr>
        <tr><td>Total Deposits (All Time)</td><td style="color:var(--green);font-weight:700">$5,240,000</td></tr>
        <tr><td>Total Withdrawals</td><td style="color:#dc3545;font-weight:700">$1,850,000</td></tr>
        <tr><td>Total ROI Distributed</td><td>$840,000</td></tr>
      </table>
    </div>
  </div>
</div>
@endsection