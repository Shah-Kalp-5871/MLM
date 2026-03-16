<?php
// Script to generate responsive static UI for NexaNet MLM

$baseDir = "C:/laravel-projects/mlm/resources/views/";

function makeDir($path) {
    if (!is_dir($path)) {
        mkdir($path, 0777, true);
    }
}

// 1. CSS & Layout Template
$css = <<<CSS
<style>
  :root {
    --green: #2FB67C;
    --green-light: #3ECF93;
    --green-dim: rgba(47,182,124,0.12);
    --navy: #0F2A44;
    --navy-mid: #163657;
    --bg: #F4F7FB;
    --card-bg: #ffffff;
    --text: #1A1A2E;
    --text-muted: #5E6E82;
    --border: rgba(15,42,68,0.08);
    --shadow: 0 4px 32px rgba(15,42,68,0.10);
    --shadow-hover: 0 12px 48px rgba(47,182,124,0.18);
  }
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
  body { font-family: 'DM Sans', sans-serif; background: var(--bg); color: var(--text); overflow-x: hidden; display: flex; }
  h1,h2,h3,h4,h5 { font-family: 'Syne', sans-serif; }

  /* SIDEBAR */
  .sidebar {
    width: 260px; background: var(--navy); color: rgba(255,255,255,0.7);
    height: 100vh; position: fixed; left: 0; top: 0; overflow-y: auto;
    transition: all 0.3s; z-index: 1000;
  }
  .sidebar-header {
    height: 70px; display: flex; align-items: center; padding: 0 24px;
    border-bottom: 1px solid rgba(255,255,255,0.05);
  }
  .logo { font-family: 'Syne', sans-serif; font-weight: 800; font-size: 1.45rem; color: #fff; display: flex; align-items: center; gap: 8px; text-decoration: none; }
  .logo span { color: var(--green); }
  .logo-dot { width: 9px; height: 9px; border-radius: 50%; background: var(--green); display: inline-block; margin-bottom: 2px; }
  
  .nav-menu { padding: 24px 16px; list-style: none; display: flex; flex-direction: column; gap: 8px; }
  .nav-menu li a {
    display: flex; align-items: center; gap: 14px; padding: 12px 16px; border-radius: 12px;
    color: rgba(255,255,255,0.6); text-decoration: none; font-size: 0.95rem; font-weight: 500; transition: all 0.2s;
  }
  .nav-menu li a:hover, .nav-menu li a.active { background: rgba(47,182,124,0.15); color: var(--green); }
  .nav-menu li a i { width: 20px; text-align: center; font-size: 1.1rem; }

  /* MAIN CONTENT */
  .main-wrapper { margin-left: 260px; width: calc(100% - 260px); min-height: 100vh; display: flex; flex-direction: column; transition: all 0.3s; }
  .topbar {
    height: 70px; background: rgba(244,247,251,0.85); backdrop-filter: blur(16px); border-bottom: 1px solid var(--border);
    display: flex; justify-content: space-between; align-items: center; padding: 0 40px; position: sticky; top: 0; z-index: 100;
  }
  .top-search input { background: var(--card-bg); border: 1px solid var(--border); padding: 10px 16px; border-radius: 8px; width: 260px; outline: none; }
  .top-profile { display: flex; align-items: center; gap: 16px; }
  .user-avatar { width: 40px; height: 40px; border-radius: 50%; background: var(--green-dim); color: var(--green); display: flex; align-items: center; justify-content: center; font-weight: 700; font-family: 'Syne'; }
  .mobile-toggle { display: none; cursor: pointer; font-size: 1.5rem; color: var(--navy); }

  .content-area { padding: 40px; flex: 1; }
  
  /* CARDS & GRIDS */
  .grid-2 { display: grid; grid-template-columns: repeat(2, 1fr); gap: 24px; }
  .grid-3 { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; }
  .grid-4 { display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px; }
  
  .card { background: var(--card-bg); border-radius: 16px; padding: 24px; box-shadow: var(--shadow); border: 1px solid var(--border); }
  .card-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
  .card-title { font-size: 1.1rem; font-weight: 700; color: var(--navy); }
  
  .stat-card { display: flex; align-items: center; gap: 20px; }
  .stat-icon { width: 56px; height: 56px; border-radius: 14px; background: var(--green-dim); color: var(--green); display: flex; align-items: center; justify-content: center; font-size: 1.5rem; }
  .stat-info h4 { font-size: 0.85rem; color: var(--text-muted); font-family: 'DM Sans', sans-serif; margin-bottom: 4px; }
  .stat-info .val { font-size: 1.8rem; font-weight: 800; font-family: 'Syne', sans-serif; color: var(--navy); }

  /* TABLES */
  .table-responsive { overflow-x: auto; }
  table { width: 100%; border-collapse: collapse; }
  th { text-align: left; padding: 16px; font-size: 0.85rem; color: var(--text-muted); font-weight: 600; border-bottom: 1px solid var(--border); background: var(--bg); }
  td { padding: 16px; font-size: 0.9rem; color: var(--text); border-bottom: 1px solid var(--border); }
  tr:last-child td { border-bottom: none; }
  .badge { padding: 6px 12px; border-radius: 50px; font-size: 0.75rem; font-weight: 600; }
  .badge-green { background: var(--green-dim); color: var(--green); }
  .badge-navy { background: rgba(15,42,68,0.1); color: var(--navy); }
  .badge-red { background: rgba(220,53,69,0.1); color: #dc3545; }

  /* FORMS & BUTTONS */
  .form-group { margin-bottom: 20px; }
  .form-group label { display: block; margin-bottom: 8px; font-size: 0.9rem; color: var(--text-muted); font-weight: 500; }
  .form-control { width: 100%; padding: 12px 16px; border-radius: 10px; border: 1px solid var(--border); outline: none; transition: all 0.2s; font-family: 'DM Sans', sans-serif; }
  .form-control:focus { border-color: var(--green); box-shadow: 0 0 0 4px var(--green-dim); }
  
  .btn { display: inline-flex; align-items: center; justify-content: center; gap: 8px; padding: 12px 24px; border-radius: 10px; font-family: 'Syne', sans-serif; font-weight: 600; font-size: 0.9rem; cursor: pointer; border: none; transition: all 0.2s; text-decoration: none; }
  .btn-primary { background: var(--green); color: #fff; }
  .btn-primary:hover { background: var(--green-light); transform: translateY(-1px); box-shadow: 0 6px 20px rgba(47,182,124,0.35); }
  .btn-ghost { background: transparent; border: 1.5px solid var(--border); color: var(--navy); }
  .btn-sm { padding: 8px 16px; font-size: 0.8rem; border-radius: 8px; }

  /* RESPONSIVE */
  @media (max-width: 992px) {
    .sidebar { transform: translateX(-100%); }
    .sidebar.active { transform: translateX(0); box-shadow: 20px 0 50px rgba(0,0,0,0.5); }
    .main-wrapper { margin-left: 0; width: 100%; }
    .mobile-toggle { display: block; }
    .grid-4 { grid-template-columns: repeat(2, 1fr); }
    .grid-3 { grid-template-columns: 1fr; }
    .content-area { padding: 24px; }
  }
  @media (max-width: 576px) {
    .grid-4, .grid-2 { grid-template-columns: 1fr; }
    .topbar { padding: 0 20px; }
  }
</style>
CSS;

$layoutContent = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>NexaNet Dashboard</title>
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,300&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
{$css}
</head>
<body>

<aside class="sidebar" id="sidebar">
  <div class="sidebar-header">
    <a href="#" class="logo"><span class="logo-dot"></span>Nexa<span>Net</span></a>
  </div>
  <ul class="nav-menu">
    @if(request()->is('admin*'))
      <!-- Admin Menu -->
      <li><a href="/admin/dashboard" class="{{ request()->is('admin/dashboard') ? 'active' : '' }}"><i class="fa-solid fa-house"></i> Dashboard</a></li>
      <li><a href="/admin/users" class="{{ request()->is('admin/users*') ? 'active' : '' }}"><i class="fa-solid fa-users"></i> Users</a></li>
      <li><a href="/admin/deposits"><i class="fa-solid fa-money-bill-transfer"></i> Deposits</a></li>
      <li><a href="/admin/withdrawals"><i class="fa-solid fa-building-columns"></i> Withdrawals</a></li>
      <li><a href="/admin/roi"><i class="fa-solid fa-chart-line"></i> ROI Income</a></li>
      <li><a href="/admin/level-income"><i class="fa-solid fa-layer-group"></i> Level Income</a></li>
      <li><a href="/admin/network"><i class="fa-solid fa-network-wired"></i> Network Tree</a></li>
      <li><a href="/admin/club"><i class="fa-solid fa-award"></i> Club Rewards</a></li>
      <li><a href="/admin/vouchers"><i class="fa-solid fa-ticket"></i> Vouchers</a></li>
      <li><a href="/admin/reports"><i class="fa-solid fa-file-invoice"></i> Reports</a></li>
    @else
      <!-- User Menu -->
      <li><a href="/user/dashboard" class="{{ request()->is('user/dashboard') ? 'active' : '' }}"><i class="fa-solid fa-house"></i> Dashboard</a></li>
      <li><a href="/user/investments"><i class="fa-solid fa-piggy-bank"></i> Investments</a></li>
      <li><a href="/user/wallet"><i class="fa-solid fa-wallet"></i> Wallet</a></li>
      <li><a href="/user/withdrawals"><i class="fa-solid fa-building-columns"></i> Withdrawals</a></li>
      <li><a href="/user/referrals"><i class="fa-solid fa-user-plus"></i> Referrals</a></li>
      <li><a href="/user/network"><i class="fa-solid fa-network-wired"></i> Network Tree</a></li>
      <li><a href="/user/roi"><i class="fa-solid fa-chart-line"></i> ROI</a></li>
      <li><a href="/user/level-income"><i class="fa-solid fa-layer-group"></i> Level Income</a></li>
      <li><a href="/user/club-rewards"><i class="fa-solid fa-award"></i> Club Rewards</a></li>
      <li><a href="/user/profile"><i class="fa-solid fa-gear"></i> Profile</a></li>
    @endif
    <li style="margin-top:20px"><a href="/auth/login" style="color:#dc3545"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
  </ul>
</aside>

<div class="main-wrapper">
  <header class="topbar">
    <div class="mobile-toggle" onclick="document.getElementById('sidebar').classList.toggle('active')"><i class="fa-solid fa-bars"></i></div>
    <div class="top-search">
      <input type="text" placeholder="Search...">
    </div>
    <div class="top-profile">
      <span style="font-weight:600;font-size:0.9rem">@if(request()->is('admin*')) Admin User @else John Doe @endif</span>
      <div class="user-avatar">@if(request()->is('admin*')) AU @else JD @endif</div>
    </div>
  </header>
  <main class="content-area">
    @yield('content')
  </main>
</div>

</body>
</html>
HTML;

makeDir($baseDir . 'layouts');
file_put_contents($baseDir . 'layouts/app.blade.php', $layoutContent);

// 2. Auth Layout
$authLayout = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>NexaNet - Authentication</title>
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,300&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
{$css}
<style>
  body { display: flex; align-items: center; justify-content: center; min-height: 100vh; }
  .auth-card { background: var(--card-bg); width: 100%; max-width: 440px; padding: 48px 40px; border-radius: 20px; box-shadow: var(--shadow); text-align: center; }
  .auth-card .logo { justify-content: center; margin-bottom: 8px; color: var(--navy); }
  .auth-subtitle { color: var(--text-muted); font-size: 0.95rem; margin-bottom: 32px; }
</style>
</head>
<body>
  @yield('content')
</body>
</html>
HTML;

file_put_contents($baseDir . 'layouts/auth.blade.php', $authLayout);

// 3. Generators

$pages = [
    // AUTH
    'auth/login.blade.php' => <<<HTML
@extends('layouts.auth')
@section('content')
<div class="auth-card">
  <div class="logo"><span class="logo-dot"></span>Nexa<span>Net</span></div>
  <p class="auth-subtitle">Welcome back! Please login to your account.</p>
  <form action="/user/dashboard">
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
HTML,

    'auth/register.blade.php' => <<<HTML
@extends('layouts.auth')
@section('content')
<div class="auth-card" style="max-width:540px">
  <div class="logo"><span class="logo-dot"></span>Nexa<span>Net</span></div>
  <p class="auth-subtitle">Create your account and join the network.</p>
  <form action="/auth/login">
    <div class="grid-2">
      <div class="form-group" style="text-align:left"><label>Full Name</label><input type="text" class="form-control" placeholder="John Doe"></div>
      <div class="form-group" style="text-align:left"><label>Phone</label><input type="text" class="form-control" placeholder="+1 234 567 890"></div>
    </div>
    <div class="form-group" style="text-align:left"><label>Email Address</label><input type="email" class="form-control" placeholder="enter@email.com"></div>
    <div class="form-group" style="text-align:left"><label>Referral Code (Upline)</label><input type="text" class="form-control" placeholder="Optional"></div>
    <div class="grid-2">
      <div class="form-group" style="text-align:left"><label>Password</label><input type="password" class="form-control" placeholder="••••••••"></div>
      <div class="form-group" style="text-align:left"><label>Confirm</label><input type="password" class="form-control" placeholder="••••••••"></div>
    </div>
    <button type="submit" class="btn btn-primary" style="width:100%;margin-top:10px">Register Account</button>
  </form>
  <p style="margin-top:24px;font-size:0.9rem;color:var(--text-muted)">Already signed up? <a href="/auth/login" style="color:var(--green);text-decoration:none;font-weight:600">Login</a></p>
</div>
@endsection
HTML,

    // USER DASHBOARD
    'user/dashboard.blade.php' => <<<HTML
@extends('layouts.app')
@section('content')
<div style="margin-bottom:32px">
  <h2 style="font-size:1.8rem;color:var(--navy);font-weight:800;margin-bottom:8px">Welcome back, John! 👋</h2>
  <p style="color:var(--text-muted)">Here is your latest network summary and earnings.</p>
</div>

<div class="grid-4" style="margin-bottom:32px">
  <div class="card stat-card">
    <div class="stat-icon"><i class="fa-solid fa-piggy-bank"></i></div>
    <div class="stat-info"><h4>Total Investment</h4><div class="val">$5,000</div></div>
  </div>
  <div class="card stat-card">
    <div class="stat-icon"><i class="fa-solid fa-wallet"></i></div>
    <div class="stat-info"><h4>Wallet Balance</h4><div class="val">$1,240</div></div>
  </div>
  <div class="card stat-card">
    <div class="stat-icon"><i class="fa-solid fa-chart-line"></i></div>
    <div class="stat-info"><h4>Total ROI Earned</h4><div class="val">$850</div></div>
  </div>
  <div class="card stat-card">
    <div class="stat-icon"><i class="fa-solid fa-layer-group"></i></div>
    <div class="stat-info"><h4>Level Income</h4><div class="val">$390</div></div>
  </div>
</div>

<div class="grid-4" style="margin-bottom:32px">
  <div class="card stat-card">
    <div class="stat-icon" style="background:rgba(15,42,68,0.1);color:var(--navy)"><i class="fa-solid fa-user-plus"></i></div>
    <div class="stat-info"><h4>Direct Referrals</h4><div class="val">12</div></div>
  </div>
  <div class="card stat-card">
    <div class="stat-icon" style="background:rgba(15,42,68,0.1);color:var(--navy)"><i class="fa-solid fa-users"></i></div>
    <div class="stat-info"><h4>Total Team Size</h4><div class="val">148</div></div>
  </div>
  <div class="card stat-card" style="grid-column: span 2">
    <div class="stat-icon" style="background:rgba(15,42,68,0.1);color:var(--navy)"><i class="fa-solid fa-award"></i></div>
    <div class="stat-info" style="width:100%">
      <div style="display:flex;justify-content:space-between;align-items:end">
        <div><h4>Club Progress</h4><div class="val" style="font-size:1.2rem">Gold Tier</div></div>
        <div style="font-weight:700;color:var(--green)">65%</div>
      </div>
      <div style="height:6px;background:var(--bg);border-radius:10px;margin-top:10px;overflow:hidden"><div style="width:65%;height:100%;background:var(--green)"></div></div>
    </div>
  </div>
</div>

<div class="grid-2">
  <div class="card">
    <div class="card-header"><div class="card-title">Recent Transactions</div><a href="/user/wallet" class="btn btn-ghost btn-sm">View All</a></div>
    <div class="table-responsive">
      <table>
        <tr><th>Type</th><th>Amount</th><th>Date</th></tr>
        <tr><td><span class="badge badge-green">ROI Income</span></td><td>+$120.00</td><td>Today, 10:30 AM</td></tr>
        <tr><td><span class="badge badge-green">Level Income</span></td><td>+$45.50</td><td>Yesterday</td></tr>
        <tr><td><span class="badge badge-navy">Withdrawal</span></td><td>-$500.00</td><td>Oct 12, 2026</td></tr>
      </table>
    </div>
  </div>
  <div class="card">
    <div class="card-header"><div class="card-title">Recent ROI</div><a href="/user/roi" class="btn btn-ghost btn-sm">View All</a></div>
    <div class="table-responsive">
      <table>
        <tr><th>Week</th><th>ROI %</th><th>Amount</th></tr>
        <tr><td>Week 14</td><td>2.5%</td><td>$125.00</td></tr>
        <tr><td>Week 13</td><td>2.5%</td><td>$125.00</td></tr>
        <tr><td>Week 12</td><td>2.5%</td><td>$125.00</td></tr>
      </table>
    </div>
  </div>
</div>
@endsection
HTML,

    // ADMIN DASHBOARD
    'admin/dashboard/index.blade.php' => <<<HTML
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
HTML,
];

// Reusable functions to build standard list/form views
function buildListView($title, $icon, $columns, $rows, $createLink = null) {
  $btnHTML = $createLink ? "<a href='{$createLink}' class='btn btn-primary'><i class='fa-solid fa-plus'></i> Add New</a>" : "";
  $thHTML = implode('', array_map(fn($c) => "<th>$c</th>", $columns));
  $trHTML = implode('', array_map(function($r) {
      $tds = implode('', array_map(fn($d) => "<td>$d</td>", $r));
      return "<tr>{$tds}</tr>";
  }, $rows));
  
  return <<<HTML
@extends('layouts.app')
@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:32px">
  <div>
    <h2 style="font-size:1.8rem;color:var(--navy);font-weight:800;margin-bottom:8px">
      <i class="{$icon}" style="color:var(--green);margin-right:8px"></i> {$title}
    </h2>
    <p style="color:var(--text-muted)">Manage and view all records.</p>
  </div>
  {$btnHTML}
</div>
<div class="card">
  <div class="table-responsive">
    <table>
      <thead><tr>{$thHTML}</tr></thead>
      <tbody>{$trHTML}</tbody>
    </table>
  </div>
</div>
@endsection
HTML;
}

function buildFormView($title, $icon, $fields, $backLink) {
  $fhtml = "";
  foreach($fields as $f) {
      $type = strtolower($f['type'] ?? 'text');
      if($type === 'file') {
          $fhtml .= "<div class='form-group'><label>{$f['label']}</label><input type='file' class='form-control'></div>";
      } elseif($type === 'select') {
          $opts = implode('', array_map(fn($o)=>"<option>{$o}</option>", $f['options']));
          $fhtml .= "<div class='form-group'><label>{$f['label']}</label><select class='form-control'>{$opts}</select></div>";
      } else {
          $fhtml .= "<div class='form-group'><label>{$f['label']}</label><input type='{$type}' class='form-control' placeholder='Enter {$f['label']}'></div>";
      }
  }

  return <<<HTML
@extends('layouts.app')
@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:32px">
  <div>
    <h2 style="font-size:1.8rem;color:var(--navy);font-weight:800;margin-bottom:8px">
      <i class="{$icon}" style="color:var(--green);margin-right:8px"></i> {$title}
    </h2>
    <p style="color:var(--text-muted)">Fill the form below to submit data.</p>
  </div>
  <a href="{$backLink}" class="btn btn-ghost"><i class="fa-solid fa-arrow-left"></i> Back to List</a>
</div>
<div class="card" style="max-width:800px">
  <form>
    {$fhtml}
    <div style="margin-top:32px">
      <button type="submit" class="btn btn-primary">Submit Form</button>
    </div>
  </form>
</div>
@endsection
HTML;
}

// Generate User List Pages
$pages['user/investments/index.blade.php'] = buildListView("My Investments", "fa-solid fa-piggy-bank", ["ID", "Package", "Amount", "ROI %", "Status", "Start Date", "Action"], [
    ["#INV-102", "Starter Pack", "$1,000", "2.5%", "<span class='badge badge-green'>Active</span>", "10 Jan 2026", "<a href='#' class='btn btn-ghost btn-sm'>View</a>"],
    ["#INV-098", "Basic Pack", "$500", "2.0%", "<span class='badge badge-navy'>Completed</span>", "01 Sep 2025", "<a href='#' class='btn btn-ghost btn-sm'>View</a>"]
], "/user/investments/create");

$pages['user/investments/create.blade.php'] = buildFormView("New Investment", "fa-solid fa-piggy-bank", [
    ['label'=>'Select Package', 'type'=>'select', 'options'=>['Starter Pack ($500)', 'Pro Pack ($1000)', 'Elite Pack ($5000)']],
    ['label'=>'Investment Amount ($)', 'type'=>'number'],
    ['label'=>'Payment Method', 'type'=>'select', 'options'=>['USDT TRC20', 'Bank Transfer', 'Internal Wallet']],
    ['label'=>'Upload Payment Proof', 'type'=>'file']
], "/user/investments");

$pages['user/wallet/index.blade.php'] = buildListView("Wallet Transactions", "fa-solid fa-wallet", ["ID", "Type", "Amount", "Description", "Date"], [
    ["#TX-902", "<span class='badge badge-green'>ROI Income</span>", "+$25.00", "Weekly ROI for INV-102", "Oct 12, 2026"],
    ["#TX-901", "<span class='badge badge-green'>Level Income</span>", "+$15.00", "Level 2 Commission from Alice", "Oct 11, 2026"],
    ["#TX-900", "<span class='badge badge-red'>Withdrawal</span>", "-$500.00", "Withdrawal to USDT", "Oct 10, 2026"]
]);

$pages['user/withdrawals/index.blade.php'] = buildListView("Withdrawal History", "fa-solid fa-building-columns", ["ID", "Amount", "Method", "Status", "Date"], [
    ["#WD-302", "$500.00", "USDT TRC20", "<span class='badge badge-green'>Paid</span>", "Oct 10, 2026"],
    ["#WD-331", "$120.00", "Bank Transfer", "<span class='badge badge-navy'>Pending</span>", "Oct 15, 2026"]
], "/user/withdrawals/create");

$pages['user/withdrawals/create.blade.php'] = buildFormView("Request Withdrawal", "fa-solid fa-building-columns", [
    ['label'=>'Withdrawal Amount ($)', 'type'=>'number'],
    ['label'=>'Payment Method', 'type'=>'select', 'options'=>['USDT TRC20', 'Bank Transfer']],
    ['label'=>'Address / Bank Details', 'type'=>'text']
], "/user/withdrawals");

$pages['user/referrals/index.blade.php'] = <<<HTML
@extends('layouts.app')
@section('content')
<h2 style="font-size:1.8rem;color:var(--navy);font-weight:800;margin-bottom:8px">
  <i class="fa-solid fa-user-plus" style="color:var(--green);margin-right:8px"></i> Direct Referrals
</h2>
<p style="color:var(--text-muted);margin-bottom:32px">Share your link and view your direct invites.</p>

<div class="card" style="margin-bottom:32px;display:flex;align-items:center;justify-content:space-between">
  <div>
    <h4>Your Referral Link</h4>
    <p style="color:var(--green);font-weight:700;font-size:1.1rem;margin-top:8px">https://nexanet.com/register?ref=JOHNDOE123</p>
  </div>
  <button class="btn btn-primary"><i class="fa-regular fa-copy"></i> Copy Link</button>
</div>

<div class="card">
  <div class="table-responsive">
    <table>
      <thead><tr><th>User</th><th>Email</th><th>Join Date</th><th>Investment</th></tr></thead>
      <tbody>
        <tr><td>Alice Smith</td><td>alice@example.com</td><td>Oct 01, 2026</td><td>$1,000</td></tr>
        <tr><td>Mark Johnson</td><td>mark@example.com</td><td>Sep 15, 2026</td><td>$500</td></tr>
      </tbody>
    </table>
  </div>
</div>
@endsection
HTML;

$pages['user/network/index.blade.php'] = buildListView("Network Tree", "fa-solid fa-network-wired", ["User", "Upline", "Level", "Investment", "Join Date"], [
    ["Alice Smith", "John Doe (You)", "Level 1", "$1,000", "Oct 01, 2026"],
    ["Mark Johnson", "John Doe (You)", "Level 1", "$500", "Sep 15, 2026"],
    ["Bob Miller", "Alice Smith", "Level 2", "$2,000", "Oct 05, 2026"]
]);

$pages['user/roi/index.blade.php'] = buildListView("ROI History", "fa-solid fa-chart-line", ["Week", "Investment", "ROI %", "ROI Amount", "Date"], [
    ["Week 14", "Starter Pack ($1,000)", "2.5%", "$25.00", "Oct 14, 2026"],
    ["Week 13", "Starter Pack ($1,000)", "2.5%", "$25.00", "Oct 07, 2026"]
]);

$pages['user/level-income/index.blade.php'] = buildListView("Level Income", "fa-solid fa-layer-group", ["From User", "Level", "ROI Reference", "Commission", "Date"], [
    ["Alice Smith", "Level 1", "Week 14 ROI", "$2.50", "Oct 14, 2026"],
    ["Bob Miller", "Level 2", "Week 14 ROI", "$1.25", "Oct 14, 2026"]
]);

$pages['user/club-rewards/index.blade.php'] = buildListView("Club Rewards", "fa-solid fa-award", ["Reward", "Direct Business", "Team Business", "Status", "Code"], [
    ["$50 Bonus Voucher", "$5,000 Req.", "$15,000 Req.", "<span class='badge badge-green'>Achieved</span>", "VCH-2938"],
    ["iPhone 15 Pro", "$15,000 Req.", "$50,000 Req.", "<span class='badge badge-navy'>In Progress</span>", "-"]
]);

$pages['user/profile/index.blade.php'] = buildFormView("My Profile", "fa-solid fa-gear", [
    ['label'=>'Full Name', 'type'=>'text'],
    ['label'=>'Email Address', 'type'=>'email'],
    ['label'=>'Phone Number', 'type'=>'text'],
    ['label'=>'Wallet Address (USDT TRC20)', 'type'=>'text'],
    ['label'=>'New Password', 'type'=>'password']
], "/user/dashboard");

// Generate Admin List Pages
$pages['admin/users/index.blade.php'] = buildListView("Manage Users", "fa-solid fa-users", ["ID", "Name", "Email", "Status", "Join Date", "Actions"], [
    ["1", "John Doe", "john@example.com", "<span class='badge badge-green'>Active</span>", "Jan 01, 2026", "<a href='/admin/users/edit' class='btn btn-ghost btn-sm'>Edit</a>"],
    ["2", "Alice Smith", "alice@example.com", "<span class='badge badge-green'>Active</span>", "Mar 15, 2026", "<a href='/admin/users/edit' class='btn btn-ghost btn-sm'>Edit</a>"]
], "/admin/users/create");

$pages['admin/users/create.blade.php'] = buildFormView("Create User", "fa-solid fa-users", [
    ['label'=>'Full Name', 'type'=>'text'],
    ['label'=>'Email', 'type'=>'email'],
    ['label'=>'Password', 'type'=>'password'],
    ['label'=>'Sponsor Referral Code', 'type'=>'text']
], "/admin/users");

$pages['admin/users/edit.blade.php'] = buildFormView("Edit User", "fa-solid fa-users", [
    ['label'=>'Full Name', 'type'=>'text'],
    ['label'=>'Email', 'type'=>'email'],
    ['label'=>'Status', 'type'=>'select', 'options'=>['Active', 'Blocked']]
], "/admin/users");

$pages['admin/deposits/index.blade.php'] = buildListView("Manage Deposits", "fa-solid fa-money-bill-transfer", ["ID", "User", "Amount", "Method", "Status", "Date", "Action"], [
    ["#DP-91", "John Doe", "$1,000", "USDT TRC20", "<span class='badge badge-navy'>Pending</span>", "Today", "<button class='btn btn-sm btn-primary'>Approve</button>"],
    ["#DP-90", "Alice Smith", "$500", "Bank Transfer", "<span class='badge badge-green'>Approved</span>", "Yesterday", "<button class='btn btn-sm btn-ghost'>View</button>"]
]);

$pages['admin/withdrawals/index.blade.php'] = buildListView("Process Withdrawals", "fa-solid fa-building-columns", ["ID", "User", "Amount", "Method", "Status", "Date", "Action"], [
    ["#WD-42", "John Doe", "$300", "USDT", "<span class='badge badge-navy'>Pending</span>", "Today", "<button class='btn btn-sm btn-primary'>Approve</button>"],
    ["#WD-41", "Mark Johnson", "$1200", "Bank", "<span class='badge badge-green'>Paid</span>", "Yesterday", "<button class='btn btn-sm btn-ghost'>View</button>"]
]);

$pages['admin/roi/index.blade.php'] = <<<HTML
@extends('layouts.app')
@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:32px">
  <div>
    <h2 style="font-size:1.8rem;color:var(--navy);font-weight:800;margin-bottom:8px">
      <i class="fa-solid fa-chart-line" style="color:var(--green);margin-right:8px"></i> Distributed ROI
    </h2>
    <p style="color:var(--text-muted)">History of all ROI payouts across the network.</p>
  </div>
  <button class="btn btn-primary"><i class="fa-solid fa-bolt"></i> Run ROI Script Menually</button>
</div>
<div class="card">
  <div class="table-responsive">
    <table>
      <thead><tr><th>ID</th><th>User</th><th>Investment</th><th>ROI Amount</th><th>Week</th><th>Date</th></tr></thead>
      <tbody>
        <tr><td>1024</td><td>John Doe</td><td>$1,000</td><td>$25.00</td><td>Week 14</td><td>Oct 14, 2026</td></tr>
        <tr><td>1025</td><td>Alice Smith</td><td>$500</td><td>$12.50</td><td>Week 14</td><td>Oct 14, 2026</td></tr>
      </tbody>
    </table>
  </div>
</div>
@endsection
HTML;

$pages['admin/level-income/index.blade.php'] = buildListView("Level Commissions", "fa-solid fa-layer-group", ["Receiver", "From User", "Level", "Amount", "Date"], [
    ["John Doe", "Alice Smith", "Level 1", "$2.50", "Oct 14, 2026"],
    ["John Doe", "Bob Miller", "Level 2", "$1.25", "Oct 14, 2026"]
]);

$pages['admin/network/index.blade.php'] = buildListView("Network Tree Browser", "fa-solid fa-network-wired", ["User", "Upline", "Level", "Team Size"], [
    ["John Doe", "Root Node", "Root", "148"],
    ["Alice Smith", "John Doe", "Level 1", "24"],
    ["Mark Johnson", "John Doe", "Level 1", "12"]
]);

$pages['admin/club/index.blade.php'] = buildListView("Club Qualifications", "fa-solid fa-award", ["User", "Direct Business", "Team Business", "Club Level", "Action"], [
    ["John Doe", "$18,000", "$60,000", "Platinum Tier", "<button class='btn btn-sm btn-primary'>Approve Reward</button>"],
    ["Alice Smith", "$6,000", "$12,000", "Gold Tier", "<span class='badge badge-green'>Rewarded</span>"]
]);

$pages['admin/vouchers/index.blade.php'] = buildListView("Manage Vouchers", "fa-solid fa-ticket", ["Code", "Value", "Assigned To", "Status"], [
    ["VCH-2938", "$50", "John Doe", "<span class='badge badge-navy'>Unused</span>"],
    ["VCH-1123", "$100", "Alice Smith", "<span class='badge badge-green'>Used</span>"]
], "/admin/vouchers/create");

$pages['admin/vouchers/create.blade.php'] = buildFormView("Create Voucher", "fa-solid fa-ticket", [
    ['label'=>'Voucher Code (Auto-generated)', 'type'=>'text'],
    ['label'=>'Voucher Value ($)', 'type'=>'number'],
    ['label'=>'Assign to User Email (Optional)', 'type'=>'email']
], "/admin/vouchers");

$pages['admin/reports/index.blade.php'] = <<<HTML
@extends('layouts.app')
@section('content')
<h2 style="font-size:1.8rem;color:var(--navy);font-weight:800;margin-bottom:8px">
  <i class="fa-solid fa-file-invoice" style="color:var(--green);margin-right:8px"></i> System Reports
</h2>
<p style="color:var(--text-muted);margin-bottom:32px">In-depth statistical insights of the platform.</p>

<div class="grid-2">
  <div class="card">
    <div class="card-header"><div class="card-title">Top Referrers</div></div>
    <div class="table-responsive">
      <table>
        <tr><th>User</th><th>Total Invites</th></tr>
        <tr><td>Sarah Williams</td><td>84</td></tr>
        <tr><td>John Doe</td><td>42</td></tr>
        <tr><td>Mike Brown</td><td>38</td></tr>
      </table>
    </div>
  </div>
  <div class="card">
    <div class="card-header"><div class="card-title">Financial Summary</div></div>
    <div class="table-responsive">
      <table>
        <tr><th>Metric</th><th>Value</th></tr>
        <tr><td>Total Deposits (All Time)</td><td style="color:var(--green);font-weight:700">$5,240,000</td></tr>
        <tr><td>Total Withdrawals</td><td style="color:#dc3545;font-weight:700">$1,850,000</td></tr>
        <tr><td>Total ROI Distributed</td><td>$840,000</td></tr>
      </table>
    </div>
  </div>
</div>
@endsection
HTML;

// Write all generated pages
foreach ($pages as $filepath => $content) {
    $fullPath = $baseDir . $filepath;
    makeDir(dirname($fullPath));
    file_put_contents($fullPath, $content);
}

echo "All 25+ UI views generated successfully!";
?>
