<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>EliteMatrixPro Dashboard</title>
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,300&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
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
</head>
<body>

<aside class="sidebar" id="sidebar">
  <div class="sidebar-header">
    <a href="#" class="logo"><span class="logo-dot"></span>Nexa<span>Net</span></a>
  </div>
  <ul class="nav-menu">
    @if(request()->is('admin*'))
      <!-- Admin Menu -->
      <li><a href="{{ route('admin.dashboard') }}" class="{{ request()->is('admin/dashboard') ? 'active' : '' }}"><i class="fa-solid fa-house"></i> Dashboard</a></li>
      <li><a href="{{ route('admin.users.index') }}" class="{{ request()->is('admin/users*') ? 'active' : '' }}"><i class="fa-solid fa-users"></i> Users</a></li>
      <li><a href="{{ route('admin.deposits.index') }}" class="{{ request()->is('admin/deposits*') ? 'active' : '' }}"><i class="fa-solid fa-money-bill-transfer"></i> Deposits</a></li>
      <li><a href="{{ route('admin.withdrawals.index') }}" class="{{ request()->is('admin/withdrawals*') ? 'active' : '' }}"><i class="fa-solid fa-building-columns"></i> Withdrawals</a></li>
      <li><a href="{{ route('admin.roi.index') }}" class="{{ request()->is('admin/roi*') ? 'active' : '' }}"><i class="fa-solid fa-chart-line"></i> ROI Income</a></li>
      <li><a href="{{ route('admin.level-income.index') }}" class="{{ request()->is('admin/level-income*') ? 'active' : '' }}"><i class="fa-solid fa-layer-group"></i> Level Income</a></li>
      <li><a href="{{ url('admin/network') }}" class="{{ request()->is('admin/network*') ? 'active' : '' }}"><i class="fa-solid fa-network-wired"></i> Network Tree</a></li>
      <li><a href="{{ url('admin/club') }}" class="{{ request()->is('admin/club*') ? 'active' : '' }}"><i class="fa-solid fa-award"></i> Club Rewards</a></li>
      <li><a href="{{ url('admin/vouchers') }}" class="{{ request()->is('admin/vouchers*') ? 'active' : '' }}"><i class="fa-solid fa-ticket"></i> Vouchers</a></li>
      <li><a href="{{ url('admin/reports') }}" class="{{ request()->is('admin/reports*') ? 'active' : '' }}"><i class="fa-solid fa-file-invoice"></i> Reports</a></li>
    @else
      <!-- User Menu -->
      <li><a href="{{ url('user/dashboard') }}" class="{{ request()->is('user/dashboard') ? 'active' : '' }}"><i class="fa-solid fa-house"></i> Dashboard</a></li>
      <li><a href="{{ url('user/investments') }}" class="{{ request()->is('user/investments*') ? 'active' : '' }}"><i class="fa-solid fa-piggy-bank"></i> Investments</a></li>
      <li><a href="{{ url('user/wallet') }}" class="{{ request()->is('user/wallet*') ? 'active' : '' }}"><i class="fa-solid fa-wallet"></i> Wallet</a></li>
      <li><a href="{{ url('user/withdrawals') }}" class="{{ request()->is('user/withdrawals*') ? 'active' : '' }}"><i class="fa-solid fa-building-columns"></i> Withdrawals</a></li>
      <li><a href="{{ url('user/referrals') }}" class="{{ request()->is('user/referrals*') ? 'active' : '' }}"><i class="fa-solid fa-user-plus"></i> Referrals</a></li>
      <li><a href="{{ url('user/network') }}" class="{{ request()->is('user/network*') ? 'active' : '' }}"><i class="fa-solid fa-network-wired"></i> Network Tree</a></li>
      <li><a href="{{ url('user/roi') }}" class="{{ request()->is('user/roi*') ? 'active' : '' }}"><i class="fa-solid fa-chart-line"></i> ROI</a></li>
      <li><a href="{{ url('user/level-income') }}" class="{{ request()->is('user/level-income*') ? 'active' : '' }}"><i class="fa-solid fa-layer-group"></i> Level Income</a></li>
      <li><a href="{{ url('user/club-rewards') }}" class="{{ request()->is('user/club-rewards*') ? 'active' : '' }}"><i class="fa-solid fa-award"></i> Club Rewards</a></li>
      <li><a href="{{ url('user/profile') }}" class="{{ request()->is('user/profile*') ? 'active' : '' }}"><i class="fa-solid fa-gear"></i> Profile</a></li>
    @endif
    <li style="margin-top:20px"><a href="{{ route('login') }}" style="color:#dc3545"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
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

