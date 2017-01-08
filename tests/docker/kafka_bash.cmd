cd %~pd0
docker  exec -it docker_kafka_1 bash

rem bin/kafka-topics.sh --create --zookeeper zookeeper1:2181 --replication-factor 1 --partitions 2 --topic test
rem 查看服务上有多少topic
rem bin/kafka-topics.sh --list --zookeeper zookeeper1:2181
rem bin/kafka-topics.sh --describe --zookeeper zookeeper1:2181 --topic test

rem 生产消息
rem bin/kafka-console-producer.sh --broker-list localhost:9092 --topic test

rem 查看内容
rem bin/kafka-console-consumer.sh --bootstrap-server kafka1:9092 --topic test --from-beginning
