$ErrorActionPreference = "Stop"

$appBlade = "C:\laravel-projects\mlm\resources\views\layouts\app.blade.php"
$appContent = Get-Content $appBlade -Raw

# Replace Admin Links
$appContent = $appContent -replace '<li><a href="/admin/deposits"><i class="fa-solid fa-money-bill-transfer"></i> Deposits</a></li>', '<li><a href="/admin/deposits" class="{{ request()->is(''admin/deposits*'') ? ''active'' : '''' }}"><i class="fa-solid fa-money-bill-transfer"></i> Deposits</a></li>'
$appContent = $appContent -replace '<li><a href="/admin/withdrawals"><i class="fa-solid fa-building-columns"></i> Withdrawals</a></li>', '<li><a href="/admin/withdrawals" class="{{ request()->is(''admin/withdrawals*'') ? ''active'' : '''' }}"><i class="fa-solid fa-building-columns"></i> Withdrawals</a></li>'
$appContent = $appContent -replace '<li><a href="/admin/roi"><i class="fa-solid fa-chart-line"></i> ROI Income</a></li>', '<li><a href="/admin/roi" class="{{ request()->is(''admin/roi*'') ? ''active'' : '''' }}"><i class="fa-solid fa-chart-line"></i> ROI Income</a></li>'
$appContent = $appContent -replace '<li><a href="/admin/level-income"><i class="fa-solid fa-layer-group"></i> Level Income</a></li>', '<li><a href="/admin/level-income" class="{{ request()->is(''admin/level-income*'') ? ''active'' : '''' }}"><i class="fa-solid fa-layer-group"></i> Level Income</a></li>'
$appContent = $appContent -replace '<li><a href="/admin/network"><i class="fa-solid fa-network-wired"></i> Network Tree</a></li>', '<li><a href="/admin/network" class="{{ request()->is(''admin/network*'') ? ''active'' : '''' }}"><i class="fa-solid fa-network-wired"></i> Network Tree</a></li>'
$appContent = $appContent -replace '<li><a href="/admin/club"><i class="fa-solid fa-award"></i> Club Rewards</a></li>', '<li><a href="/admin/club" class="{{ request()->is(''admin/club*'') ? ''active'' : '''' }}"><i class="fa-solid fa-award"></i> Club Rewards</a></li>'
$appContent = $appContent -replace '<li><a href="/admin/vouchers"><i class="fa-solid fa-ticket"></i> Vouchers</a></li>', '<li><a href="/admin/vouchers" class="{{ request()->is(''admin/vouchers*'') ? ''active'' : '''' }}"><i class="fa-solid fa-ticket"></i> Vouchers</a></li>'
$appContent = $appContent -replace '<li><a href="/admin/reports"><i class="fa-solid fa-file-invoice"></i> Reports</a></li>', '<li><a href="/admin/reports" class="{{ request()->is(''admin/reports*'') ? ''active'' : '''' }}"><i class="fa-solid fa-file-invoice"></i> Reports</a></li>'

