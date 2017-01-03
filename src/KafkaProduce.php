<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2016/12/26
 * Time: 11:42.
 */

namespace xltxlm\kafka;

use RdKafka\Producer;
use xltxlm\kafka\Config\KafkaConfig;

/**
 * Kafka队列生产者
 * Class KafkaProduce.
 */
final class KafkaProduce
{
    /** @var string 发送的消息内容 */
    protected $message = '';
    /** @var KafkaConfig */
    protected $KafkaConfig;

    /**
     * @return KafkaConfig
     */
    public function getKafkaConfig(): KafkaConfig
    {
        return $this->KafkaConfig;
    }

    /**
     * @param KafkaConfig $KafkaConfig
     *
     * @return KafkaProduce
     */
    public function setKafkaConfig(KafkaConfig $KafkaConfig): KafkaProduce
    {
        $this->KafkaConfig = $KafkaConfig;

        return $this;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     *
     * @return KafkaProduce
     */
    public function setMessage(string $message): KafkaProduce
    {
        $this->message = $message;

        return $this;
    }

    public function __invoke()
    {
        $rk = new Producer();
        $rk->setLogLevel(LOG_DEBUG);
        $rk->addBrokers($this->getKafkaConfig()->getBrokers());
        $topic = $rk->newTopic($this->getKafkaConfig()->getTopic());
        $topic->produce(RD_KAFKA_PARTITION_UA, 0, $this->getMessage());
        $rk->poll(0);
        $rk->poll(1);
    }
}
