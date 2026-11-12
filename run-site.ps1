# Run-Site.ps1 - The Grapes Website Starter
$ErrorActionPreference = "Continue"

Write-Host "==================================================" -ForegroundColor Cyan
Write-Host "         THE GRAPES - WEBSITE LAUNCHER            " -ForegroundColor Cyan
Write-Host "==================================================" -ForegroundColor Cyan
Write-Host ""

# 0. Clean up any leftover or zombie processes from previous runs
Stop-Process -Name "cloudflared" -Force -ErrorAction SilentlyContinue
Stop-Process -Name "php" -Force -ErrorAction SilentlyContinue

# 1. Check for vendor folder
$vendorAutoload = Join-Path $PSScriptRoot "vendor\autoload.php"
if (-not (Test-Path $vendorAutoload)) {
    Write-Host "[ERROR] The 'vendor' folder is missing!" -ForegroundColor Red
    Write-Host "Laravel requires the 'vendor' directory to run." -ForegroundColor Yellow
    Write-Host "Please extract 'git-missing-files.zip' into:" -ForegroundColor Yellow
    Write-Host "  $PSScriptRoot" -ForegroundColor Cyan
    Write-Host ""
    Read-Host "Press Enter to exit..."
    exit 1
}

# 2. Auto-patch AppServiceProvider.php and bootstrap/app.php to force HTTPS for tunnels
$appServiceProvider = Join-Path $PSScriptRoot "app\Providers\AppServiceProvider.php"
if (Test-Path $appServiceProvider) {
    $aspContent = Get-Content $appServiceProvider -Raw
    if ($aspContent -notmatch 'forceScheme') {
        Write-Host "[INFO] Configuring HTTPS styling in AppServiceProvider.php..." -ForegroundColor Yellow
        if ($aspContent -notmatch 'use Illuminate\\Support\\Facades\\URL;') {
            $aspContent = $aspContent -replace 'use Illuminate\\Support\\ServiceProvider;', "use Illuminate\Support\Facades\URL;`nuse Illuminate\Support\ServiceProvider;"
        }
        $aspContent = $aspContent -replace '(\$this->configureDefaults\(\);)', "`$1`n        if (request()->header('x-forwarded-proto') === 'https' || str_contains(request()->header('host', ''), 'trycloudflare.com')) { URL::forceScheme('https'); }"
        Set-Content -Path $appServiceProvider -Value $aspContent -Encoding UTF8
    }
}

$bootstrapApp = Join-Path $PSScriptRoot "bootstrap\app.php"
if (Test-Path $bootstrapApp) {
    $baContent = Get-Content $bootstrapApp -Raw
    if ($baContent -notmatch 'trustProxies') {
        Write-Host "[INFO] Enabling proxy trust in bootstrap/app.php..." -ForegroundColor Yellow
        $baContent = $baContent -replace '->withMiddleware\(function \(Middleware \$middleware\): void \{', "->withMiddleware(function (Middleware `$middleware): void {`n        `$middleware->trustProxies(at: '*');"
        Set-Content -Path $bootstrapApp -Value $baContent -Encoding UTF8
    }
}

# 3. Locate working PHP (checking F:, D:, C:, and all system drives)
$candidatePaths = @(
    "F:\xampp\php\php.exe",
    "F:\Xampp\php\php.exe",
    "D:\xampp\php\php.exe",
    "C:\xampp\php\php.exe",
    "C:\php\php.exe"
)

Get-PSDrive -PSProvider FileSystem -ErrorAction SilentlyContinue | ForEach-Object {
    $driveRoot = $_.Root
    $candidatePaths += (Join-Path $driveRoot "xampp\php\php.exe")
    $candidatePaths += (Join-Path $driveRoot "php\php.exe")
}

$phpCmd = Get-Command php -ErrorAction SilentlyContinue
if ($phpCmd) {
    $candidatePaths += $phpCmd.Source
}

$candidatePaths = $candidatePaths | Select-Object -Unique

$phpPath = $null
foreach ($path in $candidatePaths) {
    if (Test-Path $path) {
        $phpPath = $path
        break
    }
}

if (-not $phpPath) {
    Write-Host "[ERROR] PHP was not found on any drive!" -ForegroundColor Red
    Write-Host "Please check that XAMPP is installed (e.g. at F:\xampp)." -ForegroundColor Yellow
    Write-Host ""
    Read-Host "Press Enter to exit..."
    exit 1
}

Write-Host "[OK] Using PHP: $phpPath" -ForegroundColor Green

# 4. Automatically configure php.ini to match the actual XAMPP drive and directory
$phpDir = Split-Path $phpPath -Parent
$phpIni = Join-Path $phpDir "php.ini"

