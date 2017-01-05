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
    protected $brokers = "xxx";
    protected $topic = "PHPTest";
}