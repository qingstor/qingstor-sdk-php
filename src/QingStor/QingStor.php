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

namespace QingStor\SDK\Service;

use QingStor\SDK\Signer;
use QingStor\SDK\Builder;
use QingStor\SDK\Unpacker;

// QingStor provides QingStor Service API (API Version 2016-01-06)

class QingStor
{
    public function __construct($config)
    {
        $this->config = $config;
    }

    /**
     * listBuckets: Retrieve the bucket list.
     *
     * @link https://docs.qingcloud.com/qingstor/api/service/get.html Documentation URL
     *
     * @param string 'Location' Limits results to buckets that in the location
     *
     * @return response
     */
    public function listBucketsRequest($options = array())
    {
        $operation = array(
            'API' => 'ListBuckets',
            'Method' => 'GET',
            'Uri' => '/',
            'Headers' => array(
                'Host' => $this->config->host,
                'Location' => isset($options['Location']) ? $options['Location'] : null,
            ),
            'Params' => array(
            ),
            'Elements' => array(
            ),
            'Properties' => array(),
            'Body' => null,
        );
        $builder = new Builder($this->config, $operation);
        $request = $builder->parse();
        $signer = new Signer(
            $request,
            $this->config->access_key_id,
            $this->config->secret_access_key
        );

        return $signer;
    }

    /**
     * listBuckets: Retrieve the bucket list.
     *
     * @link https://docs.qingcloud.com/qingstor/api/service/get.html Documentation URL
     *
     * @param string 'Location' Limits results to buckets that in the location
     *
     * @return Unpacker
     */
    public function listBuckets($options = array())
    {
        $signer = $this->listBucketsRequest($options);
        $response = new Unpacker($this->config->client->send(
            $signer->sign()
        ));

        return $response;
    }

    /**
     * listBucketsQuery: ListBuckets's Query Sign Way.
     *
     * @link https://docs.qingcloud.com/qingstor/api/service/get.html Documentation URL
     *
     * @param string 'Location' Limits results to buckets that in the location
     *
     * @return Signer
     */
    public function listBucketsQuery($expires, $options = array())
    {
        $signer = $this->listBucketsRequest($options);

        return $signer->query_sign($expires);
    }

    public function Bucket($bucket_name, $zone)
    {
        $properties = array(
            'bucket-name' => $bucket_name,
            'zone' => $zone,
        );

        return new Bucket($this->config, $properties);
    }
}
