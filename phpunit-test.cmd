cd  %~pd0
docker exec -it docker_kafka_1 bin/kafka-topics.sh --delete --zookeeper zookeeper1:2181  --topic PHPTest
docker exec -it docker_kafka_1 bin/kafka-topics.sh --create --zookeeper zookeeper1:2181 --replication-factor 2 --partitions 2 --topic PHPTest
docker exec -it docker_php_1 phpunit tests/ConfigTest.php
docker exec -it docker_php_1 phpunit tests/ProductKafkaTest.php
docker exec -it docker_php_1 bash -c "rm -f *.offset"
docker exec -it docker_php_1 phpunit tests/ConsumeKafkaTest.php
docker exec -it docker_php_1 bash -c "rm -f *.offset"
exit