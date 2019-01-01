Set oShell = CreateObject ("Wscript.Shell") 
Dim strArgs
strArgs = "cmd /c C:\xampp\htdocs\sium\clus.bat"
oShell.Run strArgs, 0, false