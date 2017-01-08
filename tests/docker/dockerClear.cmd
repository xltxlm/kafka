rem 危险：相当于重装docker系统

docker ps -a -q >dockertmp.txt
for /F  %%i IN (dockertmp.txt) DO @docker  rm -f %%i

docker images | findstr "none"  | awk "{print $3}" >dockertmp.txt
for /F  %%i IN (dockertmp.txt) DO @docker  rmi -f %%i

del dockertmp.txt
exit