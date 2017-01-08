cd %~pd0
docker  exec -it docker_kafka_1 bash

rem 创建一个topic:test
rem bin/kafka-topics.sh --create --zookeeper zookeeper1:2181 --replication-factor 2 --partitions 2 --topic test
rem 查看服务上有多少topic
rem bin/kafka-topics.sh --list --zookeeper zookeeper1:2181
rem 查看test topic的详细信息
rem bin/kafka-topics.sh --describe --zookeeper zookeeper1:2181 --topic test

rem 1:生产消息
rem bin/kafka-console-producer.sh --broker-list localhost:9092 --topic test </etc/issue

rem 2:消费消息
rem bin/kafka-console-consumer.sh --bootstrap-server kafka1:9092 --topic test --from-beginning

rem 关闭服务
rem bin/kafka-server-stop.sh

rem 查看当前活着的节点
rem bin/zookeeper-shell.sh zookeeper1:2181 <<< "ls /brokers/ids"