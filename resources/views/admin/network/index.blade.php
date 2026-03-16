@extends('layouts.app')
@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:32px">
  <div>
    <h2 style="font-size:1.8rem;color:var(--navy);font-weight:800;margin-bottom:8px">
      <i class="fa-solid fa-network-wired" style="color:var(--green);margin-right:8px"></i> Network Tree Browser
    </h2>
    <p style="color:var(--text-muted)">Manage and view all records.</p>
  </div>
  
</div>
<div class="card">
  <div class="table-responsive">
    <table>
      <thead><tr><th>User</th><th>Upline</th><th>Level</th><th>Team Size</th></tr></thead>
      <tbody><tr><td>John Doe</td><td>Root Node</td><td>Root</td><td>148</td></tr><tr><td>Alice Smith</td><td>John Doe</td><td>Level 1</td><td>24</td></tr><tr><td>Mark Johnson</td><td>John Doe</td><td>Level 1</td><td>12</td></tr></tbody>
    </table>
  </div>
</div>
@endsection