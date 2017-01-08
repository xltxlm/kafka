cd %~pd0
docker  exec -it docker_zookeeper_1 bash

rem docker exec  -it docker_zookeeper_1 bash
rem docker exec  -it docker_zookeeper_1 bin/zkCli.sh -server 127.0.0.1:2181
rem 查看服务状态
rem docker exec  -i docker_zookeeper_1 bin/zkServer.sh status
