@ECHO OFF
setlocal DISABLEDELAYEDEXPANSION
SET BIN_TARGET=%~dp0/../gettext/languages/bin/import-cldr-data
php "%BIN_TARGET%" %*
