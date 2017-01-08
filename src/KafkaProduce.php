<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2016/12/26
 * Time: 11:42.
 */

namespace xltxlm\kafka;

use Psr\Log\LogLevel;
use xltxlm\kafka\Config\KafkaConfig;
use xltxlm\logger\Log\BasicLog;

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
        $start = microtime(true);
        $topic = $this->getKafkaConfig()->instanceSelfProduct();
        $topic->produce(RD_KAFKA_PARTITION_UA, 0, $this->getMessage());
        $time = sprintf('%.4f', microtime(true) - $start);
        //执行时间过长
        if ($time > 0.3) {
            (new BasicLog)
                ->setMessage("kafka 发送时间过长:".$this->getKafkaConfig()->getBrokers().',topic:'.$this->getKafkaConfig()->getTopic())
                ->setType(LogLevel::EMERGENCY);
        }
    }
}
