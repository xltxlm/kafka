<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-01-08
 * Time: 下午 8:50.
 */

namespace xltxlm\kafka\Logger;

use xltxlm\logger\Log\DefineLog;

/**
 * 链接日志
 * Class Connect.
 */
abstract class ConnectLogger extends DefineLog
{
    protected $brokers = '';
    protected $topic = '';

    /**
     * @return string
     */
    public function getBrokers(): string
    {
        return $this->brokers;
    }

    /**
     * @param string $brokers
     *
     * @return ConnectLogger
     */
    public function setBrokers(string $brokers): ConnectLogger
    {
        $this->brokers = $brokers;

        return $this;
    }

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
     * @return ConnectLogger
     */
    public function setTopic(string $topic): ConnectLogger
    {
        $this->topic = $topic;

        return $this;
    }
}
