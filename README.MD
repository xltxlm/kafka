#安装

#用法

+ docker重启,原先的数据不存在,window下,把log.dirs=/tmp/kafka-logs 迁移到宿主机,失败 [NO]
+ kafka可以无限动态添加个数,只要zookeeper不变就可以 [ok]
+ 重启[需要重启多次,等zookeeper过时],topic的配置还存在