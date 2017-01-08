<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2017/1/4
 * Time: 18:05.
 */

namespace xltxlm\kafka\tests;

use PHPUnit\Framework\TestCase;

class ConfigTest extends TestCase
{
    /**
     * 测试度武器是否能链接上去.
     */
    public function testConfig()
    {
        (new KafkaConfig())
            ->test();
    }
}
