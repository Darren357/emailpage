::Started by Thunderbird with the Mailbox Alert add-on.
@echo off
cd C:\Darren\github\emailpage
for /f "tokens=*" %%a in ('time /t') do set time=%%a
for /f "tokens=2" %%a in ('date /t') do set date=%%a
set datetime=%date% %time%
if exist datetime.js del datetime.js
echo TargetDate="%datetime%";>datetime.js
timeout /t 1 >nul
git add datetime.js
git commit -m "Beep Boop"
git push origin gh-pages
runas /user:# "" >nul 2>&1 |(echo I've updated your website for you. &echo. &echo  [Enter]- "Okay MailBot301")