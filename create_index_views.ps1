$basePaths = @('C:\laravel-projects\mlm\resources\views\user', 'C:\laravel-projects\mlm\resources\views\admin')
foreach ($p in $basePaths) {
    Get-ChildItem -Path $p -Directory | ForEach-Object {
        $indexPath = Join-Path $_.FullName "index.blade.php"
        if (-not (Test-Path $indexPath)) {
            New-Item -ItemType File -Force -Path $indexPath | Out-Null
        }
    }
}
Write-Output "Created index.blade.php files in all subdirectories."
