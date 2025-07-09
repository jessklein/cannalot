# PowerShell script to setup cannalot.local
# Run this as Administrator

Write-Host "Setting up cannalot.local domain..." -ForegroundColor Green
Write-Host ""

$hostsFile = "C:\Windows\System32\drivers\etc\hosts"
$domain = "127.0.0.1 cannalot.local"

# Check if running as administrator
if (-NOT ([Security.Principal.WindowsPrincipal] [Security.Principal.WindowsIdentity]::GetCurrent()).IsInRole([Security.Principal.WindowsBuiltInRole] "Administrator")) {
    Write-Host "ERROR: This script must be run as Administrator!" -ForegroundColor Red
    Write-Host "Right-click PowerShell and select 'Run as Administrator'" -ForegroundColor Yellow
    pause
    exit 1
}

# Check if domain already exists
$hostsContent = Get-Content $hostsFile
if ($hostsContent -match "cannalot.local") {
    Write-Host "cannalot.local is already configured in hosts file" -ForegroundColor Yellow
} else {
    # Add domain to hosts file
    Add-Content -Path $hostsFile -Value $domain
    Write-Host "Added cannalot.local to hosts file" -ForegroundColor Green
}

Write-Host ""
Write-Host "Setup complete! You can now access your site at:" -ForegroundColor Green
Write-Host "http://cannalot.local:8000" -ForegroundColor Cyan
Write-Host ""
Write-Host "Press any key to continue..."
$null = $Host.UI.RawUI.ReadKey("NoEcho,IncludeKeyDown")
