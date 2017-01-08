FROM openjdk:latest
COPY deb.list /etc/apt/sources.list
COPY / /root/

RUN     cp /usr/share/zoneinfo/Asia/Shanghai /etc/localtime \
        && rm -f /etc/apt/sources.list.d/* \
        && cd /root/ && tar -xzf /root/zookeeper-3.4.9.tar.gz  && mv /root/zookeeper-3.4.9 /usr/local/zookeeper \
        && ln -snf  /opt/zookeeper/zoo.cfg  /usr/local/zookeeper/conf/zoo.cfg

EXPOSE 2181
WORKDIR /usr/local/zookeeper
CMD /usr/local/zookeeper/bin/zkServer.sh start && tail -f /etc/issue
