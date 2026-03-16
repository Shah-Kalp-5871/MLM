@extends('layouts.app')
@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:32px">
  <div>
    <h2 style="font-size:1.8rem;color:var(--navy);font-weight:800;margin-bottom:8px">
      <i class="fa-solid fa-users" style="color:var(--green);margin-right:8px"></i> Create User
    </h2>
    <p style="color:var(--text-muted)">Fill the form below to submit data.</p>
  </div>
  <a href="/admin/users" class="btn btn-ghost"><i class="fa-solid fa-arrow-left"></i> Back to List</a>
</div>
<div class="card" style="max-width:800px">
  <form>
    <div class='form-group'><label>Full Name</label><input type='text' class='form-control' placeholder='Enter Full Name'></div><div class='form-group'><label>Email</label><input type='email' class='form-control' placeholder='Enter Email'></div><div class='form-group'><label>Password</label><input type='password' class='form-control' placeholder='Enter Password'></div><div class='form-group'><label>Sponsor Referral Code</label><input type='text' class='form-control' placeholder='Enter Sponsor Referral Code'></div>
    <div style="margin-top:32px">
      <button type="submit" class="btn btn-primary">Submit Form</button>
    </div>
  </form>
</div>
@endsection