<?php
// +-------------------------------------------------------------------------
// | Copyright (C) 2016 Yunify, Inc.
// +-------------------------------------------------------------------------
// | Licensed under the Apache License, Version 2.0 (the "License");
// | you may not use this work except in compliance with the License.
// | You may obtain a copy of the License in the LICENSE file, or at:
// |
// | http://www.apache.org/licenses/LICENSE-2.0
// |
// | Unless required by applicable law or agreed to in writing, software
// | distributed under the License is distributed on an "AS IS" BASIS,
// | WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
// | See the License for the specific language governing permissions and
// | limitations under the License.
// +-------------------------------------------------------------------------

namespace QingStor\SDK\Test;

use QingStor\SDK\Config;
use PHPUnit\Framework\TestCase;

class ConfigTest extends TestCase
{
    private $testConfig;

    public function setUp()
    {
        $this->testConfig = new Config();
    }

    public function test_loadConfigFromData()
    {
        $configData = array(
            'access_key_id' => 'ACCESS_KEY_ID',
            'secret_access_key' => 'SECRET_ACCESS_KEY',
            'host' => 'qingstor.com',
            'port' => 443,
            'protocol' => 'https',
            'connection_retries' => 3,
            'log_level' => 'warn',
        );

        $this->testConfig->loadConfigFromData($configData);

        $this->assertEquals('ACCESS_KEY_ID', $this->testConfig->access_key_id);
        $this->assertEquals('SECRET_ACCESS_KEY', $this->testConfig->secret_access_key);
        $this->assertEquals('qingstor.com', $this->testConfig->host);
        $this->assertEquals(443, $this->testConfig->port);
        $this->assertEquals('https', $this->testConfig->protocol);
        $this->assertEquals(3, $this->testConfig->connection_retries);
        $this->assertEquals('warn', $this->testConfig->log_level);
    }
}
