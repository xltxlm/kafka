<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2016/12/26
 * Time: 11:37.
 */

namespace xltxlm\kafka;

use RdKafka\Consumer;
use RdKafka\ConsumerTopic;
use RdKafka\TopicConf;
use xltxlm\kafka\Config\KafkaConfig;

/**
 * kafka 消费者
 * Class Kafka.
 */
final class KafkaConsumer
{
    /** @var  \RdKafka\Consumer */
    private $rk;
    /** @var KafkaConfig */
    protected $KafkaConfig;
    /** @var callable $CallFunction 获取消息之后的回调执行函数 */
    protected $CallBackFunction;

    /**
     * @return callable
     */
    public function getCallBackFunction(): callable
    {
        return $this->CallBackFunction;
    }

    /**
     * @param callable $CallBackFunction
     *
     * @return KafkaConsumer
     */
    public function setCallBackFunction(callable $CallBackFunction): KafkaConsumer
    {
        $this->CallBackFunction = $CallBackFunction;

        return $this;
    }

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
     * @return KafkaConsumer
     */
    public function setKafkaConfig(KafkaConfig $KafkaConfig): KafkaConsumer
    {
        $this->KafkaConfig = $KafkaConfig;

        return $this;
    }

    /**
     * @return ConsumerTopic
     */
    private function topic(): ConsumerTopic
    {

        $topicConf = new TopicConf();
        $topicConf->set('auto.commit.interval.ms', 1e3);
        $topicConf->set('offset.store.sync.interval.ms', 60e3);
        $this->rk = $this->getKafkaConfig()
            ->instanceSelfConsumer($topicConf);
        $topic = $this->rk->newTopic($this->getKafkaConfig()->getTopic());

        return $topic;
    }

    /**
     * 死循环读取数据,如果需要指定获取多少数据量,外部回调函数控制返回 false就可以.
     */
    public function __invoke()
    {
        $topic = $this->topic();
        //用队列集合多个partitions
        $queue = $this->rk->newQueue();
        /** @var \RdKafka\Metadata $metadata */
        $metadatas = $this->rk->metadata(false, $topic, 1000);

        /** @var \RdKafka\Metadata\Topic $topic */
        foreach ($metadatas->getTopics() as $topicMetadata) {
            /** @var \RdKafka\Metadata\Partition $partition */
            foreach ($topicMetadata->getPartitions() as $partition) {
                $topic->consumeQueueStart($partition->getId(), RD_KAFKA_OFFSET_STORED, $queue);
            }
        }


        while (true) {
            // The only argument is the timeout.
            $msg = $queue->consume(1000);
            if ($msg->err) {
            } else {
                if ($msg->payload) {
                    $continue = call_user_func($this->getCallBackFunction(), $msg);
                    if ($continue === false) {
                        break;
                    }
                }
            }
        }

    }
}
