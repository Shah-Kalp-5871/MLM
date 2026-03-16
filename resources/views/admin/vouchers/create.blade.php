@extends('layouts.app')
@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:32px">
  <div>
    <h2 style="font-size:1.8rem;color:var(--navy);font-weight:800;margin-bottom:8px">
      <i class="fa-solid fa-ticket" style="color:var(--green);margin-right:8px"></i> Create Voucher
    </h2>
    <p style="color:var(--text-muted)">Fill the form below to submit data.</p>
  </div>
  <a href="/admin/vouchers" class="btn btn-ghost"><i class="fa-solid fa-arrow-left"></i> Back to List</a>
</div>
<div class="card" style="max-width:800px">
  <form>
    <div class='form-group'><label>Voucher Code (Auto-generated)</label><input type='text' class='form-control' placeholder='Enter Voucher Code (Auto-generated)'></div><div class='form-group'><label>Voucher Value ($)</label><input type='number' class='form-control' placeholder='Enter Voucher Value ($)'></div><div class='form-group'><label>Assign to User Email (Optional)</label><input type='email' class='form-control' placeholder='Enter Assign to User Email (Optional)'></div>
    <div style="margin-top:32px">
      <button type="submit" class="btn btn-primary">Submit Form</button>
    </div>
  </form>
</div>
@endsection