@extends('layouts.app')
@section('content')
<div style="margin-bottom:32px">
  <h2 style="font-size:1.8rem;color:var(--navy);font-weight:800;margin-bottom:8px">System Overview</h2>
  <p style="color:var(--text-muted)">Monitor platform statistics and recent activities.</p>
</div>

<div class="grid-4" style="margin-bottom:32px">
  <div class="card stat-card"><div class="stat-icon"><i class="fa-solid fa-users"></i></div><div class="stat-info"><h4>Total Users</h4><div class="val">145K+</div></div></div>
  <div class="card stat-card"><div class="stat-icon"><i class="fa-solid fa-user-check"></i></div><div class="stat-info"><h4>Active Users</h4><div class="val">89K</div></div></div>
  <div class="card stat-card"><div class="stat-icon"><i class="fa-solid fa-money-bill-transfer"></i></div><div class="stat-info"><h4>Total Deposits</h4><div class="val">$5.2M</div></div></div>
  <div class="card stat-card"><div class="stat-icon"><i class="fa-solid fa-building-columns"></i></div><div class="stat-info"><h4>Total Withdrawals</h4><div class="val">$1.8M</div></div></div>
</div>

<div class="grid-2">
  <div class="card">
    <div class="card-header"><div class="card-title">Recent Deposits</div><a href="/admin/deposits" class="btn btn-ghost btn-sm">View All</a></div>
    <div class="table-responsive">
      <table>
        <tr><th>User</th><th>Amount</th><th>Status</th></tr>
        <tr><td>John Doe</td><td>$1,000</td><td><span class="badge badge-navy">Pending</span></td></tr>
        <tr><td>Alice Smith</td><td>$500</td><td><span class="badge badge-green">Approved</span></td></tr>
        <tr><td>Mark Johnson</td><td>$2,500</td><td><span class="badge badge-green">Approved</span></td></tr>
      </table>
    </div>
  </div>
  <div class="card">
    <div class="card-header"><div class="card-title">Recent Withdrawals</div><a href="/admin/withdrawals" class="btn btn-ghost btn-sm">View All</a></div>
    <div class="table-responsive">
      <table>
        <tr><th>User</th><th>Amount</th><th>Status</th></tr>
        <tr><td>Sarah Williams</td><td>$300</td><td><span class="badge badge-navy">Pending</span></td></tr>
        <tr><td>Mike Brown</td><td>$1,200</td><td><span class="badge badge-green">Paid</span></td></tr>
        <tr><td>John Doe</td><td>$500</td><td><span class="badge badge-red">Rejected</span></td></tr>
      </table>
    </div>
  </div>
</div>
@endsection