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

use Behat\Behat\Context\Context;
use QingStor\SDK\Service\QingStor;
use QingStor\SDK\Config;
use PHPUnit_Framework_Assert as PHPUnit;
use Behat\Behat\Hook\Scope\BeforeFeatureScope;
use Behat\Behat\Hook\Scope\AfterFeatureScope;

/**
 * Defines application features from the specific context.
 */
class ObjectContext implements Context
{
    public static $test_bucket;

    public function __construct()
    {
        $this->test_config = spyc_load_file('test_config.yaml');
        $this->config = new Config();
        $this->test_service = new QingStor(
            $this->config,
            'pek3a'
        );
        self::$test_bucket = $this->test_service->Bucket($this->test_config['bucket_name'], 'pek3a');
    }

    // ----------------------------------------------------------------------------

    /** @BeforeFeature */
    public static function setupFeature(BeforeFeatureScope $scope)
    {
        $config = new Config();
        $test_config = spyc_load_file('test_config.yaml');
        $test_service = new QingStor(
            $config,
            'pek3a'
        );
        $test_bucket = $test_service->Bucket($test_config['bucket_name'], 'pek3a');
        $test_bucket->put();
    }

    /** @AfterFeature */
    public static function teardownFeature(AfterFeatureScope $scope)
    {
        $config = new Config();
        $test_config = spyc_load_file('test_config.yaml');
        $test_service = new QingStor(
            $config,
            'pek3a'
        );
        $test_bucket = $test_service->Bucket($test_config['bucket_name'], 'pek3a');
        $test_bucket->delete();
    }

    // ----------------------------------------------------------------------------

    /**
     * @When put object with key :arg1
     */
    public function putObjectWithKey($arg1)
    {
        exec('dd if=/dev/zero of=/tmp/sdk_bin bs=1048576 count=1');
        $this->res = self::$test_bucket->putObject(
            $arg1,
            array(
                'body' => file_get_contents('/tmp/sdk_bin'),
            )
        );
        exec('rm -f /tmp/sdk_bin');
    }

    /**
     * @Then put object status code is :arg1
     */
    public function putObjectStatusCodeIs($arg1)
    {
        PHPUnit::assertEquals($arg1, $this->res->getStatusCode());
    }

    /**
     * @When copy object with key :arg1
     */
    public function copyObjectWithKey($arg1)
    {
        $this->res = self::$test_bucket->putObject(
            "$arg1",
            array(
                'x_qs_copy_source' => '/'.$this->test_config['bucket_name'].'/'.'test_object',
            )
        );
    }

    /**
     * @Then copy object status code is :arg1
     */
    public function copyObjectStatusCodeIs($arg1)
    {
        PHPUnit::assertEquals($arg1, $this->res->getStatusCode());
    }

    /**
     * @When move object with key :arg1
     */
    public function moveObjectWithKey($arg1)
    {
        $this->res = self::$test_bucket->putObject(
            $arg1,
            array(
                'x_qs_move_source' => '/'.$this->test_config['bucket_name'].'/'.'test_copy_object',
            )
        );
    }

    /**
     * @Then move object status code is :arg1
     */
    public function moveObjectStatusCodeIs($arg1)
    {
        PHPUnit::assertEquals($arg1, $this->res->getStatusCode());
    }

    /**
     * @When get object
     */
    public function getObject()
    {
        $this->res = self::$test_bucket->getObject(
            'test_object'
        );
    }

    /**
     * @Then get object status code is :arg1
     */
    public function getObjectStatusCodeIs($arg1)
    {
        PHPUnit::assertEquals($arg1, $this->res->getStatusCode());
    }

    /**
     * @Then get object content length is :arg1
     */
    public function getObjectContentLengthIs($arg1)
    {
        PHPUnit::assertEquals($arg1, strlen($this->res->getBody()));
    }

