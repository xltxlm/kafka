<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2016/12/26
 * Time: 11:37.
 */

namespace xltxlm\kafka;

use RdKafka\ConsumerTopic;
use RdKafka\Message;
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
    /** @var KafkaConsumerCall $CallFunction 获取消息之后的回调执行函数 */
    protected $CallBackObject;

    /**
     * @return KafkaConsumerCall
     */
    public function getCallBackObject()
    {
        return $this->CallBackObject;
    }

    /**
     * @param KafkaConsumerCall $CallBackObject
     *
     * @return KafkaConsumer
     */
    public function setCallBackObject(KafkaConsumerCall $CallBackObject): KafkaConsumer
    {
        $this->CallBackObject = $CallBackObject;

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
        $topicConf->set('offset.store.method', 'file');
        $topicConf->set('auto.offset.reset', 'smallest');
        $this->rk = $this->getKafkaConfig()
            ->instanceSelfConsumer();
        $topic = $this->rk->newTopic($this->getKafkaConfig()->getTopic(), $topicConf);

        return $topic;
    }

    /**
     * 死循环读取数据,直到最后一个数据,退出循环
     */
    public function __invoke()
    {
        $topic = $this->topic();

        //用队列集合多个partitions
        $queue = $this->rk->newQueue();
        /** @var \RdKafka\Metadata $metadata */
        $metadatas = $this->rk->getMetadata(false, $topic, 1000);

        /** @var \RdKafka\Metadata\Topic $topic */
        foreach ($metadatas->getTopics() as $topicMetadata) {
            /** @var \RdKafka\Metadata\Partition $partition */
            foreach ($topicMetadata->getPartitions() as $partition) {
                $topic->consumeQueueStart($partition->getId(), RD_KAFKA_OFFSET_STORED, $queue);
            }
        }
        while (true) {
            // The only argument is the timeout.
            $message = $queue->consume(1000);
            if (get_class($message) != Message::class) {
                continue;
            }
            $continue = call_user_func([$this->getCallBackObject(), 'messageCallBack'], $message);
            if (!$continue) {
                break;
            }
        }

    }
}
