@echo off
chcp 65001 >nul
setlocal ENABLEDELAYEDEXPANSION
cls

:: ====== EXPORT FOLDER STRUCTURE ======
cd /d "%~dp0"
set "OUTPUT=CauTrucThuMuc_structure.txt"

echo.
echo 📁 Đang quét cấu trúc thư mục dự án...
echo (Lưu vào: %OUTPUT%)
echo.

(
    echo ==============================================
    echo   PROJECT STRUCTURE EXPORT
    echo   Thời gian: %date% %time%
    echo   Máy tính: %COMPUTERNAME%
    echo   Người dùng: %USERNAME%
    echo ==============================================
    echo.
) > "%OUTPUT%"

:: Xuất cấu trúc thư mục (TREE hỗ trợ Unicode)
tree /f /a >> "%OUTPUT%"

echo ✅ Hoàn tất! Cấu trúc đã được lưu vào "%OUTPUT%".
pause >nul
endlocal
