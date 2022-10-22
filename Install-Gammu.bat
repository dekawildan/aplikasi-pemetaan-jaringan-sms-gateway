@echo off
cd Gammu\bin
gammu identify
gammu-smsd.exe -c smsdrc -i
pause
start run-sms.bat
