@echo off
cd "C:\XAMPP\"
start apache\bin\httpd.exe
start mysql\bin\mysqld.exe
cd "c:\Program Files\Mozilla Firefox\"
start firefox.exe http://localhost/sistem-pemetaan-jaringan/