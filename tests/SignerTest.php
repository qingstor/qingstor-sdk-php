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

use QingStor\SDK\Signer;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Psr7\Request;

class SignerTest extends TestCase
{
    private $testRequest;
    private $testSigner;
    private $testKeyid;
    private $testKeysecret;

    public function setUp()
    {
        $this->testKeyid = 'QYACCESSKEYIDEXAMPLE';
        $this->testKeysecret = 'SECRETACCESSKEY';
        $this->testRequest = new Request(
            'PUT',
            '/mybucket/photo.jpeg?acl=d&a=b&e=f&uploads',
            [
                'Content-MD5' => '4gJE4saaMU4BqNR0kLY+lw==',
                'Content-Type' => 'image/jpeg',
                'Date' => 'Wed, 10 Dec 2014 17:20:31 GMT',
                'x-qs-date' => 'Wed, 10 Dec 2014 17:20:31 GMT',
                'x-qs-copy-source' => '/mybucket/music.mp3',
            ]
        );
        $this->testSigner = new Signer(
            $this->testRequest,
            $this->testKeyid,
            $this->testKeysecret
        );
    }

    public function test_getContentMD5()
    {
        $this->assertEquals(
            '4gJE4saaMU4BqNR0kLY+lw==',
            $this->testSigner->getContentMD5()
        );
    }

    public function test_getContentType()
    {
        $this->assertEquals(
            'image/jpeg',
            $this->testSigner->getContentType()
        );
    }

    public function test_getDate()
    {
        $this->assertEquals(
            'Wed, 10 Dec 2014 17:20:31 GMT',
            $this->testSigner->getDate()
        );
    }

    public function test_getCanonicalizedHeaders()
    {
        $this->assertEquals(
            "x-qs-copy-source:/mybucket/music.mp3\nx-qs-date:Wed, 10 Dec 2014 17:20:31 GMT\n",
            $this->testSigner->getCanonicalizedHeaders()
        );
    }

    public function test_getCanonicalizedResource()
    {
        $this->assertEquals(
            '/mybucket/photo.jpeg?acl=d&uploads',
            $this->testSigner->getCanonicalizedResource()
        );
    }

    public function test_getAuthorization()
    {
        $this->assertEquals(
            '11CbEGeL5QmOgmk5qXF86QzhFC0B1HKa+onubF7dPaw=',
            $this->testSigner->getAuthorization()
        );
    }
}
