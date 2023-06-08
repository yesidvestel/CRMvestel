set direccion=localhost
set usuario=root
set base_datos=crm
set pass=tVsur@2019*
mysqldump.exe -h%direccion% -u%usuario% -p%pass% %base_datos% > E:\backupsMYDIC\Copia_de_seguridad_%base_datos%_%date:~-4,4%-%date:~-7,2%-%date:~-10,2%_%time:~0,2%-%time:~3,2%-%time:~6,2%.sql