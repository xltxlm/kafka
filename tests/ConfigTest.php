<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2017/1/4
 * Time: 18:05
 */

namespace xltxlm\kafka\tests;


include __DIR__."/../vendor/autoload.php";
(new KafkaConfig)
    ->test();