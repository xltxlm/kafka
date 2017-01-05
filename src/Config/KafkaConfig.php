<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2016/12/26
 * Time: 11:39.
 */

namespace xltxlm\kafka\Config;

use RdKafka\Consumer;
use RdKafka\Message;
use xltxlm\config\TestConfig;

abstract class KafkaConfig implements TestConfig
{
    /** @var string 服务器地址 */
    protected $brokers = '';
    protected $topic = '';

    /**
     * @return string
     */
    public function getTopic(): string
    {
        return $this->topic;
    }

    /**
     * @param string $topic
     *
     * @return $this
     */
    public function setTopic(string $topic)
    {
        $this->topic = $topic;

        return $this;
    }

    /**
     * @return string
     */
    final public function getBrokers(): string
    {
        return $this->brokers;
    }

    /**
     * @param string $brokers
     *
     * @return $this
     */
    final public function setBrokers(string $brokers)
    {
        $this->brokers = $brokers;

        return $this;
    }

    public function test()
    {
        $rk = new Consumer();
        $rk->setLogLevel(LOG_DEBUG);
        $rk->addBrokers($this->getBrokers());
        $topic = $rk->newTopic($this->getTopic());
        $topic->consumeStart(0, RD_KAFKA_OFFSET_BEGINNING);
        $msg = $topic->consume(0, 1000);
        if (!is_subclass_of($msg, Message::class)) {
            throw new \Exception("链接kafka服务失败.".$this->getBrokers());
        }
    }

}