# Replace User Links
$appContent = $appContent -replace '<li><a href="/user/investments"><i class="fa-solid fa-piggy-bank"></i> Investments</a></li>', '<li><a href="/user/investments" class="{{ request()->is(''user/investments*'') ? ''active'' : '''' }}"><i class="fa-solid fa-piggy-bank"></i> Investments</a></li>'
$appContent = $appContent -replace '<li><a href="/user/wallet"><i class="fa-solid fa-wallet"></i> Wallet</a></li>', '<li><a href="/user/wallet" class="{{ request()->is(''user/wallet*'') ? ''active'' : '''' }}"><i class="fa-solid fa-wallet"></i> Wallet</a></li>'
$appContent = $appContent -replace '<li><a href="/user/withdrawals"><i class="fa-solid fa-building-columns"></i> Withdrawals</a></li>', '<li><a href="/user/withdrawals" class="{{ request()->is(''user/withdrawals*'') ? ''active'' : '''' }}"><i class="fa-solid fa-building-columns"></i> Withdrawals</a></li>'
$appContent = $appContent -replace '<li><a href="/user/referrals"><i class="fa-solid fa-user-plus"></i> Referrals</a></li>', '<li><a href="/user/referrals" class="{{ request()->is(''user/referrals*'') ? ''active'' : '''' }}"><i class="fa-solid fa-user-plus"></i> Referrals</a></li>'
$appContent = $appContent -replace '<li><a href="/user/network"><i class="fa-solid fa-network-wired"></i> Network Tree</a></li>', '<li><a href="/user/network" class="{{ request()->is(''user/network*'') ? ''active'' : '''' }}"><i class="fa-solid fa-network-wired"></i> Network Tree</a></li>'
$appContent = $appContent -replace '<li><a href="/user/roi"><i class="fa-solid fa-chart-line"></i> ROI</a></li>', '<li><a href="/user/roi" class="{{ request()->is(''user/roi*'') ? ''active'' : '''' }}"><i class="fa-solid fa-chart-line"></i> ROI</a></li>'
$appContent = $appContent -replace '<li><a href="/user/level-income"><i class="fa-solid fa-layer-group"></i> Level Income</a></li>', '<li><a href="/user/level-income" class="{{ request()->is(''user/level-income*'') ? ''active'' : '''' }}"><i class="fa-solid fa-layer-group"></i> Level Income</a></li>'
$appContent = $appContent -replace '<li><a href="/user/club-rewards"><i class="fa-solid fa-award"></i> Club Rewards</a></li>', '<li><a href="/user/club-rewards" class="{{ request()->is(''user/club-rewards*'') ? ''active'' : '''' }}"><i class="fa-solid fa-award"></i> Club Rewards</a></li>'
$appContent = $appContent -replace '<li><a href="/user/profile"><i class="fa-solid fa-gear"></i> Profile</a></li>', '<li><a href="/user/profile" class="{{ request()->is(''user/profile*'') ? ''active'' : '''' }}"><i class="fa-solid fa-gear"></i> Profile</a></li>'

Set-Content -Path $appBlade -Value $appContent

# Landing page copy / rewrite
$landingSrc = "C:\xampp\htdocs\mlm\index.php"
$landingDest = "C:\laravel-projects\mlm\resources\views\welcome.blade.php"
$landingContent = Get-Content $landingSrc -Raw

$landingContent = $landingContent -replace '<a href="#" class="btn btn-ghost">Login</a>', '<a href="/auth/login" class="btn btn-ghost">Login</a>'
$landingContent = $landingContent -replace '<a href="#" class="btn btn-primary">Join Now</a>', '<a href="/auth/register" class="btn btn-primary">Join Now</a>'
$landingContent = $landingContent -replace '<a href="#" class="btn btn-primary btn-lg"><i class="fa-solid fa-rocket"></i> Join Now</a>', '<a href="/auth/register" class="btn btn-primary btn-lg"><i class="fa-solid fa-rocket"></i> Join Now</a>'
$landingContent = $landingContent -replace '<a href="#" class="btn btn-ghost btn-lg"><i class="fa-regular fa-circle-play"></i> Login</a>', '<a href="/auth/login" class="btn btn-ghost btn-lg"><i class="fa-regular fa-circle-play"></i> Login</a>'

Set-Content -Path $landingDest -Value $landingContent

# Generate Admin Auth view
$authLogin = "C:\laravel-projects\mlm\resources\views\auth\login.blade.php"
$adminAuthDir = "C:\laravel-projects\mlm\resources\views\admin\auth"
if (-not (Test-Path $adminAuthDir)) { New-Item -ItemType Directory -Force -Path $adminAuthDir | Out-Null }
$adminLoginDest = "$adminAuthDir\login.blade.php"

$adminLoginContent = Get-Content $authLogin -Raw
$adminLoginContent = $adminLoginContent -replace 'Welcome back! Please login to your account.', 'Admin Panel Secured Login'
$adminLoginContent = $adminLoginContent -replace 'action="/user/dashboard"', 'action="/admin/dashboard"'

Set-Content -Path $adminLoginDest -Value $adminLoginContent

Write-Output "UI refactoring complete."