    /**
     * @When get object with query signature
     */
    public function getObjectWithQuerySignature()
    {
        $client = new \GuzzleHttp\Client();
        $req = self::$test_bucket->getObjectQuery(
            'test_object',
            time() + 10
        );
        $this->res = $client->send($req);
    }

    /**
     * @Then get object with query signature content length is :arg1
     */
    public function getObjectWithQuerySignatureContentLengthIs($arg1)
    {
        PHPUnit::assertEquals($arg1, strlen($this->res->getBody()));
    }

    /**
     * @When head object
     */
    public function headObject()
    {
        $this->res = self::$test_bucket->headObject('test_object');
    }

    /**
     * @Then head object status code is :arg1
     */
    public function headObjectStatusCodeIs($arg1)
    {
        PHPUnit::assertEquals($arg1, $this->res->getStatusCode());
    }

    /**
     * @When options object with method :arg1 and origin :arg2
     */
    public function optionsObjectWithMethodAndOrigin($arg1, $arg2)
    {
        $this->res = self::$test_bucket->optionsObject(
            'test_object',
            array(
                'Access-Control-Request-Method' => $arg1,
                'Origin' => $arg2,
            )
        );
    }

    /**
     * @Then options object status code is :arg1
     */
    public function optionsObjectStatusCodeIs($arg1)
    {
        PHPUnit::assertEquals($arg1, $this->res->getStatusCode());
    }

    /**
     * @When delete object
     */
    public function deleteObject()
    {
        $this->res = self::$test_bucket->deleteObject('test_object');
    }

    /**
     * @Then delete object status code is :arg1
     */
    public function deleteObjectStatusCodeIs($arg1)
    {
        PHPUnit::assertEquals($arg1, $this->res->getStatusCode());
    }

    /**
     * @When delete the move object
     */
    public function deleteTheMoveObject()
    {
        $this->res = self::$test_bucket->deleteObject('test_move_object');
    }

    /**
     * @Then delete the move object status code is :arg1
     */
    public function deleteTheMoveObjectStatusCodeIs($arg1)
    {
        PHPUnit::assertEquals($arg1, $this->res->getStatusCode());
    }

    // ----------------------------------------------------------------------------

    public static $initiate_multipart_upload_output;

    /**
     * @When initiate multipart upload with key :arg1
     */
    public function initiateMultipartUploadWithKey($arg1)
    {
        self::$initiate_multipart_upload_output = self::$test_bucket->initiateMultipartUpload(
            $arg1,
            array(
                'Content-Type' => 'text/plain',
            )
        );
    }

    /**
     * @Then initiate multipart upload status code is :arg1
     */
    public function initiateMultipartUploadStatusCodeIs($arg1)
    {
        PHPUnit::assertEquals($arg1, self::$initiate_multipart_upload_output->getStatusCode());
    }

    /**
     * @When upload the first part
     */
    public function uploadTheFirstPart()
    {
        exec('dd if=/dev/zero of=/tmp/sdk_bin_part_0 bs=1048576 count=5');
        $this->res = self::$test_bucket->uploadMultipart(
            'test_object_multipart',
            array(
                'upload_id' => json_decode(self::$initiate_multipart_upload_output->getBody(), true)['upload_id'],
                'part_number' => 0,
                'body' => file_get_contents('/tmp/sdk_bin_part_0'),
            )
        );
        exec('rm -f /tmp/sdk_bin_part_0');
    }

    /**
     * @Then upload the first part status code is :arg1
     */
    public function uploadTheFirstPartStatusCodeIs($arg1)
    {
        PHPUnit::assertEquals($arg1, $this->res->getStatusCode());
    }

    /**
     * @When upload the second part
     */
    public function uploadTheSecondPart()
    {
        exec('dd if=/dev/zero of=/tmp/sdk_bin_part_1 bs=1048576 count=5');
        $this->res = self::$test_bucket->uploadMultipart(
            'test_object_multipart',
            array(
                'upload_id' => json_decode(self::$initiate_multipart_upload_output->getBody(), true)['upload_id'],
                'part_number' => 1,
                'body' => file_get_contents('/tmp/sdk_bin_part_1'),
            )
        );
        exec('rm -f /tmp/sdk_bin_part_1');
    }

