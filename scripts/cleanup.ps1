Param(
    [switch]$DryRun = $true
)

$ErrorActionPreference = "Stop"
$root = Split-Path -Parent $MyInvocation.MyCommand.Path | Split-Path -Parent

$targets = @(
    "_archived",
    "sample_csvs",
    "node",
    "tests",
    ".github",
    ".vscode",
    "docs",
    "scripts/tmp"
) | ForEach-Object { Join-Path $root $_ }

Write-Host "Cleanup targets:" -ForegroundColor Cyan
$targets | ForEach-Object {
    if (Test-Path $_) { Write-Host "  - $_" } else { Write-Host "  - $_ (missing)" -ForegroundColor DarkGray }
}

if ($DryRun) {
    Write-Host "Dry run: no files will be deleted. Re-run with -DryRun:$false to perform deletion." -ForegroundColor Yellow
    exit 0
}

foreach ($path in $targets) {
    if (Test-Path $path) {
        Write-Host "Removing $path" -ForegroundColor Red
        try {
            Remove-Item -LiteralPath $path -Recurse -Force -ErrorAction Stop
        }
        catch {
            Write-Warning "Failed to remove $path: $_"
        }
    }
}

Write-Host "Cleanup completed." -ForegroundColor Green
