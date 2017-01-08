cd %~pd0
docker build  -t phprun:latest ./php
docker build  -t zookeeperrun:latest ./zookeeper
docker build  -t kafkarun:latest ./kafka
