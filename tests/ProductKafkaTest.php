<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2016/12/22
 * Time: 13:06.
 */
declare(ticks = 1);

namespace kuaigeng\review\Crontab;

use PHPUnit\Framework\TestCase;
use xltxlm\kafka\KafkaProduce;
use xltxlm\kafka\tests\KafkaConfig;

/**
 * 测试制造消息
 * Class MakeKafka.
 */
final class ProductKafkaTest extends TestCase
{
    /**
     * @test
     */
    public function testProduce()
    {
        $i = 1;
        while ($i <= 10) {
            $message = 'ProductKafka:' . $i;
            (new KafkaProduce())
                ->setKafkaConfig(new KafkaConfig())
                ->setMessage($message)
                ->__invoke();
            echo $message . "\n";
            $i++;
        }
    }
}
