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

use QingStor\SDK\Builder;
use QingStor\SDK\Config;
use PHPUnit\Framework\TestCase;

class BuilderTest extends TestCase
{
    private $testBuilder;
    private $testOperation;
    private $testConfig;

    public function setUp()
    {
        $this->testConfig = new Config();
        $this->testConfig->loadConfigFromData(
            array(
                'access_key_id' => 'ACCESS_KEY_ID',
                'secret_access_key' => 'SECRET_ACCESS_KEY',
                'host' => 'qingstor.com',
                'port' => 443,
                'protocol' => 'https',
                'connection_retries' => 3,
                'log_level' => 'warn',
            )
        );
        $this->testOperation = array(
            'Method' => 'GET',
            'Uri' => '/<bucket-name>/<object-key>',
            'Headers' => array(
                'Host' => 'pek3a.qingstor.com',
                'Date' => 'Wed, 10 Dec 2014 17:20:31 GMT',
                'test_empty_header' => '',
            ),
            'Params' => array(
                'test_params_1' => 'test_val',
                'test_params_2' => 'test_val',
                'test_params_empty' => '',
            ),
            'Elements' => array(
                'test_elements_1' => 'test_val',
                'test_elements_2' => 'test_val',
                'test_elements_empty' => '',
            ),
            'Properties' => array(
                'zone' => 'pek3a',
                'bucket-name' => 'test_bucket',
                'object-key' => 'test_object',
            ),
            'Body' => null,
        );
        $this->testBuilder = new Builder\QingStor($this->testConfig, $this->testOperation);
    }

    public function test_parseRequestParams()
    {
        $this->testBuilder->parseRequestParams();

        $this->assertEquals(
            array(
                'test_params_1' => 'test_val',
                'test_params_2' => 'test_val',
            ),
            $this->testBuilder->parsedParams
        );
    }

    public function test_parseRequestHeaders()
    {
        $this->testBuilder->parseRequestHeaders();
        $this->assertEquals(
            array(
                'Host' => 'pek3a.qingstor.com',
                'Date' => 'Wed, 10 Dec 2014 17:20:31 GMT',
                'User-Agent' => 'qingstor-sdk-php/2.0.0-alpha.0  (PHP v7.0.13-0ubuntu0.16.04.1; Linux)',
            ),
            $this->testBuilder->parsedHeaders
        );
    }

    public function test_parseRequestBody()
    {
        $this->testBuilder->parseRequestBody();

        $this->assertEquals(
            '{"test_elements_1":"test_val","test_elements_2":"test_val","test_elements_empty":""}',
            $this->testBuilder->parsedBody
        );
    }

    public function test_parseRequestProperties()
    {
        $this->testBuilder->parseRequestProperties();

        $this->assertEquals(
            array(
                'zone' => 'pek3a',
                'bucket-name' => 'test_bucket',
                'object-key' => 'test_object',
            ),
            $this->testBuilder->parsedProperties
        );
    }

    public function test_parseRequestURL()
    {
        $this->testBuilder->parseRequestProperties();
        $this->testBuilder->parseRequestURL();

        $this->assertEquals(
            'https://pek3a.qingstor.com:443/test_bucket/test_object',
            $this->testBuilder->parsedURL
        );
    }
}
