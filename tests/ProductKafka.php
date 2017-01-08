<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2016/12/22
 * Time: 13:06.
 */
declare(ticks = 1);

namespace kuaigeng\review\Crontab;

use kuaigeng\review\Config\Kafka;
use RdKafka\Producer;
use xltxlm\crontab\CrontabLock;

include_once __DIR__.'/../vendor/autoload.php';

/**
 * 测试制造消息
 * Class MakeKafka.
 */
final class ProductKafka
{
    use CrontabLock;

    public function __invoke()
    {
        $topic = (new Kafka())
            ->instanceSelfProduct();
        $i = 1;
        while ($i <= 10) {
            $message = 'ProductKafka:'.$i;
            $topic->produce(RD_KAFKA_PARTITION_UA, 0, $message);
            echo $message."\n";
            $i++;
        }
    }
}

(new ProductKafka())();
