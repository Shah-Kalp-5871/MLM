@extends('layouts.app')
@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:32px">
  <div>
    <h2 style="font-size:1.8rem;color:var(--navy);font-weight:800;margin-bottom:8px">
      <i class="fa-solid fa-users" style="color:var(--green);margin-right:8px"></i> Manage Users
    </h2>
    <p style="color:var(--text-muted)">Manage and view all records.</p>
  </div>
  <a href='/admin/users/create' class='btn btn-primary'><i class='fa-solid fa-plus'></i> Add New</a>
</div>
<div class="card">
  <div class="table-responsive">
    <table>
      <thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Status</th><th>Join Date</th><th>Actions</th></tr></thead>
      <tbody><tr><td>1</td><td>John Doe</td><td>john@example.com</td><td><span class='badge badge-green'>Active</span></td><td>Jan 01, 2026</td><td><a href='/admin/users/edit' class='btn btn-ghost btn-sm'>Edit</a></td></tr><tr><td>2</td><td>Alice Smith</td><td>alice@example.com</td><td><span class='badge badge-green'>Active</span></td><td>Mar 15, 2026</td><td><a href='/admin/users/edit' class='btn btn-ghost btn-sm'>Edit</a></td></tr></tbody>
    </table>
  </div>
</div>
@endsection