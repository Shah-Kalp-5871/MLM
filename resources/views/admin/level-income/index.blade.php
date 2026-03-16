@extends('layouts.app')
@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:32px">
  <div>
    <h2 style="font-size:1.8rem;color:var(--navy);font-weight:800;margin-bottom:8px">
      <i class="fa-solid fa-layer-group" style="color:var(--green);margin-right:8px"></i> Level Commissions
    </h2>
    <p style="color:var(--text-muted)">Manage and view all records.</p>
  </div>
  
</div>
<div class="card">
  <div class="table-responsive">
    <table>
      <thead><tr><th>Receiver</th><th>From User</th><th>Level</th><th>Amount</th><th>Date</th></tr></thead>
      <tbody><tr><td>John Doe</td><td>Alice Smith</td><td>Level 1</td><td>$2.50</td><td>Oct 14, 2026</td></tr><tr><td>John Doe</td><td>Bob Miller</td><td>Level 2</td><td>$1.25</td><td>Oct 14, 2026</td></tr></tbody>
    </table>
  </div>
</div>
@endsection