    /**
     * @Then upload the second part status code is :arg1
     */
    public function uploadTheSecondPartStatusCodeIs($arg1)
    {
        PHPUnit::assertEquals($arg1, $this->res->getStatusCode());
    }

    /**
     * @When upload the third part
     */
    public function uploadTheThirdPart()
    {
        exec('dd if=/dev/zero of=/tmp/sdk_bin_part_2 bs=1048576 count=5');
        $this->res = self::$test_bucket->uploadMultipart(
            'test_object_multipart',
            array(
                'upload_id' => json_decode(self::$initiate_multipart_upload_output->getBody(), true)['upload_id'],
                'part_number' => 2,
                'body' => file_get_contents('/tmp/sdk_bin_part_2'),
            )
        );
        exec('rm -f /tmp/sdk_bin_part_2');
    }

    /**
     * @Then upload the third part status code is :arg1
     */
    public function uploadTheThirdPartStatusCodeIs($arg1)
    {
        PHPUnit::assertEquals($arg1, $this->res->getStatusCode());
    }

    public static $complete_multipart_upload_output;

    /**
     * @When list multipart
     */
    public function listMultipart()
    {
        self::$complete_multipart_upload_output = self::$test_bucket->listMultipart(
            'test_object_multipart',
            array(
                'upload_id' => json_decode(self::$initiate_multipart_upload_output->getBody(), true)['upload_id'],
            )
        );
    }

    /**
     * @Then list multipart status code is :arg1
     */
    public function listMultipartStatusCodeIs($arg1)
    {
        PHPUnit::assertEquals($arg1, self::$complete_multipart_upload_output->getStatusCode());
    }

    /**
     * @Then list multipart object parts count is :arg1
     */
    public function listMultipartObjectPartsCountIs($arg1)
    {
        PHPUnit::assertEquals($arg1, count(json_decode(self::$complete_multipart_upload_output->getBody(), true)['object_parts']));
    }

    /**
     * @When Complete multipart upload
     */
    public function completeMultipartUpload()
    {
        $this->res = self::$test_bucket->completeMultipartUpload(
            'test_object_multipart',
            array(
                'upload_id' => json_decode(self::$initiate_multipart_upload_output->getBody(), true)['upload_id'],
                'etag' => '"4072783b8efb99a9e5817067d68f61c6"',
                'object_parts' => json_decode(self::$complete_multipart_upload_output->getBody(), true)['object_parts'],
            )
        );
    }

    /**
     * @Then complete multipart upload status code is :arg1
     */
    public function completeMultipartUploadStatusCodeIs($arg1)
    {
        PHPUnit::assertEquals($arg1, $this->res->getStatusCode());
    }

    /**
     * @When abort multipart upload
     */
    public function abortMultipartUpload()
    {
        $this->res = self::$test_bucket->abortMultipartUpload(
            'test_object_multipart',
            array(
                'upload_id' => json_decode(self::$initiate_multipart_upload_output->getBody(), true)['upload_id'],
            )
        );
    }

    /**
     * @Then abort multipart upload status code is :arg1
     */
    public function abortMultipartUploadStatusCodeIs($arg1)
    {
        PHPUnit::assertEquals($arg1, $this->res->getStatusCode());
    }

    /**
     * @When delete the multipart object
     */
    public function deleteTheMultipartObject()
    {
        $this->res = self::$test_bucket->deleteObject('test_object_multipart');
    }

    /**
     * @Then delete the multipart object status code is :arg1
     */
    public function deleteTheMultipartObjectStatusCodeIs($arg1)
    {
        PHPUnit::assertEquals($arg1, $this->res->getStatusCode());
    }
}
