@extends('layouts.app')
@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:32px">
  <div>
    <h2 style="font-size:1.8rem;color:var(--navy);font-weight:800;margin-bottom:8px">
      <i class="fa-solid fa-award" style="color:var(--green);margin-right:8px"></i> Club Qualifications
    </h2>
    <p style="color:var(--text-muted)">Manage and view all records.</p>
  </div>
  
</div>
<div class="card">
  <div class="table-responsive">
    <table>
      <thead><tr><th>User</th><th>Direct Business</th><th>Team Business</th><th>Club Level</th><th>Action</th></tr></thead>
      <tbody><tr><td>John Doe</td><td>$18,000</td><td>$60,000</td><td>Platinum Tier</td><td><button class='btn btn-sm btn-primary'>Approve Reward</button></td></tr><tr><td>Alice Smith</td><td>$6,000</td><td>$12,000</td><td>Gold Tier</td><td><span class='badge badge-green'>Rewarded</span></td></tr></tbody>
    </table>
  </div>
</div>
@endsection