if (Test-Path $phpIni) {
    try {
        $xamppRoot = (Split-Path $phpDir -Parent).TrimEnd('\') + '\'
        $iniContent = Get-Content $phpIni -Raw -ErrorAction SilentlyContinue

        $pattern = '(?i)[A-Za-z]:\\xampp\\|(?<![A-Za-z]:)\\xampp\\'
        if ($iniContent -match $pattern) {
            Write-Host "[INFO] Adjusting php.ini paths to match your XAMPP location: $xamppRoot" -ForegroundColor Yellow
            $fixedContent = $iniContent -replace $pattern, $xamppRoot
            Set-Content -Path $phpIni -Value $fixedContent -Encoding UTF8
            Write-Host "[OK] php.ini successfully updated." -ForegroundColor Green
        }
    } catch {
        Write-Host "[WARN] Could not automatically update php.ini: $_" -ForegroundColor Yellow
    }
}

# 5. Check cloudflared.exe
$cloudflared = Join-Path $PSScriptRoot "cloudflared.exe"
if (-not (Test-Path $cloudflared)) {
    Write-Host "[INFO] Downloading cloudflared.exe..." -ForegroundColor Yellow
    Invoke-WebRequest -Uri "https://github.com/cloudflare/cloudflared/releases/latest/download/cloudflared-windows-amd64.exe" -OutFile $cloudflared
}

# 6. Start PHP Server explicitly on IPv4 127.0.0.1:8080
Write-Host "[INFO] Starting PHP server..." -ForegroundColor Cyan
$publicDir = Join-Path $PSScriptRoot "public"
$phpProcess = Start-Process -FilePath $phpPath -ArgumentList "-S 127.0.0.1:8080 -t `"$publicDir`"" -PassThru -NoNewWindow
Start-Sleep -Seconds 2

if ($phpProcess.HasExited) {
    Write-Host "[ERROR] PHP server stopped unexpectedly." -ForegroundColor Red
    $err = & $phpPath -v 2>&1 | Out-String
    Write-Host $err -ForegroundColor Red
    Read-Host "Press Enter to exit..."
    exit 1
}

Write-Host "[OK] PHP server is running on http://127.0.0.1:8080" -ForegroundColor Green

# 7. Start Cloudflare Tunnel pointing explicitly to http://127.0.0.1:8080
$uniqueId = [System.Guid]::NewGuid().ToString().Substring(0, 8)
$logFile = Join-Path $PSScriptRoot "tunnel_$uniqueId.log"

Write-Host "[INFO] Starting Cloudflare Tunnel..." -ForegroundColor Cyan
$tunnelProcess = Start-Process -FilePath $cloudflared -ArgumentList "tunnel --url http://127.0.0.1:8080 --logfile `"$logFile`"" -PassThru -NoNewWindow

# Wait for tunnel URL in log
$tunnelUrl = $null
$retries = 30
while ($retries -gt 0 -and -not $tunnelUrl) {
    Start-Sleep -Seconds 1
    if (Test-Path $logFile) {
        $content = Get-Content $logFile -Raw -ErrorAction SilentlyContinue
        if ($content -match '(https://[a-zA-Z0-9-]+\.trycloudflare\.com)') {
            $tunnelUrl = $matches[1]
        }
    }
    $retries--
}

Write-Host ""
if ($tunnelUrl) {
    Write-Host "==================================================" -ForegroundColor Green
    Write-Host "   WEBSITE IS NOW LIVE ONLINE!                    " -ForegroundColor Green
    Write-Host "==================================================" -ForegroundColor Green
    Write-Host ""
    Write-Host "   SHARE THIS URL WITH CLIENTS:                   " -ForegroundColor Yellow
    Write-Host "   $tunnelUrl" -ForegroundColor Cyan
    Write-Host ""
    Write-Host "==================================================" -ForegroundColor Green
    Write-Host "Note: It can take 15-30 seconds for DNS to propagate." -ForegroundColor Yellow
    Write-Host "Keep this window OPEN on this PC to stay online." -ForegroundColor Gray
    Write-Host "Press Ctrl+C to stop the server." -ForegroundColor Gray
} else {
    Write-Host "[WARNING] Tunnel started, but could not detect URL in log yet." -ForegroundColor Yellow
    Write-Host "Check $logFile for the live trycloudflare.com URL."
}

# Keep script running while processes are active
try {
    Wait-Process -Id $tunnelProcess.Id
} finally {
    Stop-Process -Id $phpProcess.Id -Force -ErrorAction SilentlyContinue
    Stop-Process -Id $tunnelProcess.Id -Force -ErrorAction SilentlyContinue
    Remove-Item $logFile -Force -ErrorAction SilentlyContinue
}
