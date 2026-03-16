@extends('layouts.app')
@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:32px">
  <div>
    <h2 style="font-size:1.8rem;color:var(--navy);font-weight:800;margin-bottom:8px">
      <i class="fa-solid fa-ticket" style="color:var(--green);margin-right:8px"></i> Manage Vouchers
    </h2>
    <p style="color:var(--text-muted)">Manage and view all records.</p>
  </div>
  <a href='/admin/vouchers/create' class='btn btn-primary'><i class='fa-solid fa-plus'></i> Add New</a>
</div>
<div class="card">
  <div class="table-responsive">
    <table>
      <thead><tr><th>Code</th><th>Value</th><th>Assigned To</th><th>Status</th></tr></thead>
      <tbody><tr><td>VCH-2938</td><td>$50</td><td>John Doe</td><td><span class='badge badge-navy'>Unused</span></td></tr><tr><td>VCH-1123</td><td>$100</td><td>Alice Smith</td><td><span class='badge badge-green'>Used</span></td></tr></tbody>
    </table>
  </div>
</div>
@endsection