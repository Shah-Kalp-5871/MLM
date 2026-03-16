@extends('layouts.auth')
@section('content')
<div class="auth-card">
  <div class="logo"><span class="logo-dot"></span>Nexa<span>Net</span></div>
  <p class="auth-subtitle">Admin Panel Secured Login</p>
  <form action="/admin/dashboard">
    <div class="form-group" style="text-align:left">
      <label>Email Address</label>
      <input type="email" class="form-control" placeholder="enter@email.com" value="user@example.com">
    </div>
    <div class="form-group" style="text-align:left">
      <label>Password</label>
      <input type="password" class="form-control" placeholder="••••••••" value="password">
    </div>
    <div style="display:flex;justify-content:space-between;margin-bottom:24px;font-size:0.85rem">
      <label style="display:flex;align-items:center;gap:6px"><input type="checkbox"> Remember me</label>
      <a href="#" style="color:var(--green);text-decoration:none;font-weight:500">Forgot Password?</a>
    </div>
    <button type="submit" class="btn btn-primary" style="width:100%">Sign In</button>
  </form>
  <p style="margin-top:24px;font-size:0.9rem;color:var(--text-muted)">Don't have an account? <a href="/auth/register" style="color:var(--green);text-decoration:none;font-weight:600">Register</a></p>
</div>
@endsection
