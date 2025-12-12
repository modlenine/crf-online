# PowerShell script to replace 'exit;' with 'return;' in addth.js
$filePath = "c:\xampp\htdocs\intsys\crf\assets\js\addth.js"

# Read the file content
$content = Get-Content -Path $filePath -Raw -Encoding UTF8

# Replace exit; with return; (with proper tabs)
$content = $content -replace '\t+exit;', "`treturn;"

# Write back to file
Set-Content -Path $filePath -Value $content -Encoding UTF8 -NoNewline

Write-Host "Successfully replaced all 'exit;' with 'return;' in addth.js" -ForegroundColor Green
