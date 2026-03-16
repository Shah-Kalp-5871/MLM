@extends('layouts.app')
@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:32px">
  <div>
    <h2 style="font-size:1.8rem;color:var(--navy);font-weight:800;margin-bottom:8px">
      <i class="fa-solid fa-building-columns" style="color:var(--green);margin-right:8px"></i> Process Withdrawals
    </h2>
    <p style="color:var(--text-muted)">Manage and view all records.</p>
  </div>
  
</div>
<div class="card">
  <div class="table-responsive">
    <table>
      <thead><tr><th>ID</th><th>User</th><th>Amount</th><th>Method</th><th>Status</th><th>Date</th><th>Action</th></tr></thead>
      <tbody><tr><td>#WD-42</td><td>John Doe</td><td>$300</td><td>USDT</td><td><span class='badge badge-navy'>Pending</span></td><td>Today</td><td><button class='btn btn-sm btn-primary'>Approve</button></td></tr><tr><td>#WD-41</td><td>Mark Johnson</td><td>$1200</td><td>Bank</td><td><span class='badge badge-green'>Paid</span></td><td>Yesterday</td><td><button class='btn btn-sm btn-ghost'>View</button></td></tr></tbody>
    </table>
  </div>
</div>
@endsection