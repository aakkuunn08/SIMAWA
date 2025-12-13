@echo off
echo Clearing all Laravel caches...
echo.

echo [1/6] Clearing application cache...
C:\laragon\bin\php\php-8.2.12-Win32-vs16-x64\php artisan cache:clear

echo [2/6] Clearing route cache...
C:\laragon\bin\php\php-8.2.12-Win32-vs16-x64\php artisan route:clear

echo [3/6] Clearing config cache...
C:\laragon\bin\php\php-8.2.12-Win32-vs16-x64\php artisan config:clear

echo [4/6] Clearing view cache...
C:\laragon\bin\php\php-8.2.12-Win32-vs16-x64\php artisan view:clear

echo [5/6] Clearing permission cache (Spatie)...
C:\laragon\bin\php\php-8.2.12-Win32-vs16-x64\php artisan permission:cache-reset

echo [6/6] Optimizing application...
C:\laragon\bin\php\php-8.2.12-Win32-vs16-x64\php artisan optimize:clear

echo.
echo ========================================
echo All caches cleared successfully!
echo ========================================
echo.
pause
