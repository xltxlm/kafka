<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2016/12/25
 * Time: 11:56.
 */
declare(ticks = 1);

namespace kuaigeng\review\Crontab;

use kuaigeng\review\Config\Kafka;
use RdKafka\Message;
use xltxlm\kafka\KafkaConsumer;
use xltxlm\kafka\KafkaConsumerCall;

include_once __DIR__.'/../vendor/autoload.php';

class ConsumeKafka implements KafkaConsumerCall
{
    /**
     * @param Message $msg
     *
     * @return bool
     */
    public function callBack(Message $msg): bool
    {
        if ($msg->err) {
            return true;
        }
        print_r($msg->payload);
        echo "\n";

        return true;
    }

    public function __invoke()
    {
        (new KafkaConsumer())
            ->setKafkaConfig(new Kafka())
            ->setCallBackObject([$this, 'call'])
            ->__invoke();
    }
}

(new ConsumeKafka())();
