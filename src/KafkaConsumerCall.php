<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2017/1/8
 * Time: 12:13.
 */

namespace xltxlm\kafka;

use RdKafka\Message;

/**
 * kafka客户端接口:接收内容信息
 * Interface KafkaConsumerCall.
 */
interface KafkaConsumerCall
{
    /**
     * @param Message $msg
     * @return bool
     */
    public function messageCallBack(Message $msg): bool;
}
