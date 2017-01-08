<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2016/12/25
 * Time: 11:56.
 */
declare(ticks = 1);

namespace kuaigeng\review\Crontab;

use PHPUnit\Framework\TestCase;
use RdKafka\Message;
use xltxlm\kafka\KafkaConsumer;
use xltxlm\kafka\KafkaConsumerCall;
use xltxlm\kafka\tests\KafkaConfig;

class ConsumeKafkaTest extends TestCase implements KafkaConsumerCall
{
    private static $i = 0;

    /**
     * @param Message $msg
     *
     * @return bool
     */
    public function messageCallBack(Message $msg): bool
    {
        if ($msg->err) {
            return false;
        }
        print_r($msg->payload);
        echo "\n";
        self::$i++;
        return true;
    }

    /**
     * 死循环读取信息.
     *
     * @test
     */
    public function testrun()
    {
        (new KafkaConsumer())
            ->setKafkaConfig(new KafkaConfig())
            ->setCallBackObject($this)
            ->__invoke();
        $this->assertEquals(10, self::$i);
    }
}
