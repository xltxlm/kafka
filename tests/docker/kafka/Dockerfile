FROM openjdk:latest
COPY deb.list /etc/apt/sources.list
COPY / /root/

RUN     cp /usr/share/zoneinfo/Asia/Shanghai /etc/localtime \
        && rm -f /etc/apt/sources.list.d/* \
        && cd /root/ && tar -xzf /root/kafka_2.11-0.10.1.0.tgz  && mv /root/kafka_2.11-0.10.1.0 /usr/local/kafka \
        && rm -f  /usr/local/kafka/config/server.properties && ln -snf /opt/kafka/server.properties   /usr/local/kafka/config/server.properties

EXPOSE 9092
WORKDIR /usr/local/kafka
CMD cd /usr/local/kafka  && bin/kafka-server-start.sh config/server.properties
