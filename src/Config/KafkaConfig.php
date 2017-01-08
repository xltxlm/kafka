<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2016/12/26
 * Time: 11:39.
 */

namespace xltxlm\kafka\Config;

use RdKafka\Consumer;
use RdKafka\Metadata;
use RdKafka\Producer;
use RdKafka\ProducerTopic;
use xltxlm\config\TestConfig;

abstract class KafkaConfig implements TestConfig
{
    /** @var string 服务器地址 */
    protected $brokers = '';
    protected $topic = '';

    /** @var array 确保一个进程相同配置只能链接一次 */
    private static $instance = [];

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

    /**
     * 返回链接,重新链接.
     *
     * @return ProducerTopic
     */
    private function instanceProduct()
    {
        $rk = new Producer();
        $rk->setLogLevel(LOG_DEBUG);
        $rk->addBrokers($this->getBrokers());
        /** @var ProducerTopic $topic */
        $topic = $rk->newTopic($this->getTopic());

        return $topic;
    }

    /**
     * 返回生产者链接,单例.
     *
     * @return ProducerTopic
     */
    final public function instanceSelfProduct()
    {
        $kafka = $this->getBrokers() . $this->getTopic();
        if (!self::$instance[$kafka]) {
            self::$instance[$kafka] = $this->instanceProduct();
        }

        return self::$instance[$kafka];
    }

    /**
     * 返回链接,重新链接.
     *
     * @return \RdKafka\Consumer
     */
    private function instanceConsumerRk()
    {
        $rk = new Consumer();
        $rk->setLogLevel(LOG_DEBUG);
        $rk->addBrokers($this->getBrokers());
        return $rk;
    }

    /**
     * 返回消费者链接,单例.
     * @return \RdKafka\Consumer
     */
    final public function instanceSelfConsumer()
    {
        $kafka = $this->getBrokers() . $this->getTopic();
        if (!self::$instance[$kafka]) {
            self::$instance[$kafka] = $this->instanceConsumerRk();
        }

        return self::$instance[$kafka];
    }

    /**
     * @return Metadata
     */
    public function test()
    {
        $rk = $this->instanceSelfConsumer();
        $topic = $rk->newTopic($this->getTopic());
        /** @var Metadata $metadata */
        return $rk->getMetadata(false, $topic, 1000);
    }
}
