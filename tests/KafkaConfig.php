<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2017/1/5
 * Time: 9:23
 */

namespace xltxlm\kafka\tests;


class KafkaConfig extends \xltxlm\kafka\Config\KafkaConfig
{
    protected $brokers = "kafka01,kafka02,kafka03";
    protected $topic = "PHPTest";
}