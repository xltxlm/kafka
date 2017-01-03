<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2016/12/26
 * Time: 11:39.
 */

namespace xltxlm\kafka\Config;

abstract class KafkaConfig
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
}
