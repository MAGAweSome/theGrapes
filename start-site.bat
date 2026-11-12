@echo off
title The Grapes - Website Host
cd /d "%~dp0"

echo ==================================================
echo          THE GRAPES - WEBSITE LAUNCHER
echo ==================================================
echo.

:: 1. Kill any existing PHP or Cloudflare processes
taskkill /f /im php.exe >nul 2>nul
taskkill /f /im cloudflared.exe >nul 2>nul

:: 2. Locate PHP
set "PHP="
if exist "F:\xampp\php\php.exe" set "PHP=F:\xampp\php\php.exe"
if not defined PHP if exist "F:\Xampp\php\php.exe" set "PHP=F:\Xampp\php\php.exe"
if not defined PHP if exist "C:\xampp\php\php.exe" set "PHP=C:\xampp\php\php.exe"
if not defined PHP if exist "D:\xampp\php\php.exe" set "PHP=D:\xampp\php\php.exe"
if not defined PHP (
    for %%X in (php.exe) do (set "PHP=%%~$PATH:X")
)

if not defined PHP (
    echo [ERROR] PHP was not found!
    echo Please make sure XAMPP is installed at F:\xampp or C:\xampp.
    pause
    exit /b 1
)

echo [OK] Using PHP: %PHP%

:: 3. Check public folder
if not exist "%~dp0public" (
    echo [ERROR] Could not find the 'public' folder in:
    echo %~dp0
    pause
    exit /b 1
)

:: 4. Start PHP Server in a dedicated visible window so errors are never hidden
echo [INFO] Starting PHP Server window...
start "The Grapes - PHP Web Server" cmd /k "cd /d "%~dp0" && "%PHP%" -S 127.0.0.1:8080 -t "%~dp0public""

:: Give PHP 2 seconds to bind port
ping 127.0.0.1 -n 3 >nul

:: 5. Start Cloudflare Tunnel
echo [INFO] Starting Cloudflare Tunnel...
echo.
echo ==================================================
echo   LOOK BELOW FOR YOUR LIVE URL (trycloudflare.com)
echo ==================================================
echo.
"%~dp0cloudflared.exe" tunnel --url http://127.0.0.1:8080

pause
