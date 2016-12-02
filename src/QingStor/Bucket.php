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

use QingStor\SDK\Builder;
use QingStor\SDK\Signer;
use QingStor\SDK\Exception;

class Bucket
{
    public function __construct($config, $properties)
    {
        $this->config = $config;
        $this->properties = $properties;
    }

    /**
     * deleteRequest: Build Delete's request.
     *
     * @link https://docs.qingcloud.com/qingstor/api/bucket/delete.html Documentation URL
     *
     * @return Signer
     */
    public function deleteRequest()
    {
        $operation = array(
            'Method' => 'DELETE',
            'Uri' => '/<bucket-name>',
            'Headers' => array(
                'Host' => $this->properties['zone'].'.'.$this->config->host,
            ),
            'Params' => array(
            ),
            'Elements' => array(
            ),
            'Properties' => $this->properties,
            'Body' => null,
        );
        $this->deleteValidate($operation);
        $builder = new Builder\QingStor($this->config, $operation);
        $request = $builder->parse();
        $signer = new Signer(
            $request,
            $this->config->access_key_id,
            $this->config->secret_access_key
        );

        return $signer;
    }

    /**
     * delete: Delete a bucket.
     *
     * @link https://docs.qingcloud.com/qingstor/api/bucket/delete.html Documentation URL
     *
     * @return \GuzzleHttp\Psr7\Response
     *
     * @throws \Exception
     */
    public function delete()
    {
        $signer = $this->deleteRequest();
        $retries = $this->config->connection_retries;
        while (1) {
            try {
                $this->config->logger->info('Sending QingStor request: delete');
                $response = $this->config->client->send(
                    $signer->sign()
                );
            } catch (\Exception $e) {
                $this->config->logger->error($e->getMessage());
                if ($retries > 0) {
                    $retries -= 1;
                } else {
                    throw new \Exception('Network Error');
                }
            }
            break;
        }

        return $response;
    }

    /**
     * deleteQuery: delete's Query Sign Way.
     *
     * @link https://docs.qingcloud.com/qingstor/api/bucket/delete.html Documentation URL
     *
     * @return Signer
     */
    public function deleteQuery($expires)
    {
        $signer = $this->deleteRequest();

        return $signer->query_sign($expires);
    }

    public function deleteValidate($operation)
    {
    }

    /**
     * deleteCORSRequest: Build DeleteCORS's request.
     *
     * @link https://docs.qingcloud.com/qingstor/api/bucket/cors/delete_cors.html Documentation URL
     *
     * @return Signer
     */
    public function deleteCORSRequest()
    {
        $operation = array(
            'Method' => 'DELETE',
            'Uri' => '/<bucket-name>?cors',
            'Headers' => array(
                'Host' => $this->properties['zone'].'.'.$this->config->host,
            ),
            'Params' => array(
            ),
            'Elements' => array(
            ),
            'Properties' => $this->properties,
            'Body' => null,
        );
        $this->deleteCORSValidate($operation);
        $builder = new Builder\QingStor($this->config, $operation);
        $request = $builder->parse();
        $signer = new Signer(
            $request,
            $this->config->access_key_id,
            $this->config->secret_access_key
        );

        return $signer;
    }

    /**
     * deleteCORS: Delete CORS information of the bucket.
     *
     * @link https://docs.qingcloud.com/qingstor/api/bucket/cors/delete_cors.html Documentation URL
     *
     * @return \GuzzleHttp\Psr7\Response
     *
     * @throws \Exception
     */
    public function deleteCORS()
    {
        $signer = $this->deleteCORSRequest();
        $retries = $this->config->connection_retries;
        while (1) {
            try {
                $this->config->logger->info('Sending QingStor request: deleteCORS');
                $response = $this->config->client->send(
                    $signer->sign()
                );
            } catch (\Exception $e) {
                $this->config->logger->error($e->getMessage());
                if ($retries > 0) {
                    $retries -= 1;
                } else {
                    throw new \Exception('Network Error');
                }
            }
            break;
        }

        return $response;
    }

    /**
     * deleteCORSQuery: deleteCORS's Query Sign Way.
     *
     * @link https://docs.qingcloud.com/qingstor/api/bucket/cors/delete_cors.html Documentation URL
     *
     * @return Signer
     */
    public function deleteCORSQuery($expires)
    {
        $signer = $this->deleteCORSRequest();

        return $signer->query_sign($expires);
    }

    public function deleteCORSValidate($operation)
    {
    }

    /**
     * deleteExternalMirrorRequest: Build DeleteExternalMirror's request.
     *
     * @link https://docs.qingcloud.com/qingstor/api/bucket/external_mirror/delete_external_mirror.html Documentation URL
     *
     * @return Signer
     */
    public function deleteExternalMirrorRequest()
    {
        $operation = array(
            'Method' => 'DELETE',
            'Uri' => '/<bucket-name>?mirror',
            'Headers' => array(
                'Host' => $this->properties['zone'].'.'.$this->config->host,
            ),
            'Params' => array(
            ),
            'Elements' => array(
            ),
            'Properties' => $this->properties,
            'Body' => null,
        );
        $this->deleteExternalMirrorValidate($operation);
        $builder = new Builder\QingStor($this->config, $operation);
        $request = $builder->parse();
        $signer = new Signer(
            $request,
            $this->config->access_key_id,
            $this->config->secret_access_key
        );

        return $signer;
    }

    /**
     * deleteExternalMirror: Delete external mirror of the bucket.
     *
     * @link https://docs.qingcloud.com/qingstor/api/bucket/external_mirror/delete_external_mirror.html Documentation URL
     *
     * @return \GuzzleHttp\Psr7\Response
     *
     * @throws \Exception
     */
    public function deleteExternalMirror()
    {
        $signer = $this->deleteExternalMirrorRequest();
        $retries = $this->config->connection_retries;
        while (1) {
            try {
                $this->config->logger->info('Sending QingStor request: deleteExternalMirror');
                $response = $this->config->client->send(
                    $signer->sign()
                );
            } catch (\Exception $e) {
                $this->config->logger->error($e->getMessage());
                if ($retries > 0) {
                    $retries -= 1;
                } else {
                    throw new \Exception('Network Error');
                }
            }
            break;
        }

        return $response;
    }

    /**
     * deleteExternalMirrorQuery: deleteExternalMirror's Query Sign Way.
     *
     * @link https://docs.qingcloud.com/qingstor/api/bucket/external_mirror/delete_external_mirror.html Documentation URL
     *
     * @return Signer
     */
    public function deleteExternalMirrorQuery($expires)
    {
        $signer = $this->deleteExternalMirrorRequest();

        return $signer->query_sign($expires);
    }

    public function deleteExternalMirrorValidate($operation)
    {
    }

    /**
     * deletePolicyRequest: Build DeletePolicy's request.
     *
     * @link https://docs.qingcloud.com/qingstor/api/bucket/policy/delete_policy.html Documentation URL
     *
     * @return Signer
     */
    public function deletePolicyRequest()
    {
        $operation = array(
            'Method' => 'DELETE',
            'Uri' => '/<bucket-name>?policy',
            'Headers' => array(
                'Host' => $this->properties['zone'].'.'.$this->config->host,
            ),
            'Params' => array(
            ),
            'Elements' => array(
            ),
            'Properties' => $this->properties,
            'Body' => null,
        );
        $this->deletePolicyValidate($operation);
        $builder = new Builder\QingStor($this->config, $operation);
        $request = $builder->parse();
        $signer = new Signer(
            $request,
            $this->config->access_key_id,
            $this->config->secret_access_key
        );

        return $signer;
    }

    /**
     * deletePolicy: Delete policy information of the bucket.
     *
     * @link https://docs.qingcloud.com/qingstor/api/bucket/policy/delete_policy.html Documentation URL
     *
     * @return \GuzzleHttp\Psr7\Response
     *
     * @throws \Exception
     */
    public function deletePolicy()
    {
        $signer = $this->deletePolicyRequest();
        $retries = $this->config->connection_retries;
        while (1) {
            try {
                $this->config->logger->info('Sending QingStor request: deletePolicy');
                $response = $this->config->client->send(
                    $signer->sign()
                );
            } catch (\Exception $e) {
                $this->config->logger->error($e->getMessage());
                if ($retries > 0) {
                    $retries -= 1;
                } else {
                    throw new \Exception('Network Error');
                }
            }
            break;
        }

        return $response;
    }

    /**
     * deletePolicyQuery: deletePolicy's Query Sign Way.
     *
     * @link https://docs.qingcloud.com/qingstor/api/bucket/policy/delete_policy.html Documentation URL
     *
     * @return Signer
     */
    public function deletePolicyQuery($expires)
    {
        $signer = $this->deletePolicyRequest();

        return $signer->query_sign($expires);
    }

    public function deletePolicyValidate($operation)
    {
    }

    /**
     * deleteMultipleObjectsRequest: Build DeleteMultipleObjects's request.
     *
     * @link https://docs.qingcloud.com/qingstor/api/bucket/delete_multiple.html Documentation URL
     *
     * @param string "Content-MD5" Object MD5sum
     * @param array "objects" A list of keys to delete
     * @param bool "quiet" Whether to return the list of deleted objects
     *
     * @return Signer
     */
    public function deleteMultipleObjectsRequest($options = array())
    {
        $operation = array(
            'Method' => 'POST',
            'Uri' => '/<bucket-name>?delete',
            'Headers' => array(
                'Host' => $this->properties['zone'].'.'.$this->config->host,
                'Content-MD5' => isset($options['Content-MD5']) ? $options['Content-MD5'] : null,
            ),
            'Params' => array(
            ),
            'Elements' => array(
                'objects' => isset($options['objects']) ? $options['objects'] : null,
                'quiet' => isset($options['quiet']) ? $options['quiet'] : null,
            ),
            'Properties' => $this->properties,
            'Body' => null,
        );
        $this->deleteMultipleObjectsValidate($operation);
        $builder = new Builder\QingStor($this->config, $operation);
        $request = $builder->parse();
        $signer = new Signer(
            $request,
            $this->config->access_key_id,
            $this->config->secret_access_key
        );

        return $signer;
    }

    /**
     * deleteMultipleObjects: Delete multiple objects from the bucket.
     *
     * @link https://docs.qingcloud.com/qingstor/api/bucket/delete_multiple.html Documentation URL
     *
     * @param string "Content-MD5" Object MD5sum
     * @param array "objects" A list of keys to delete
     * @param bool "quiet" Whether to return the list of deleted objects
     *
     * @return \GuzzleHttp\Psr7\Response
     *
     * @throws \Exception
     */
    public function deleteMultipleObjects($options = array())
    {
        $signer = $this->deleteMultipleObjectsRequest($options);
        $retries = $this->config->connection_retries;
        while (1) {
            try {
                $this->config->logger->info('Sending QingStor request: deleteMultipleObjects');
                $response = $this->config->client->send(
                    $signer->sign()
                );
            } catch (\Exception $e) {
                $this->config->logger->error($e->getMessage());
                if ($retries > 0) {
                    $retries -= 1;
                } else {
                    throw new \Exception('Network Error');
                }
            }
            break;
        }

        return $response;
    }

    /**
     * deleteMultipleObjectsQuery: deleteMultipleObjects's Query Sign Way.
     *
     * @link https://docs.qingcloud.com/qingstor/api/bucket/delete_multiple.html Documentation URL
     *
     * @param string "Content-MD5" Object MD5sum
     * @param array "objects" A list of keys to delete
     * @param bool "quiet" Whether to return the list of deleted objects
     *
     * @return Signer
     */
    public function deleteMultipleObjectsQuery($expires, $options = array())
    {
        $signer = $this->deleteMultipleObjectsRequest($options);

        return $signer->query_sign($expires);
    }

    public function deleteMultipleObjectsValidate($operation)
    {
        if (!isset($operation['Headers']['Content-MD5'])
        || ($operation['Headers']['Content-MD5'] === ''
        || $operation['Headers']['Content-MD5'] === array()
        || $operation['Headers']['Content-MD5'] === null
    )) {
            throw new Exception\ParameterRequiredException('Content-MD5', 'DeleteMultipleObjectsInput');
        }
        if (!isset($operation['Elements']['objects'])
            || ($operation['Elements']['objects'] === ''
                || $operation['Elements']['objects'] === array()
                || $operation['Elements']['objects'] === null
                )
        ) {
            throw new Exception\ParameterRequiredException('objects', 'DeleteMultipleObjectsInput');
        }
        foreach ($operation['Elements']['objects'] as $key) {
        }
    }

    /**
     * getACLRequest: Build GetACL's request.
     *
     * @link https://docs.qingcloud.com/qingstor/api/bucket/get_acl.html Documentation URL
     *
     * @return Signer
     */
    public function getACLRequest()
    {
        $operation = array(
            'Method' => 'GET',
            'Uri' => '/<bucket-name>?acl',
            'Headers' => array(
                'Host' => $this->properties['zone'].'.'.$this->config->host,
            ),
            'Params' => array(
            ),
            'Elements' => array(
            ),
            'Properties' => $this->properties,
            'Body' => null,
        );
        $this->getACLValidate($operation);
        $builder = new Builder\QingStor($this->config, $operation);
        $request = $builder->parse();
        $signer = new Signer(
            $request,
            $this->config->access_key_id,
            $this->config->secret_access_key
        );

        return $signer;
    }

    /**
     * getACL: Get ACL information of the bucket.
     *
     * @link https://docs.qingcloud.com/qingstor/api/bucket/get_acl.html Documentation URL
     *
     * @return \GuzzleHttp\Psr7\Response
     *
     * @throws \Exception
     */
    public function getACL()
    {
        $signer = $this->getACLRequest();
        $retries = $this->config->connection_retries;
        while (1) {
            try {
                $this->config->logger->info('Sending QingStor request: getACL');
                $response = $this->config->client->send(
                    $signer->sign()
                );
            } catch (\Exception $e) {
                $this->config->logger->error($e->getMessage());
                if ($retries > 0) {
                    $retries -= 1;
                } else {
                    throw new \Exception('Network Error');
                }
            }
            break;
        }

        return $response;
    }

    /**
     * getACLQuery: getACL's Query Sign Way.
     *
     * @link https://docs.qingcloud.com/qingstor/api/bucket/get_acl.html Documentation URL
     *
     * @return Signer
     */
    public function getACLQuery($expires)
    {
        $signer = $this->getACLRequest();

        return $signer->query_sign($expires);
    }

    public function getACLValidate($operation)
    {
    }

    /**
     * getCORSRequest: Build GetCORS's request.
     *
     * @link https://docs.qingcloud.com/qingstor/api/bucket/cors/get_cors.html Documentation URL
     *
     * @return Signer
     */
    public function getCORSRequest()
    {
        $operation = array(
            'Method' => 'GET',
            'Uri' => '/<bucket-name>?cors',
            'Headers' => array(
                'Host' => $this->properties['zone'].'.'.$this->config->host,
            ),
            'Params' => array(
            ),
            'Elements' => array(
            ),
            'Properties' => $this->properties,
            'Body' => null,
        );
        $this->getCORSValidate($operation);
        $builder = new Builder\QingStor($this->config, $operation);
        $request = $builder->parse();
        $signer = new Signer(
            $request,
            $this->config->access_key_id,
            $this->config->secret_access_key
        );

        return $signer;
    }

    /**
     * getCORS: Get CORS information of the bucket.
     *
     * @link https://docs.qingcloud.com/qingstor/api/bucket/cors/get_cors.html Documentation URL
     *
     * @return \GuzzleHttp\Psr7\Response
     *
     * @throws \Exception
     */
    public function getCORS()
    {
        $signer = $this->getCORSRequest();
        $retries = $this->config->connection_retries;
        while (1) {
            try {
                $this->config->logger->info('Sending QingStor request: getCORS');
                $response = $this->config->client->send(
                    $signer->sign()
                );
            } catch (\Exception $e) {
                $this->config->logger->error($e->getMessage());
                if ($retries > 0) {
                    $retries -= 1;
                } else {
                    throw new \Exception('Network Error');
                }
            }
            break;
        }

        return $response;
    }

    /**
     * getCORSQuery: getCORS's Query Sign Way.
     *
     * @link https://docs.qingcloud.com/qingstor/api/bucket/cors/get_cors.html Documentation URL
     *
     * @return Signer
     */
    public function getCORSQuery($expires)
    {
        $signer = $this->getCORSRequest();

        return $signer->query_sign($expires);
    }

    public function getCORSValidate($operation)
    {
    }

    /**
     * getExternalMirrorRequest: Build GetExternalMirror's request.
     *
     * @link https://docs.qingcloud.com/qingstor/api/bucket/external_mirror/get_external_mirror.html Documentation URL
     *
     * @return Signer
     */
    public function getExternalMirrorRequest()
    {
        $operation = array(
            'Method' => 'GET',
            'Uri' => '/<bucket-name>?mirror',
            'Headers' => array(
                'Host' => $this->properties['zone'].'.'.$this->config->host,
            ),
            'Params' => array(
            ),
            'Elements' => array(
            ),
            'Properties' => $this->properties,
            'Body' => null,
        );
        $this->getExternalMirrorValidate($operation);
        $builder = new Builder\QingStor($this->config, $operation);
        $request = $builder->parse();
        $signer = new Signer(
            $request,
            $this->config->access_key_id,
            $this->config->secret_access_key
        );

        return $signer;
    }

    /**
     * getExternalMirror: Get external mirror of the bucket.
     *
     * @link https://docs.qingcloud.com/qingstor/api/bucket/external_mirror/get_external_mirror.html Documentation URL
     *
     * @return \GuzzleHttp\Psr7\Response
     *
     * @throws \Exception
     */
    public function getExternalMirror()
    {
        $signer = $this->getExternalMirrorRequest();
        $retries = $this->config->connection_retries;
        while (1) {
            try {
                $this->config->logger->info('Sending QingStor request: getExternalMirror');
                $response = $this->config->client->send(
                    $signer->sign()
                );
            } catch (\Exception $e) {
                $this->config->logger->error($e->getMessage());
                if ($retries > 0) {
                    $retries -= 1;
                } else {
                    throw new \Exception('Network Error');
                }
            }
            break;
        }

        return $response;
    }

    /**
     * getExternalMirrorQuery: getExternalMirror's Query Sign Way.
     *
     * @link https://docs.qingcloud.com/qingstor/api/bucket/external_mirror/get_external_mirror.html Documentation URL
     *
     * @return Signer
     */
    public function getExternalMirrorQuery($expires)
    {
        $signer = $this->getExternalMirrorRequest();

        return $signer->query_sign($expires);
    }

    public function getExternalMirrorValidate($operation)
    {
    }

    /**
     * getPolicyRequest: Build GetPolicy's request.
     *
     * @link https://https://docs.qingcloud.com/qingstor/api/bucket/policy/get_policy.html Documentation URL
     *
     * @return Signer
     */
    public function getPolicyRequest()
    {
        $operation = array(
            'Method' => 'GET',
            'Uri' => '/<bucket-name>?policy',
            'Headers' => array(
                'Host' => $this->properties['zone'].'.'.$this->config->host,
            ),
            'Params' => array(
            ),
            'Elements' => array(
            ),
            'Properties' => $this->properties,
            'Body' => null,
        );
        $this->getPolicyValidate($operation);
        $builder = new Builder\QingStor($this->config, $operation);
        $request = $builder->parse();
        $signer = new Signer(
            $request,
            $this->config->access_key_id,
            $this->config->secret_access_key
        );

        return $signer;
    }

    /**
     * getPolicy: Get policy information of the bucket.
     *
     * @link https://https://docs.qingcloud.com/qingstor/api/bucket/policy/get_policy.html Documentation URL
     *
     * @return \GuzzleHttp\Psr7\Response
     *
     * @throws \Exception
     */
    public function getPolicy()
    {
        $signer = $this->getPolicyRequest();
        $retries = $this->config->connection_retries;
        while (1) {
            try {
                $this->config->logger->info('Sending QingStor request: getPolicy');
                $response = $this->config->client->send(
                    $signer->sign()
                );
            } catch (\Exception $e) {
                $this->config->logger->error($e->getMessage());
                if ($retries > 0) {
                    $retries -= 1;
                } else {
                    throw new \Exception('Network Error');
                }
            }
            break;
        }

        return $response;
    }

    /**
     * getPolicyQuery: getPolicy's Query Sign Way.
     *
     * @link https://https://docs.qingcloud.com/qingstor/api/bucket/policy/get_policy.html Documentation URL
     *
     * @return Signer
     */
    public function getPolicyQuery($expires)
    {
        $signer = $this->getPolicyRequest();

        return $signer->query_sign($expires);
    }

    public function getPolicyValidate($operation)
    {
    }

    /**
     * getStatisticsRequest: Build GetStatistics's request.
     *
     * @link https://docs.qingcloud.com/qingstor/api/bucket/get_stats.html Documentation URL
     *
     * @return Signer
     */
    public function getStatisticsRequest()
    {
        $operation = array(
            'Method' => 'GET',
            'Uri' => '/<bucket-name>?stats',
            'Headers' => array(
                'Host' => $this->properties['zone'].'.'.$this->config->host,
            ),
            'Params' => array(
            ),
            'Elements' => array(
            ),
            'Properties' => $this->properties,
            'Body' => null,
        );
        $this->getStatisticsValidate($operation);
        $builder = new Builder\QingStor($this->config, $operation);
        $request = $builder->parse();
        $signer = new Signer(
            $request,
            $this->config->access_key_id,
            $this->config->secret_access_key
        );

        return $signer;
    }

    /**
     * getStatistics: Get statistics information of the bucket.
     *
     * @link https://docs.qingcloud.com/qingstor/api/bucket/get_stats.html Documentation URL
     *
     * @return \GuzzleHttp\Psr7\Response
     *
     * @throws \Exception
     */
    public function getStatistics()
    {
        $signer = $this->getStatisticsRequest();
        $retries = $this->config->connection_retries;
        while (1) {
            try {
                $this->config->logger->info('Sending QingStor request: getStatistics');
                $response = $this->config->client->send(
                    $signer->sign()
                );
            } catch (\Exception $e) {
                $this->config->logger->error($e->getMessage());
                if ($retries > 0) {
                    $retries -= 1;
                } else {
                    throw new \Exception('Network Error');
                }
            }
            break;
        }

        return $response;
    }

    /**
     * getStatisticsQuery: getStatistics's Query Sign Way.
     *
     * @link https://docs.qingcloud.com/qingstor/api/bucket/get_stats.html Documentation URL
     *
     * @return Signer
     */
    public function getStatisticsQuery($expires)
    {
        $signer = $this->getStatisticsRequest();

        return $signer->query_sign($expires);
    }

    public function getStatisticsValidate($operation)
    {
    }

    /**
     * headRequest: Build Head's request.
     *
     * @link https://docs.qingcloud.com/qingstor/api/bucket/head.html Documentation URL
     *
     * @return Signer
     */
    public function headRequest()
    {
        $operation = array(
            'Method' => 'HEAD',
            'Uri' => '/<bucket-name>',
            'Headers' => array(
                'Host' => $this->properties['zone'].'.'.$this->config->host,
            ),
            'Params' => array(
            ),
            'Elements' => array(
            ),
            'Properties' => $this->properties,
            'Body' => null,
        );
        $this->headValidate($operation);
        $builder = new Builder\QingStor($this->config, $operation);
        $request = $builder->parse();
        $signer = new Signer(
            $request,
            $this->config->access_key_id,
            $this->config->secret_access_key
        );

        return $signer;
    }

    /**
     * head: Check whether the bucket exists and available.
     *
     * @link https://docs.qingcloud.com/qingstor/api/bucket/head.html Documentation URL
     *
     * @return \GuzzleHttp\Psr7\Response
     *
     * @throws \Exception
     */
    public function head()
    {
        $signer = $this->headRequest();
        $retries = $this->config->connection_retries;
        while (1) {
            try {
                $this->config->logger->info('Sending QingStor request: head');
                $response = $this->config->client->send(
                    $signer->sign()
                );
            } catch (\Exception $e) {
                $this->config->logger->error($e->getMessage());
                if ($retries > 0) {
                    $retries -= 1;
                } else {
                    throw new \Exception('Network Error');
                }
            }
            break;
        }

        return $response;
    }

    /**
     * headQuery: head's Query Sign Way.
     *
     * @link https://docs.qingcloud.com/qingstor/api/bucket/head.html Documentation URL
     *
     * @return Signer
     */
    public function headQuery($expires)
    {
        $signer = $this->headRequest();

        return $signer->query_sign($expires);
    }

    public function headValidate($operation)
    {
    }

    /**
     * listObjectsRequest: Build ListObjects's request.
     *
     * @link https://docs.qingcloud.com/qingstor/api/bucket/get.html Documentation URL
     *
     * @param string "delimiter" Put all keys that share a common prefix into a list
     * @param int "limit" Results count limit
     * @param string "marker" Limit results to keys that start at this marker
     * @param string "prefix" Limits results to keys that begin with the prefix
     *
     * @return Signer
     */
    public function listObjectsRequest($options = array())
    {
        $operation = array(
            'Method' => 'GET',
            'Uri' => '/<bucket-name>',
            'Headers' => array(
                'Host' => $this->properties['zone'].'.'.$this->config->host,
            ),
            'Params' => array(
                'delimiter' => isset($options['delimiter']) ? $options['delimiter'] : null,
                'limit' => isset($options['limit']) ? $options['limit'] : null,
                'marker' => isset($options['marker']) ? $options['marker'] : null,
                'prefix' => isset($options['prefix']) ? $options['prefix'] : null,
            ),
            'Elements' => array(
            ),
            'Properties' => $this->properties,
            'Body' => null,
        );
        $this->listObjectsValidate($operation);
        $builder = new Builder\QingStor($this->config, $operation);
        $request = $builder->parse();
        $signer = new Signer(
            $request,
            $this->config->access_key_id,
            $this->config->secret_access_key
        );

        return $signer;
    }

    /**
     * listObjects: Retrieve the object list in a bucket.
     *
     * @link https://docs.qingcloud.com/qingstor/api/bucket/get.html Documentation URL
     *
     * @param string "delimiter" Put all keys that share a common prefix into a list
     * @param int "limit" Results count limit
     * @param string "marker" Limit results to keys that start at this marker
     * @param string "prefix" Limits results to keys that begin with the prefix
     *
     * @return \GuzzleHttp\Psr7\Response
     *
     * @throws \Exception
     */
    public function listObjects($options = array())
    {
        $signer = $this->listObjectsRequest($options);
        $retries = $this->config->connection_retries;
        while (1) {
            try {
                $this->config->logger->info('Sending QingStor request: listObjects');
                $response = $this->config->client->send(
                    $signer->sign()
                );
            } catch (\Exception $e) {
                $this->config->logger->error($e->getMessage());
                if ($retries > 0) {
                    $retries -= 1;
                } else {
                    throw new \Exception('Network Error');
                }
            }
            break;
        }

        return $response;
    }

    /**
     * listObjectsQuery: listObjects's Query Sign Way.
     *
     * @link https://docs.qingcloud.com/qingstor/api/bucket/get.html Documentation URL
     *
     * @param string "delimiter" Put all keys that share a common prefix into a list
     * @param int "limit" Results count limit
     * @param string "marker" Limit results to keys that start at this marker
     * @param string "prefix" Limits results to keys that begin with the prefix
     *
     * @return Signer
     */
    public function listObjectsQuery($expires, $options = array())
    {
        $signer = $this->listObjectsRequest($options);

        return $signer->query_sign($expires);
    }

    public function listObjectsValidate($operation)
    {
    }

    /**
     * putRequest: Build Put's request.
     *
     * @link https://docs.qingcloud.com/qingstor/api/bucket/put.html Documentation URL
     *
     * @return Signer
     */
    public function putRequest()
    {
        $operation = array(
            'Method' => 'PUT',
            'Uri' => '/<bucket-name>',
            'Headers' => array(
                'Host' => $this->properties['zone'].'.'.$this->config->host,
            ),
            'Params' => array(
            ),
            'Elements' => array(
            ),
            'Properties' => $this->properties,
            'Body' => null,
        );
        $this->putValidate($operation);
        $builder = new Builder\QingStor($this->config, $operation);
        $request = $builder->parse();
        $signer = new Signer(
            $request,
            $this->config->access_key_id,
            $this->config->secret_access_key
        );

        return $signer;
    }

    /**
     * put: Create a new bucket.
     *
     * @link https://docs.qingcloud.com/qingstor/api/bucket/put.html Documentation URL
     *
     * @return \GuzzleHttp\Psr7\Response
     *
     * @throws \Exception
     */
    public function put()
    {
        $signer = $this->putRequest();
        $retries = $this->config->connection_retries;
        while (1) {
            try {
                $this->config->logger->info('Sending QingStor request: put');
                $response = $this->config->client->send(
                    $signer->sign()
                );
            } catch (\Exception $e) {
                $this->config->logger->error($e->getMessage());
                if ($retries > 0) {
                    $retries -= 1;
                } else {
                    throw new \Exception('Network Error');
                }
            }
            break;
        }

        return $response;
    }

    /**
     * putQuery: put's Query Sign Way.
     *
     * @link https://docs.qingcloud.com/qingstor/api/bucket/put.html Documentation URL
     *
     * @return Signer
     */
    public function putQuery($expires)
    {
        $signer = $this->putRequest();

        return $signer->query_sign($expires);
    }

    public function putValidate($operation)
    {
    }

    /**
     * putACLRequest: Build PutACL's request.
     *
     * @link https://docs.qingcloud.com/qingstor/api/bucket/put_acl.html Documentation URL
     *
     * @param array "acl" Bucket ACL rules
     *
     * @return Signer
     */
    public function putACLRequest($options = array())
    {
        $operation = array(
            'Method' => 'PUT',
            'Uri' => '/<bucket-name>?acl',
            'Headers' => array(
                'Host' => $this->properties['zone'].'.'.$this->config->host,
            ),
            'Params' => array(
            ),
            'Elements' => array(
                'acl' => isset($options['acl']) ? $options['acl'] : null,
            ),
            'Properties' => $this->properties,
            'Body' => null,
        );
        $this->putACLValidate($operation);
        $builder = new Builder\QingStor($this->config, $operation);
        $request = $builder->parse();
        $signer = new Signer(
            $request,
            $this->config->access_key_id,
            $this->config->secret_access_key
        );

        return $signer;
    }

    /**
     * putACL: Set ACL information of the bucket.
     *
     * @link https://docs.qingcloud.com/qingstor/api/bucket/put_acl.html Documentation URL
     *
     * @param array "acl" Bucket ACL rules
     *
     * @return \GuzzleHttp\Psr7\Response
     *
     * @throws \Exception
     */
    public function putACL($options = array())
    {
        $signer = $this->putACLRequest($options);
        $retries = $this->config->connection_retries;
        while (1) {
            try {
                $this->config->logger->info('Sending QingStor request: putACL');
                $response = $this->config->client->send(
                    $signer->sign()
                );
            } catch (\Exception $e) {
                $this->config->logger->error($e->getMessage());
                if ($retries > 0) {
                    $retries -= 1;
                } else {
                    throw new \Exception('Network Error');
                }
            }
            break;
        }

        return $response;
    }

    /**
     * putACLQuery: putACL's Query Sign Way.
     *
     * @link https://docs.qingcloud.com/qingstor/api/bucket/put_acl.html Documentation URL
     *
     * @param array "acl" Bucket ACL rules
     *
     * @return Signer
     */
    public function putACLQuery($expires, $options = array())
    {
        $signer = $this->putACLRequest($options);

        return $signer->query_sign($expires);
    }

    public function putACLValidate($operation)
    {
        if (!isset($operation['Elements']['acl'])
            || ($operation['Elements']['acl'] === ''
                || $operation['Elements']['acl'] === array()
                || $operation['Elements']['acl'] === null
                )
        ) {
            throw new Exception\ParameterRequiredException('acl', 'PutBucketACLInput');
        }
        foreach ($operation['Elements']['acl'] as $key) {
            if (!isset($key['grantee'])
            || ($key['grantee'] === ''
                || $key['grantee'] === array()
                || $key['grantee'] === null
               )
        ) {
                if (!isset($key['grantee']['type'])
        || ($key['grantee']['type'] === ''
        || $key['grantee']['type'] === array()
        || $key['grantee']['type'] === null
    )) {
                    throw new Exception\ParameterRequiredException('type', 'grantee');
                }
                if (!isset($key['grantee']['type'])
        || ($key['grantee']['type'] === ''
            || $key['grantee']['type'] === array()
            || $key['grantee']['type'] === null
            )
        ) {
                    $type_valid_values = array('user', 'group');
                    if (in_array($key['grantee']['type'], $type_valid_values)) {
                        throw new Exception\ParameterValueNotAllowedException(
                'type',
                $key['grantee']['type'],
                $type_valid_values
            );
                    }
                }
            }
            if (!isset($key['grantee'])) {
                throw new Exception\ParameterRequiredException('grantee', 'acl');
            }
            if (!isset($key['permission'])
        || ($key['permission'] === ''
        || $key['permission'] === array()
        || $key['permission'] === null
    )) {
                throw new Exception\ParameterRequiredException('permission', 'acl');
            }
            if (!isset($key['permission'])
        || ($key['permission'] === ''
            || $key['permission'] === array()
            || $key['permission'] === null
            )
        ) {
                $permission_valid_values = array('READ', 'WRITE', 'FULL_CONTROL');
                if (in_array($key['permission'], $permission_valid_values)) {
                    throw new Exception\ParameterValueNotAllowedException(
                'permission',
                $key['permission'],
                $permission_valid_values
            );
                }
            }
        }
    }

    /**
     * putCORSRequest: Build PutCORS's request.
     *
     * @link https://docs.qingcloud.com/qingstor/api/bucket/cors/put_cors.html Documentation URL
     *
     * @param array "cors_rules" Bucket CORS rules
     *
     * @return Signer
     */
    public function putCORSRequest($options = array())
    {
        $operation = array(
            'Method' => 'PUT',
            'Uri' => '/<bucket-name>?cors',
            'Headers' => array(
                'Host' => $this->properties['zone'].'.'.$this->config->host,
            ),
            'Params' => array(
            ),
            'Elements' => array(
                'cors_rules' => isset($options['cors_rules']) ? $options['cors_rules'] : null,
            ),
            'Properties' => $this->properties,
            'Body' => null,
        );
        $this->putCORSValidate($operation);
        $builder = new Builder\QingStor($this->config, $operation);
        $request = $builder->parse();
        $signer = new Signer(
            $request,
            $this->config->access_key_id,
            $this->config->secret_access_key
        );

        return $signer;
    }

    /**
     * putCORS: Set CORS information of the bucket.
     *
     * @link https://docs.qingcloud.com/qingstor/api/bucket/cors/put_cors.html Documentation URL
     *
     * @param array "cors_rules" Bucket CORS rules
     *
     * @return \GuzzleHttp\Psr7\Response
     *
     * @throws \Exception
     */
    public function putCORS($options = array())
    {
        $signer = $this->putCORSRequest($options);
        $retries = $this->config->connection_retries;
        while (1) {
            try {
                $this->config->logger->info('Sending QingStor request: putCORS');
                $response = $this->config->client->send(
                    $signer->sign()
                );
            } catch (\Exception $e) {
                $this->config->logger->error($e->getMessage());
                if ($retries > 0) {
                    $retries -= 1;
                } else {
                    throw new \Exception('Network Error');
                }
            }
            break;
        }

        return $response;
    }

    /**
     * putCORSQuery: putCORS's Query Sign Way.
     *
     * @link https://docs.qingcloud.com/qingstor/api/bucket/cors/put_cors.html Documentation URL
     *
     * @param array "cors_rules" Bucket CORS rules
     *
     * @return Signer
     */
    public function putCORSQuery($expires, $options = array())
    {
        $signer = $this->putCORSRequest($options);

        return $signer->query_sign($expires);
    }

    public function putCORSValidate($operation)
    {
        if (!isset($operation['Elements']['cors_rules'])
            || ($operation['Elements']['cors_rules'] === ''
                || $operation['Elements']['cors_rules'] === array()
                || $operation['Elements']['cors_rules'] === null
                )
        ) {
            throw new Exception\ParameterRequiredException('cors_rules', 'PutBucketCORSInput');
        }
        foreach ($operation['Elements']['cors_rules'] as $key) {
            if (!isset($key['allowed_methods'])
            || ($key['allowed_methods'] === ''
                || $key['allowed_methods'] === array()
                || $key['allowed_methods'] === null
                )
        ) {
                throw new Exception\ParameterRequiredException('allowed_methods', 'cors_rule');
            }
            if (!isset($key['allowed_origin'])
        || ($key['allowed_origin'] === ''
        || $key['allowed_origin'] === array()
        || $key['allowed_origin'] === null
    )) {
                throw new Exception\ParameterRequiredException('allowed_origin', 'cors_rule');
            }
        }
    }

    /**
     * putExternalMirrorRequest: Build PutExternalMirror's request.
     *
     * @link https://docs.qingcloud.com/qingstor/api/bucket/external_mirror/put_external_mirror.html Documentation URL
     *
     * @param string "source_site" Source site url
     *
     * @return Signer
     */
    public function putExternalMirrorRequest($options = array())
    {
        $operation = array(
            'Method' => 'PUT',
            'Uri' => '/<bucket-name>?mirror',
            'Headers' => array(
                'Host' => $this->properties['zone'].'.'.$this->config->host,
            ),
            'Params' => array(
            ),
            'Elements' => array(
                'source_site' => isset($options['source_site']) ? $options['source_site'] : null,
            ),
            'Properties' => $this->properties,
            'Body' => null,
        );
        $this->putExternalMirrorValidate($operation);
        $builder = new Builder\QingStor($this->config, $operation);
        $request = $builder->parse();
        $signer = new Signer(
            $request,
            $this->config->access_key_id,
            $this->config->secret_access_key
        );

        return $signer;
    }

    /**
     * putExternalMirror: Set external mirror of the bucket.
     *
     * @link https://docs.qingcloud.com/qingstor/api/bucket/external_mirror/put_external_mirror.html Documentation URL
     *
     * @param string "source_site" Source site url
     *
     * @return \GuzzleHttp\Psr7\Response
     *
     * @throws \Exception
     */
    public function putExternalMirror($options = array())
    {
        $signer = $this->putExternalMirrorRequest($options);
        $retries = $this->config->connection_retries;
        while (1) {
            try {
                $this->config->logger->info('Sending QingStor request: putExternalMirror');
                $response = $this->config->client->send(
                    $signer->sign()
                );
            } catch (\Exception $e) {
                $this->config->logger->error($e->getMessage());
                if ($retries > 0) {
                    $retries -= 1;
                } else {
                    throw new \Exception('Network Error');
                }
            }
            break;
        }

        return $response;
    }

    /**
     * putExternalMirrorQuery: putExternalMirror's Query Sign Way.
     *
     * @link https://docs.qingcloud.com/qingstor/api/bucket/external_mirror/put_external_mirror.html Documentation URL
     *
     * @param string "source_site" Source site url
     *
     * @return Signer
     */
    public function putExternalMirrorQuery($expires, $options = array())
    {
        $signer = $this->putExternalMirrorRequest($options);

        return $signer->query_sign($expires);
    }

    public function putExternalMirrorValidate($operation)
    {
        if (!isset($operation['Elements']['source_site'])
        || ($operation['Elements']['source_site'] === ''
        || $operation['Elements']['source_site'] === array()
        || $operation['Elements']['source_site'] === null
    )) {
            throw new Exception\ParameterRequiredException('source_site', 'PutBucketExternalMirrorInput');
        }
    }

    /**
     * putPolicyRequest: Build PutPolicy's request.
     *
     * @link https://docs.qingcloud.com/qingstor/api/bucket/policy/put_policy.html Documentation URL
     *
     * @param array "statement" Bucket policy statement
     *
     * @return Signer
     */
    public function putPolicyRequest($options = array())
    {
        $operation = array(
            'Method' => 'PUT',
            'Uri' => '/<bucket-name>?policy',
            'Headers' => array(
                'Host' => $this->properties['zone'].'.'.$this->config->host,
            ),
            'Params' => array(
            ),
            'Elements' => array(
                'statement' => isset($options['statement']) ? $options['statement'] : null,
            ),
            'Properties' => $this->properties,
            'Body' => null,
        );
        $this->putPolicyValidate($operation);
        $builder = new Builder\QingStor($this->config, $operation);
        $request = $builder->parse();
        $signer = new Signer(
            $request,
            $this->config->access_key_id,
            $this->config->secret_access_key
        );

        return $signer;
    }

    /**
     * putPolicy: Set policy information of the bucket.
     *
     * @link https://docs.qingcloud.com/qingstor/api/bucket/policy/put_policy.html Documentation URL
     *
     * @param array "statement" Bucket policy statement
     *
     * @return \GuzzleHttp\Psr7\Response
     *
     * @throws \Exception
     */
    public function putPolicy($options = array())
    {
        $signer = $this->putPolicyRequest($options);
        $retries = $this->config->connection_retries;
        while (1) {
            try {
                $this->config->logger->info('Sending QingStor request: putPolicy');
                $response = $this->config->client->send(
                    $signer->sign()
                );
            } catch (\Exception $e) {
                $this->config->logger->error($e->getMessage());
                if ($retries > 0) {
                    $retries -= 1;
                } else {
                    throw new \Exception('Network Error');
                }
            }
            break;
        }

        return $response;
    }

    /**
     * putPolicyQuery: putPolicy's Query Sign Way.
     *
     * @link https://docs.qingcloud.com/qingstor/api/bucket/policy/put_policy.html Documentation URL
     *
     * @param array "statement" Bucket policy statement
     *
     * @return Signer
     */
    public function putPolicyQuery($expires, $options = array())
    {
        $signer = $this->putPolicyRequest($options);

        return $signer->query_sign($expires);
    }

    public function putPolicyValidate($operation)
    {
        if (!isset($operation['Elements']['statement'])
            || ($operation['Elements']['statement'] === ''
                || $operation['Elements']['statement'] === array()
                || $operation['Elements']['statement'] === null
                )
        ) {
            throw new Exception\ParameterRequiredException('statement', 'PutBucketPolicyInput');
        }
        foreach ($operation['Elements']['statement'] as $key) {
            if (!isset($key['action'])
            || ($key['action'] === ''
                || $key['action'] === array()
                || $key['action'] === null
                )
        ) {
                throw new Exception\ParameterRequiredException('action', 'statement');
            }
            if (!isset($key['condition'])
            || ($key['condition'] === ''
                || $key['condition'] === array()
                || $key['condition'] === null
               )
        ) {
                if (!isset($key['condition']['is_null'])
            || ($key['condition']['is_null'] === ''
                || $key['condition']['is_null'] === array()
                || $key['condition']['is_null'] === null
               )
        ) {
                }
                if (!isset($key['condition']['string_like'])
            || ($key['condition']['string_like'] === ''
                || $key['condition']['string_like'] === array()
                || $key['condition']['string_like'] === null
               )
        ) {
                }
                if (!isset($key['condition']['string_not_like'])
            || ($key['condition']['string_not_like'] === ''
                || $key['condition']['string_not_like'] === array()
                || $key['condition']['string_not_like'] === null
               )
        ) {
                }
            }
            if (!isset($key['effect'])
        || ($key['effect'] === ''
        || $key['effect'] === array()
        || $key['effect'] === null
    )) {
                throw new Exception\ParameterRequiredException('effect', 'statement');
            }
            if (!isset($key['effect'])
        || ($key['effect'] === ''
            || $key['effect'] === array()
            || $key['effect'] === null
            )
        ) {
                $effect_valid_values = array('allow', 'deny');
                if (in_array($key['effect'], $effect_valid_values)) {
                    throw new Exception\ParameterValueNotAllowedException(
                'effect',
                $key['effect'],
                $effect_valid_values
            );
                }
            }
            if (!isset($key['id'])
        || ($key['id'] === ''
        || $key['id'] === array()
        || $key['id'] === null
    )) {
                throw new Exception\ParameterRequiredException('id', 'statement');
            }
            if (!isset($key['resource'])
            || ($key['resource'] === ''
                || $key['resource'] === array()
                || $key['resource'] === null
                )
        ) {
                throw new Exception\ParameterRequiredException('resource', 'statement');
            }
            if (!isset($key['user'])
            || ($key['user'] === ''
                || $key['user'] === array()
                || $key['user'] === null
                )
        ) {
                throw new Exception\ParameterRequiredException('user', 'statement');
            }
        }
    }

    /**
     * abortMultipartUploadRequest: Build AbortMultipartUpload's request.
     *
     * @link https://docs.qingcloud.com/qingstor/api/object/abort_multipart_upload.html Documentation URL
     *
     * @param string "upload_id" Object multipart upload ID
     *
     * @return Signer
     */
    public function abortMultipartUploadRequest($object_key, $options = array())
    {
        $operation = array(
            'Method' => 'DELETE',
            'Uri' => '/<bucket-name>/<object-key>',
            'Headers' => array(
                'Host' => $this->properties['zone'].'.'.$this->config->host,
            ),
            'Params' => array(
                'upload_id' => isset($options['upload_id']) ? $options['upload_id'] : null,
            ),
            'Elements' => array(
            ),
            'Properties' => $this->properties,
            'Body' => null,
        );
        $operation['Properties']['object-key'] = $object_key;
        $this->abortMultipartUploadValidate($operation);
        $builder = new Builder\QingStor($this->config, $operation);
        $request = $builder->parse();
        $signer = new Signer(
            $request,
            $this->config->access_key_id,
            $this->config->secret_access_key
        );

        return $signer;
    }

    /**
     * abortMultipartUpload: Abort multipart upload.
     *
     * @link https://docs.qingcloud.com/qingstor/api/object/abort_multipart_upload.html Documentation URL
     *
     * @param string "upload_id" Object multipart upload ID
     * @params string $object_key
     *
     * @return \GuzzleHttp\Psr7\Response
     *
     * @throws \Exception
     */
    public function abortMultipartUpload($object_key, $options = array())
    {
        $signer = $this->abortMultipartUploadRequest($object_key, $options);
        $retries = $this->config->connection_retries;
        while (1) {
            try {
                $this->config->logger->info('Sending QingStor request: abortMultipartUpload');
                $response = $this->config->client->send(
                    $signer->sign()
                );
            } catch (\Exception $e) {
                $this->config->logger->error($e->getMessage());
                if ($retries > 0) {
                    $retries -= 1;
                } else {
                    throw new \Exception('Network Error');
                }
            }
            break;
        }

        return $response;
    }

    /**
     * abortMultipartUploadQuery: abortMultipartUpload's Query Sign Way.
     *
     * @link https://docs.qingcloud.com/qingstor/api/object/abort_multipart_upload.html Documentation URL
     *
     * @param string "upload_id" Object multipart upload ID
     *
     * @return Signer
     */
    public function abortMultipartUploadQuery($object_key, $expires, $options = array())
    {
        $signer = $this->abortMultipartUploadRequest($object_key, $options);

        return $signer->query_sign($expires);
    }

    public function abortMultipartUploadValidate($operation)
    {
        if (!isset($operation['Params']['upload_id'])
        || ($operation['Params']['upload_id'] === ''
        || $operation['Params']['upload_id'] === array()
        || $operation['Params']['upload_id'] === null
    )) {
            throw new Exception\ParameterRequiredException('upload_id', 'AbortMultipartUploadInput');
        }
    }

    /**
     * completeMultipartUploadRequest: Build CompleteMultipartUpload's request.
     *
     * @link https://docs.qingcloud.com/qingstor/api/object/complete_multipart_upload.html Documentation URL
     *
     * @param string "ETag" MD5sum of the object part
     * @param string "X-QS-Encryption-Customer-Algorithm" Encryption algorithm of the object
     * @param string "X-QS-Encryption-Customer-Key" Encryption key of the object
     * @param string "X-QS-Encryption-Customer-Key-MD5" MD5sum of encryption key
     * @param string "upload_id" Object multipart upload ID
     * @param array "object_parts" Object parts
     *
     * @return Signer
     */
    public function completeMultipartUploadRequest($object_key, $options = array())
    {
        $operation = array(
            'Method' => 'POST',
            'Uri' => '/<bucket-name>/<object-key>',
            'Headers' => array(
                'Host' => $this->properties['zone'].'.'.$this->config->host,
                'ETag' => isset($options['ETag']) ? $options['ETag'] : null,
                'X-QS-Encryption-Customer-Algorithm' => isset($options['X-QS-Encryption-Customer-Algorithm']) ? $options['X-QS-Encryption-Customer-Algorithm'] : null,
                'X-QS-Encryption-Customer-Key' => isset($options['X-QS-Encryption-Customer-Key']) ? $options['X-QS-Encryption-Customer-Key'] : null,
                'X-QS-Encryption-Customer-Key-MD5' => isset($options['X-QS-Encryption-Customer-Key-MD5']) ? $options['X-QS-Encryption-Customer-Key-MD5'] : null,
            ),
            'Params' => array(
                'upload_id' => isset($options['upload_id']) ? $options['upload_id'] : null,
            ),
            'Elements' => array(
                'object_parts' => isset($options['object_parts']) ? $options['object_parts'] : null,
            ),
            'Properties' => $this->properties,
            'Body' => null,
        );
        $operation['Properties']['object-key'] = $object_key;
        $this->completeMultipartUploadValidate($operation);
        $builder = new Builder\QingStor($this->config, $operation);
        $request = $builder->parse();
        $signer = new Signer(
            $request,
            $this->config->access_key_id,
            $this->config->secret_access_key
        );

        return $signer;
    }

    /**
     * completeMultipartUpload: Complete multipart upload.
     *
     * @link https://docs.qingcloud.com/qingstor/api/object/complete_multipart_upload.html Documentation URL
     *
     * @param string "ETag" MD5sum of the object part
     * @param string "X-QS-Encryption-Customer-Algorithm" Encryption algorithm of the object
     * @param string "X-QS-Encryption-Customer-Key" Encryption key of the object
     * @param string "X-QS-Encryption-Customer-Key-MD5" MD5sum of encryption key
     * @param string "upload_id" Object multipart upload ID
     * @param array "object_parts" Object parts
     * @params string $object_key
     *
     * @return \GuzzleHttp\Psr7\Response
     *
     * @throws \Exception
     */
    public function completeMultipartUpload($object_key, $options = array())
    {
        $signer = $this->completeMultipartUploadRequest($object_key, $options);
        $retries = $this->config->connection_retries;
        while (1) {
            try {
                $this->config->logger->info('Sending QingStor request: completeMultipartUpload');
                $response = $this->config->client->send(
                    $signer->sign()
                );
            } catch (\Exception $e) {
                $this->config->logger->error($e->getMessage());
                if ($retries > 0) {
                    $retries -= 1;
                } else {
                    throw new \Exception('Network Error');
                }
            }
            break;
        }

        return $response;
    }

    /**
     * completeMultipartUploadQuery: completeMultipartUpload's Query Sign Way.
     *
     * @link https://docs.qingcloud.com/qingstor/api/object/complete_multipart_upload.html Documentation URL
     *
     * @param string "ETag" MD5sum of the object part
     * @param string "X-QS-Encryption-Customer-Algorithm" Encryption algorithm of the object
     * @param string "X-QS-Encryption-Customer-Key" Encryption key of the object
     * @param string "X-QS-Encryption-Customer-Key-MD5" MD5sum of encryption key
     * @param string "upload_id" Object multipart upload ID
     * @param array "object_parts" Object parts
     *
     * @return Signer
     */
    public function completeMultipartUploadQuery($object_key, $expires, $options = array())
    {
        $signer = $this->completeMultipartUploadRequest($object_key, $options);

        return $signer->query_sign($expires);
    }

    public function completeMultipartUploadValidate($operation)
    {
        if (!isset($operation['Params']['upload_id'])
        || ($operation['Params']['upload_id'] === ''
        || $operation['Params']['upload_id'] === array()
        || $operation['Params']['upload_id'] === null
    )) {
            throw new Exception\ParameterRequiredException('upload_id', 'CompleteMultipartUploadInput');
        }
        foreach ($operation['Elements']['object_parts'] as $key) {
            if (!isset($key['part_number'])
        || ($key['part_number'] === ''
        || $key['part_number'] === array()
        || $key['part_number'] === null
    )) {
                throw new Exception\ParameterRequiredException('part_number', 'object_part');
            }
        }
    }

    /**
     * deleteObjectRequest: Build DeleteObject's request.
     *
     * @link https://docs.qingcloud.com/qingstor/api/object/delete.html Documentation URL
     *
     * @return Signer
     */
    public function deleteObjectRequest($object_key)
    {
        $operation = array(
            'Method' => 'DELETE',
            'Uri' => '/<bucket-name>/<object-key>',
            'Headers' => array(
                'Host' => $this->properties['zone'].'.'.$this->config->host,
            ),
            'Params' => array(
            ),
            'Elements' => array(
            ),
            'Properties' => $this->properties,
            'Body' => null,
        );
        $operation['Properties']['object-key'] = $object_key;
        $this->deleteObjectValidate($operation);
        $builder = new Builder\QingStor($this->config, $operation);
        $request = $builder->parse();
        $signer = new Signer(
            $request,
            $this->config->access_key_id,
            $this->config->secret_access_key
        );

        return $signer;
    }

    /**
     * deleteObject: Delete the object.
     *
     * @link https://docs.qingcloud.com/qingstor/api/object/delete.html Documentation URL
     * @params string $object_key
     *
     * @return \GuzzleHttp\Psr7\Response
     *
     * @throws \Exception
     */
    public function deleteObject($object_key)
    {
        $signer = $this->deleteObjectRequest($object_key);
        $retries = $this->config->connection_retries;
        while (1) {
            try {
                $this->config->logger->info('Sending QingStor request: deleteObject');
                $response = $this->config->client->send(
                    $signer->sign()
                );
            } catch (\Exception $e) {
                $this->config->logger->error($e->getMessage());
                if ($retries > 0) {
                    $retries -= 1;
                } else {
                    throw new \Exception('Network Error');
                }
            }
            break;
        }

        return $response;
    }

    /**
     * deleteObjectQuery: deleteObject's Query Sign Way.
     *
     * @link https://docs.qingcloud.com/qingstor/api/object/delete.html Documentation URL
     *
     * @return Signer
     */
    public function deleteObjectQuery($object_key, $expires)
    {
        $signer = $this->deleteObjectRequest($object_key);

        return $signer->query_sign($expires);
    }

    public function deleteObjectValidate($operation)
    {
    }

    /**
     * getObjectRequest: Build GetObject's request.
     *
     * @link https://docs.qingcloud.com/qingstor/api/object/get.html Documentation URL
     *
     * @param string "If-Match" Check whether the ETag matches
     * @param timestamp "If-Modified-Since" Check whether the object has been modified
     * @param string "If-None-Match" Check whether the ETag does not match
     * @param timestamp "If-Unmodified-Since" Check whether the object has not been modified
     * @param string "Range" Specified range of the object
     * @param string "X-QS-Encryption-Customer-Algorithm" Encryption algorithm of the object
     * @param string "X-QS-Encryption-Customer-Key" Encryption key of the object
     * @param string "X-QS-Encryption-Customer-Key-MD5" MD5sum of encryption key
     *
     * @return Signer
     */
    public function getObjectRequest($object_key, $options = array())
    {
        $operation = array(
            'Method' => 'GET',
            'Uri' => '/<bucket-name>/<object-key>',
            'Headers' => array(
                'Host' => $this->properties['zone'].'.'.$this->config->host,
                'If-Match' => isset($options['If-Match']) ? $options['If-Match'] : null,
                'If-Modified-Since' => isset($options['If-Modified-Since']) ? $options['If-Modified-Since'] : null,
                'If-None-Match' => isset($options['If-None-Match']) ? $options['If-None-Match'] : null,
                'If-Unmodified-Since' => isset($options['If-Unmodified-Since']) ? $options['If-Unmodified-Since'] : null,
                'Range' => isset($options['Range']) ? $options['Range'] : null,
                'X-QS-Encryption-Customer-Algorithm' => isset($options['X-QS-Encryption-Customer-Algorithm']) ? $options['X-QS-Encryption-Customer-Algorithm'] : null,
                'X-QS-Encryption-Customer-Key' => isset($options['X-QS-Encryption-Customer-Key']) ? $options['X-QS-Encryption-Customer-Key'] : null,
                'X-QS-Encryption-Customer-Key-MD5' => isset($options['X-QS-Encryption-Customer-Key-MD5']) ? $options['X-QS-Encryption-Customer-Key-MD5'] : null,
            ),
            'Params' => array(
            ),
            'Elements' => array(
            ),
            'Properties' => $this->properties,
            'Body' => null,
        );
        $operation['Properties']['object-key'] = $object_key;
        $this->getObjectValidate($operation);
        $builder = new Builder\QingStor($this->config, $operation);
        $request = $builder->parse();
        $signer = new Signer(
            $request,
            $this->config->access_key_id,
            $this->config->secret_access_key
        );

        return $signer;
    }

    /**
     * getObject: Retrieve the object.
     *
     * @link https://docs.qingcloud.com/qingstor/api/object/get.html Documentation URL
     *
     * @param string "If-Match" Check whether the ETag matches
     * @param timestamp "If-Modified-Since" Check whether the object has been modified
     * @param string "If-None-Match" Check whether the ETag does not match
     * @param timestamp "If-Unmodified-Since" Check whether the object has not been modified
     * @param string "Range" Specified range of the object
     * @param string "X-QS-Encryption-Customer-Algorithm" Encryption algorithm of the object
     * @param string "X-QS-Encryption-Customer-Key" Encryption key of the object
     * @param string "X-QS-Encryption-Customer-Key-MD5" MD5sum of encryption key
     * @params string $object_key
     *
     * @return \GuzzleHttp\Psr7\Response
     *
     * @throws \Exception
     */
    public function getObject($object_key, $options = array())
    {
        $signer = $this->getObjectRequest($object_key, $options);
        $retries = $this->config->connection_retries;
        while (1) {
            try {
                $this->config->logger->info('Sending QingStor request: getObject');
                $response = $this->config->client->send(
                    $signer->sign()
                );
            } catch (\Exception $e) {
                $this->config->logger->error($e->getMessage());
                if ($retries > 0) {
                    $retries -= 1;
                } else {
                    throw new \Exception('Network Error');
                }
            }
            break;
        }

        return $response;
    }

    /**
     * getObjectQuery: getObject's Query Sign Way.
     *
     * @link https://docs.qingcloud.com/qingstor/api/object/get.html Documentation URL
     *
     * @param string "If-Match" Check whether the ETag matches
     * @param timestamp "If-Modified-Since" Check whether the object has been modified
     * @param string "If-None-Match" Check whether the ETag does not match
     * @param timestamp "If-Unmodified-Since" Check whether the object has not been modified
     * @param string "Range" Specified range of the object
     * @param string "X-QS-Encryption-Customer-Algorithm" Encryption algorithm of the object
     * @param string "X-QS-Encryption-Customer-Key" Encryption key of the object
     * @param string "X-QS-Encryption-Customer-Key-MD5" MD5sum of encryption key
     *
     * @return Signer
     */
    public function getObjectQuery($object_key, $expires, $options = array())
    {
        $signer = $this->getObjectRequest($object_key, $options);

        return $signer->query_sign($expires);
    }

    public function getObjectValidate($operation)
    {
    }

    /**
     * headObjectRequest: Build HeadObject's request.
     *
     * @link https://docs.qingcloud.com/qingstor/api/object/head.html Documentation URL
     *
     * @param string "If-Match" Check whether the ETag matches
     * @param timestamp "If-Modified-Since" Check whether the object has been modified
     * @param string "If-None-Match" Check whether the ETag does not match
     * @param timestamp "If-Unmodified-Since" Check whether the object has not been modified
     * @param string "X-QS-Encryption-Customer-Algorithm" Encryption algorithm of the object
     * @param string "X-QS-Encryption-Customer-Key" Encryption key of the object
     * @param string "X-QS-Encryption-Customer-Key-MD5" MD5sum of encryption key
     *
     * @return Signer
     */
    public function headObjectRequest($object_key, $options = array())
    {
        $operation = array(
            'Method' => 'HEAD',
            'Uri' => '/<bucket-name>/<object-key>',
            'Headers' => array(
                'Host' => $this->properties['zone'].'.'.$this->config->host,
                'If-Match' => isset($options['If-Match']) ? $options['If-Match'] : null,
                'If-Modified-Since' => isset($options['If-Modified-Since']) ? $options['If-Modified-Since'] : null,
                'If-None-Match' => isset($options['If-None-Match']) ? $options['If-None-Match'] : null,
                'If-Unmodified-Since' => isset($options['If-Unmodified-Since']) ? $options['If-Unmodified-Since'] : null,
                'X-QS-Encryption-Customer-Algorithm' => isset($options['X-QS-Encryption-Customer-Algorithm']) ? $options['X-QS-Encryption-Customer-Algorithm'] : null,
                'X-QS-Encryption-Customer-Key' => isset($options['X-QS-Encryption-Customer-Key']) ? $options['X-QS-Encryption-Customer-Key'] : null,
                'X-QS-Encryption-Customer-Key-MD5' => isset($options['X-QS-Encryption-Customer-Key-MD5']) ? $options['X-QS-Encryption-Customer-Key-MD5'] : null,
            ),
            'Params' => array(
            ),
            'Elements' => array(
            ),
            'Properties' => $this->properties,
            'Body' => null,
        );
        $operation['Properties']['object-key'] = $object_key;
        $this->headObjectValidate($operation);
        $builder = new Builder\QingStor($this->config, $operation);
        $request = $builder->parse();
        $signer = new Signer(
            $request,
            $this->config->access_key_id,
            $this->config->secret_access_key
        );

        return $signer;
    }

    /**
     * headObject: Check whether the object exists and available.
     *
     * @link https://docs.qingcloud.com/qingstor/api/object/head.html Documentation URL
     *
     * @param string "If-Match" Check whether the ETag matches
     * @param timestamp "If-Modified-Since" Check whether the object has been modified
     * @param string "If-None-Match" Check whether the ETag does not match
     * @param timestamp "If-Unmodified-Since" Check whether the object has not been modified
     * @param string "X-QS-Encryption-Customer-Algorithm" Encryption algorithm of the object
     * @param string "X-QS-Encryption-Customer-Key" Encryption key of the object
     * @param string "X-QS-Encryption-Customer-Key-MD5" MD5sum of encryption key
     * @params string $object_key
     *
     * @return \GuzzleHttp\Psr7\Response
     *
     * @throws \Exception
     */
    public function headObject($object_key, $options = array())
    {
        $signer = $this->headObjectRequest($object_key, $options);
        $retries = $this->config->connection_retries;
        while (1) {
            try {
                $this->config->logger->info('Sending QingStor request: headObject');
                $response = $this->config->client->send(
                    $signer->sign()
                );
            } catch (\Exception $e) {
                $this->config->logger->error($e->getMessage());
                if ($retries > 0) {
                    $retries -= 1;
                } else {
                    throw new \Exception('Network Error');
                }
            }
            break;
        }

        return $response;
    }

    /**
     * headObjectQuery: headObject's Query Sign Way.
     *
     * @link https://docs.qingcloud.com/qingstor/api/object/head.html Documentation URL
     *
     * @param string "If-Match" Check whether the ETag matches
     * @param timestamp "If-Modified-Since" Check whether the object has been modified
     * @param string "If-None-Match" Check whether the ETag does not match
     * @param timestamp "If-Unmodified-Since" Check whether the object has not been modified
     * @param string "X-QS-Encryption-Customer-Algorithm" Encryption algorithm of the object
     * @param string "X-QS-Encryption-Customer-Key" Encryption key of the object
     * @param string "X-QS-Encryption-Customer-Key-MD5" MD5sum of encryption key
     *
     * @return Signer
     */
    public function headObjectQuery($object_key, $expires, $options = array())
    {
        $signer = $this->headObjectRequest($object_key, $options);

        return $signer->query_sign($expires);
    }

    public function headObjectValidate($operation)
    {
    }

    /**
     * initiateMultipartUploadRequest: Build InitiateMultipartUpload's request.
     *
     * @link https://docs.qingcloud.com/qingstor/api/object/initiate_multipart_upload.html Documentation URL
     *
     * @param string "Content-Type" Object content type
     * @param string "X-QS-Encryption-Customer-Algorithm" Encryption algorithm of the object
     * @param string "X-QS-Encryption-Customer-Key" Encryption key of the object
     * @param string "X-QS-Encryption-Customer-Key-MD5" MD5sum of encryption key
     *
     * @return Signer
     */
    public function initiateMultipartUploadRequest($object_key, $options = array())
    {
        $operation = array(
            'Method' => 'POST',
            'Uri' => '/<bucket-name>/<object-key>?uploads',
            'Headers' => array(
                'Host' => $this->properties['zone'].'.'.$this->config->host,
                'Content-Type' => isset($options['Content-Type']) ? $options['Content-Type'] : null,
                'X-QS-Encryption-Customer-Algorithm' => isset($options['X-QS-Encryption-Customer-Algorithm']) ? $options['X-QS-Encryption-Customer-Algorithm'] : null,
                'X-QS-Encryption-Customer-Key' => isset($options['X-QS-Encryption-Customer-Key']) ? $options['X-QS-Encryption-Customer-Key'] : null,
                'X-QS-Encryption-Customer-Key-MD5' => isset($options['X-QS-Encryption-Customer-Key-MD5']) ? $options['X-QS-Encryption-Customer-Key-MD5'] : null,
            ),
            'Params' => array(
            ),
            'Elements' => array(
            ),
            'Properties' => $this->properties,
            'Body' => null,
        );
        $operation['Properties']['object-key'] = $object_key;
        $this->initiateMultipartUploadValidate($operation);
        $builder = new Builder\QingStor($this->config, $operation);
        $request = $builder->parse();
        $signer = new Signer(
            $request,
            $this->config->access_key_id,
            $this->config->secret_access_key
        );

        return $signer;
    }

    /**
     * initiateMultipartUpload: Initial multipart upload on the object.
     *
     * @link https://docs.qingcloud.com/qingstor/api/object/initiate_multipart_upload.html Documentation URL
     *
     * @param string "Content-Type" Object content type
     * @param string "X-QS-Encryption-Customer-Algorithm" Encryption algorithm of the object
     * @param string "X-QS-Encryption-Customer-Key" Encryption key of the object
     * @param string "X-QS-Encryption-Customer-Key-MD5" MD5sum of encryption key
     * @params string $object_key
     *
     * @return \GuzzleHttp\Psr7\Response
     *
     * @throws \Exception
     */
    public function initiateMultipartUpload($object_key, $options = array())
    {
        $signer = $this->initiateMultipartUploadRequest($object_key, $options);
        $retries = $this->config->connection_retries;
        while (1) {
            try {
                $this->config->logger->info('Sending QingStor request: initiateMultipartUpload');
                $response = $this->config->client->send(
                    $signer->sign()
                );
            } catch (\Exception $e) {
                $this->config->logger->error($e->getMessage());
                if ($retries > 0) {
                    $retries -= 1;
                } else {
                    throw new \Exception('Network Error');
                }
            }
            break;
        }

        return $response;
    }

    /**
     * initiateMultipartUploadQuery: initiateMultipartUpload's Query Sign Way.
     *
     * @link https://docs.qingcloud.com/qingstor/api/object/initiate_multipart_upload.html Documentation URL
     *
     * @param string "Content-Type" Object content type
     * @param string "X-QS-Encryption-Customer-Algorithm" Encryption algorithm of the object
     * @param string "X-QS-Encryption-Customer-Key" Encryption key of the object
     * @param string "X-QS-Encryption-Customer-Key-MD5" MD5sum of encryption key
     *
     * @return Signer
     */
    public function initiateMultipartUploadQuery($object_key, $expires, $options = array())
    {
        $signer = $this->initiateMultipartUploadRequest($object_key, $options);

        return $signer->query_sign($expires);
    }

    public function initiateMultipartUploadValidate($operation)
    {
    }

    /**
     * listMultipartRequest: Build ListMultipart's request.
     *
     * @link https://docs.qingcloud.com/qingstor/api/object/list_multipart.html Documentation URL
     *
     * @param int "limit" Limit results count
     * @param int "part_number_marker" Object multipart upload part number
     * @param string "upload_id" Object multipart upload ID
     *
     * @return Signer
     */
    public function listMultipartRequest($object_key, $options = array())
    {
        $operation = array(
            'Method' => 'GET',
            'Uri' => '/<bucket-name>/<object-key>',
            'Headers' => array(
                'Host' => $this->properties['zone'].'.'.$this->config->host,
            ),
            'Params' => array(
                'limit' => isset($options['limit']) ? $options['limit'] : null,
                'part_number_marker' => isset($options['part_number_marker']) ? $options['part_number_marker'] : null,
                'upload_id' => isset($options['upload_id']) ? $options['upload_id'] : null,
            ),
            'Elements' => array(
            ),
            'Properties' => $this->properties,
            'Body' => null,
        );
        $operation['Properties']['object-key'] = $object_key;
        $this->listMultipartValidate($operation);
        $builder = new Builder\QingStor($this->config, $operation);
        $request = $builder->parse();
        $signer = new Signer(
            $request,
            $this->config->access_key_id,
            $this->config->secret_access_key
        );

        return $signer;
    }

    /**
     * listMultipart: List object parts.
     *
     * @link https://docs.qingcloud.com/qingstor/api/object/list_multipart.html Documentation URL
     *
     * @param int "limit" Limit results count
     * @param int "part_number_marker" Object multipart upload part number
     * @param string "upload_id" Object multipart upload ID
     * @params string $object_key
     *
     * @return \GuzzleHttp\Psr7\Response
     *
     * @throws \Exception
     */
    public function listMultipart($object_key, $options = array())
    {
        $signer = $this->listMultipartRequest($object_key, $options);
        $retries = $this->config->connection_retries;
        while (1) {
            try {
                $this->config->logger->info('Sending QingStor request: listMultipart');
                $response = $this->config->client->send(
                    $signer->sign()
                );
            } catch (\Exception $e) {
                $this->config->logger->error($e->getMessage());
                if ($retries > 0) {
                    $retries -= 1;
                } else {
                    throw new \Exception('Network Error');
                }
            }
            break;
        }

        return $response;
    }

    /**
     * listMultipartQuery: listMultipart's Query Sign Way.
     *
     * @link https://docs.qingcloud.com/qingstor/api/object/list_multipart.html Documentation URL
     *
     * @param int "limit" Limit results count
     * @param int "part_number_marker" Object multipart upload part number
     * @param string "upload_id" Object multipart upload ID
     *
     * @return Signer
     */
    public function listMultipartQuery($object_key, $expires, $options = array())
    {
        $signer = $this->listMultipartRequest($object_key, $options);

        return $signer->query_sign($expires);
    }

    public function listMultipartValidate($operation)
    {
        if (!isset($operation['Params']['upload_id'])
        || ($operation['Params']['upload_id'] === ''
        || $operation['Params']['upload_id'] === array()
        || $operation['Params']['upload_id'] === null
    )) {
            throw new Exception\ParameterRequiredException('upload_id', 'ListMultipartInput');
        }
    }

    /**
     * optionsObjectRequest: Build OptionsObject's request.
     *
     * @link https://docs.qingcloud.com/qingstor/api/object/options.html Documentation URL
     *
     * @param string "Access-Control-Request-Headers" Request headers
     * @param string "Access-Control-Request-Method" Request method
     * @param string "Origin" Request origin
     *
     * @return Signer
     */
    public function optionsObjectRequest($object_key, $options = array())
    {
        $operation = array(
            'Method' => 'OPTIONS',
            'Uri' => '/<bucket-name>/<object-key>',
            'Headers' => array(
                'Host' => $this->properties['zone'].'.'.$this->config->host,
                'Access-Control-Request-Headers' => isset($options['Access-Control-Request-Headers']) ? $options['Access-Control-Request-Headers'] : null,
                'Access-Control-Request-Method' => isset($options['Access-Control-Request-Method']) ? $options['Access-Control-Request-Method'] : null,
                'Origin' => isset($options['Origin']) ? $options['Origin'] : null,
            ),
            'Params' => array(
            ),
            'Elements' => array(
            ),
            'Properties' => $this->properties,
            'Body' => null,
        );
        $operation['Properties']['object-key'] = $object_key;
        $this->optionsObjectValidate($operation);
        $builder = new Builder\QingStor($this->config, $operation);
        $request = $builder->parse();
        $signer = new Signer(
            $request,
            $this->config->access_key_id,
            $this->config->secret_access_key
        );

        return $signer;
    }

    /**
     * optionsObject: Check whether the object accepts a origin with method and header.
     *
     * @link https://docs.qingcloud.com/qingstor/api/object/options.html Documentation URL
     *
     * @param string "Access-Control-Request-Headers" Request headers
     * @param string "Access-Control-Request-Method" Request method
     * @param string "Origin" Request origin
     * @params string $object_key
     *
     * @return \GuzzleHttp\Psr7\Response
     *
     * @throws \Exception
     */
    public function optionsObject($object_key, $options = array())
    {
        $signer = $this->optionsObjectRequest($object_key, $options);
        $retries = $this->config->connection_retries;
        while (1) {
            try {
                $this->config->logger->info('Sending QingStor request: optionsObject');
                $response = $this->config->client->send(
                    $signer->sign()
                );
            } catch (\Exception $e) {
                $this->config->logger->error($e->getMessage());
                if ($retries > 0) {
                    $retries -= 1;
                } else {
                    throw new \Exception('Network Error');
                }
            }
            break;
        }

        return $response;
    }

    /**
     * optionsObjectQuery: optionsObject's Query Sign Way.
     *
     * @link https://docs.qingcloud.com/qingstor/api/object/options.html Documentation URL
     *
     * @param string "Access-Control-Request-Headers" Request headers
     * @param string "Access-Control-Request-Method" Request method
     * @param string "Origin" Request origin
     *
     * @return Signer
     */
    public function optionsObjectQuery($object_key, $expires, $options = array())
    {
        $signer = $this->optionsObjectRequest($object_key, $options);

        return $signer->query_sign($expires);
    }

    public function optionsObjectValidate($operation)
    {
        if (!isset($operation['Headers']['Access-Control-Request-Method'])
        || ($operation['Headers']['Access-Control-Request-Method'] === ''
        || $operation['Headers']['Access-Control-Request-Method'] === array()
        || $operation['Headers']['Access-Control-Request-Method'] === null
    )) {
            throw new Exception\ParameterRequiredException('Access-Control-Request-Method', 'OptionsObjectInput');
        }
        if (!isset($operation['Headers']['Origin'])
        || ($operation['Headers']['Origin'] === ''
        || $operation['Headers']['Origin'] === array()
        || $operation['Headers']['Origin'] === null
    )) {
            throw new Exception\ParameterRequiredException('Origin', 'OptionsObjectInput');
        }
    }

    /**
     * putObjectRequest: Build PutObject's request.
     *
     * @link https://docs.qingcloud.com/qingstor/api/object/put.html Documentation URL
     *
     * @param int "Content-Length" Object content size
     * @param string "Content-MD5" Object MD5sum
     * @param string "Content-Type" Object content type
     * @param string "Expect" Used to indicate that particular server behaviors are required by the client
     * @param string "X-QS-Copy-Source" Copy source, format (/<bucket-name>/<object-key>)
     * @param string "X-QS-Copy-Source-Encryption-Customer-Algorithm" Encryption algorithm of the object
     * @param string "X-QS-Copy-Source-Encryption-Customer-Key" Encryption key of the object
     * @param string "X-QS-Copy-Source-Encryption-Customer-Key-MD5" MD5sum of encryption key
     * @param string "X-QS-Copy-Source-If-Match" Check whether the copy source matches
     * @param timestamp "X-QS-Copy-Source-If-Modified-Since" Check whether the copy source has been modified
     * @param string "X-QS-Copy-Source-If-None-Match" Check whether the copy source does not match
     * @param timestamp "X-QS-Copy-Source-If-Unmodified-Since" Check whether the copy source has not been modified
     * @param string "X-QS-Encryption-Customer-Algorithm" Encryption algorithm of the object
     * @param string "X-QS-Encryption-Customer-Key" Encryption key of the object
     * @param string "X-QS-Encryption-Customer-Key-MD5" MD5sum of encryption key
     * @param string "X-QS-Fetch-Source" Fetch source, should be a valid url
     * @param string "X-QS-Move-Source" Move source, format (/<bucket-name>/<object-key>)
     *
     * @return Signer
     */
    public function putObjectRequest($object_key, $options = array())
    {
        $operation = array(
            'Method' => 'PUT',
            'Uri' => '/<bucket-name>/<object-key>',
            'Headers' => array(
                'Host' => $this->properties['zone'].'.'.$this->config->host,
                'Content-Length' => isset($options['Content-Length']) ? $options['Content-Length'] : null,
                'Content-MD5' => isset($options['Content-MD5']) ? $options['Content-MD5'] : null,
                'Content-Type' => isset($options['Content-Type']) ? $options['Content-Type'] : null,
                'Expect' => isset($options['Expect']) ? $options['Expect'] : null,
                'X-QS-Copy-Source' => isset($options['X-QS-Copy-Source']) ? $options['X-QS-Copy-Source'] : null,
                'X-QS-Copy-Source-Encryption-Customer-Algorithm' => isset($options['X-QS-Copy-Source-Encryption-Customer-Algorithm']) ? $options['X-QS-Copy-Source-Encryption-Customer-Algorithm'] : null,
                'X-QS-Copy-Source-Encryption-Customer-Key' => isset($options['X-QS-Copy-Source-Encryption-Customer-Key']) ? $options['X-QS-Copy-Source-Encryption-Customer-Key'] : null,
                'X-QS-Copy-Source-Encryption-Customer-Key-MD5' => isset($options['X-QS-Copy-Source-Encryption-Customer-Key-MD5']) ? $options['X-QS-Copy-Source-Encryption-Customer-Key-MD5'] : null,
                'X-QS-Copy-Source-If-Match' => isset($options['X-QS-Copy-Source-If-Match']) ? $options['X-QS-Copy-Source-If-Match'] : null,
                'X-QS-Copy-Source-If-Modified-Since' => isset($options['X-QS-Copy-Source-If-Modified-Since']) ? $options['X-QS-Copy-Source-If-Modified-Since'] : null,
                'X-QS-Copy-Source-If-None-Match' => isset($options['X-QS-Copy-Source-If-None-Match']) ? $options['X-QS-Copy-Source-If-None-Match'] : null,
                'X-QS-Copy-Source-If-Unmodified-Since' => isset($options['X-QS-Copy-Source-If-Unmodified-Since']) ? $options['X-QS-Copy-Source-If-Unmodified-Since'] : null,
                'X-QS-Encryption-Customer-Algorithm' => isset($options['X-QS-Encryption-Customer-Algorithm']) ? $options['X-QS-Encryption-Customer-Algorithm'] : null,
                'X-QS-Encryption-Customer-Key' => isset($options['X-QS-Encryption-Customer-Key']) ? $options['X-QS-Encryption-Customer-Key'] : null,
                'X-QS-Encryption-Customer-Key-MD5' => isset($options['X-QS-Encryption-Customer-Key-MD5']) ? $options['X-QS-Encryption-Customer-Key-MD5'] : null,
                'X-QS-Fetch-Source' => isset($options['X-QS-Fetch-Source']) ? $options['X-QS-Fetch-Source'] : null,
                'X-QS-Move-Source' => isset($options['X-QS-Move-Source']) ? $options['X-QS-Move-Source'] : null,
            ),
            'Params' => array(
            ),
            'Elements' => array(
            ),
            'Properties' => $this->properties,
            'Body' => isset($options['body']) ? $options['body'] : '',
        );
        $operation['Properties']['object-key'] = $object_key;
        $this->putObjectValidate($operation);
        $builder = new Builder\QingStor($this->config, $operation);
        $request = $builder->parse();
        $signer = new Signer(
            $request,
            $this->config->access_key_id,
            $this->config->secret_access_key
        );

        return $signer;
    }

    /**
     * putObject: Upload the object.
     *
     * @link https://docs.qingcloud.com/qingstor/api/object/put.html Documentation URL
     *
     * @param int "Content-Length" Object content size
     * @param string "Content-MD5" Object MD5sum
     * @param string "Content-Type" Object content type
     * @param string "Expect" Used to indicate that particular server behaviors are required by the client
     * @param string "X-QS-Copy-Source" Copy source, format (/<bucket-name>/<object-key>)
     * @param string "X-QS-Copy-Source-Encryption-Customer-Algorithm" Encryption algorithm of the object
     * @param string "X-QS-Copy-Source-Encryption-Customer-Key" Encryption key of the object
     * @param string "X-QS-Copy-Source-Encryption-Customer-Key-MD5" MD5sum of encryption key
     * @param string "X-QS-Copy-Source-If-Match" Check whether the copy source matches
     * @param timestamp "X-QS-Copy-Source-If-Modified-Since" Check whether the copy source has been modified
     * @param string "X-QS-Copy-Source-If-None-Match" Check whether the copy source does not match
     * @param timestamp "X-QS-Copy-Source-If-Unmodified-Since" Check whether the copy source has not been modified
     * @param string "X-QS-Encryption-Customer-Algorithm" Encryption algorithm of the object
     * @param string "X-QS-Encryption-Customer-Key" Encryption key of the object
     * @param string "X-QS-Encryption-Customer-Key-MD5" MD5sum of encryption key
     * @param string "X-QS-Fetch-Source" Fetch source, should be a valid url
     * @param string "X-QS-Move-Source" Move source, format (/<bucket-name>/<object-key>)
     * @params string $object_key
     *
     * @return \GuzzleHttp\Psr7\Response
     *
     * @throws \Exception
     */
    public function putObject($object_key, $options = array())
    {
        $signer = $this->putObjectRequest($object_key, $options);
        $retries = $this->config->connection_retries;
        while (1) {
            try {
                $this->config->logger->info('Sending QingStor request: putObject');
                $response = $this->config->client->send(
                    $signer->sign()
                );
            } catch (\Exception $e) {
                $this->config->logger->error($e->getMessage());
                if ($retries > 0) {
                    $retries -= 1;
                } else {
                    throw new \Exception('Network Error');
                }
            }
            break;
        }

        return $response;
    }

    /**
     * putObjectQuery: putObject's Query Sign Way.
     *
     * @link https://docs.qingcloud.com/qingstor/api/object/put.html Documentation URL
     *
     * @param int "Content-Length" Object content size
     * @param string "Content-MD5" Object MD5sum
     * @param string "Content-Type" Object content type
     * @param string "Expect" Used to indicate that particular server behaviors are required by the client
     * @param string "X-QS-Copy-Source" Copy source, format (/<bucket-name>/<object-key>)
     * @param string "X-QS-Copy-Source-Encryption-Customer-Algorithm" Encryption algorithm of the object
     * @param string "X-QS-Copy-Source-Encryption-Customer-Key" Encryption key of the object
     * @param string "X-QS-Copy-Source-Encryption-Customer-Key-MD5" MD5sum of encryption key
     * @param string "X-QS-Copy-Source-If-Match" Check whether the copy source matches
     * @param timestamp "X-QS-Copy-Source-If-Modified-Since" Check whether the copy source has been modified
     * @param string "X-QS-Copy-Source-If-None-Match" Check whether the copy source does not match
     * @param timestamp "X-QS-Copy-Source-If-Unmodified-Since" Check whether the copy source has not been modified
     * @param string "X-QS-Encryption-Customer-Algorithm" Encryption algorithm of the object
     * @param string "X-QS-Encryption-Customer-Key" Encryption key of the object
     * @param string "X-QS-Encryption-Customer-Key-MD5" MD5sum of encryption key
     * @param string "X-QS-Fetch-Source" Fetch source, should be a valid url
     * @param string "X-QS-Move-Source" Move source, format (/<bucket-name>/<object-key>)
     *
     * @return Signer
     */
    public function putObjectQuery($object_key, $expires, $options = array())
    {
        $signer = $this->putObjectRequest($object_key, $options);

        return $signer->query_sign($expires);
    }

    public function putObjectValidate($operation)
    {
    }

    /**
     * uploadMultipartRequest: Build UploadMultipart's request.
     *
     * @link https://docs.qingcloud.com/qingstor/api/object/multipart/upload_multipart.html Documentation URL
     *
     * @param int "Content-Length" Object multipart content length
     * @param string "Content-MD5" Object multipart content MD5sum
     * @param string "X-QS-Encryption-Customer-Algorithm" Encryption algorithm of the object
     * @param string "X-QS-Encryption-Customer-Key" Encryption key of the object
     * @param string "X-QS-Encryption-Customer-Key-MD5" MD5sum of encryption key
     * @param int "part_number" Object multipart upload part number
     * @param string "upload_id" Object multipart upload ID
     *
     * @return Signer
     */
    public function uploadMultipartRequest($object_key, $options = array())
    {
        $operation = array(
            'Method' => 'PUT',
            'Uri' => '/<bucket-name>/<object-key>',
            'Headers' => array(
                'Host' => $this->properties['zone'].'.'.$this->config->host,
                'Content-Length' => isset($options['Content-Length']) ? $options['Content-Length'] : null,
                'Content-MD5' => isset($options['Content-MD5']) ? $options['Content-MD5'] : null,
                'X-QS-Encryption-Customer-Algorithm' => isset($options['X-QS-Encryption-Customer-Algorithm']) ? $options['X-QS-Encryption-Customer-Algorithm'] : null,
                'X-QS-Encryption-Customer-Key' => isset($options['X-QS-Encryption-Customer-Key']) ? $options['X-QS-Encryption-Customer-Key'] : null,
                'X-QS-Encryption-Customer-Key-MD5' => isset($options['X-QS-Encryption-Customer-Key-MD5']) ? $options['X-QS-Encryption-Customer-Key-MD5'] : null,
            ),
            'Params' => array(
                'part_number' => isset($options['part_number']) ? $options['part_number'] : null,
                'upload_id' => isset($options['upload_id']) ? $options['upload_id'] : null,
            ),
            'Elements' => array(
            ),
            'Properties' => $this->properties,
            'Body' => isset($options['body']) ? $options['body'] : '',
        );
        $operation['Properties']['object-key'] = $object_key;
        $this->uploadMultipartValidate($operation);
        $builder = new Builder\QingStor($this->config, $operation);
        $request = $builder->parse();
        $signer = new Signer(
            $request,
            $this->config->access_key_id,
            $this->config->secret_access_key
        );

        return $signer;
    }

    /**
     * uploadMultipart: Upload object multipart.
     *
     * @link https://docs.qingcloud.com/qingstor/api/object/multipart/upload_multipart.html Documentation URL
     *
     * @param int "Content-Length" Object multipart content length
     * @param string "Content-MD5" Object multipart content MD5sum
     * @param string "X-QS-Encryption-Customer-Algorithm" Encryption algorithm of the object
     * @param string "X-QS-Encryption-Customer-Key" Encryption key of the object
     * @param string "X-QS-Encryption-Customer-Key-MD5" MD5sum of encryption key
     * @param int "part_number" Object multipart upload part number
     * @param string "upload_id" Object multipart upload ID
     * @params string $object_key
     *
     * @return \GuzzleHttp\Psr7\Response
     *
     * @throws \Exception
     */
    public function uploadMultipart($object_key, $options = array())
    {
        $signer = $this->uploadMultipartRequest($object_key, $options);
        $retries = $this->config->connection_retries;
        while (1) {
            try {
                $this->config->logger->info('Sending QingStor request: uploadMultipart');
                $response = $this->config->client->send(
                    $signer->sign()
                );
            } catch (\Exception $e) {
                $this->config->logger->error($e->getMessage());
                if ($retries > 0) {
                    $retries -= 1;
                } else {
                    throw new \Exception('Network Error');
                }
            }
            break;
        }

        return $response;
    }

    /**
     * uploadMultipartQuery: uploadMultipart's Query Sign Way.
     *
     * @link https://docs.qingcloud.com/qingstor/api/object/multipart/upload_multipart.html Documentation URL
     *
     * @param int "Content-Length" Object multipart content length
     * @param string "Content-MD5" Object multipart content MD5sum
     * @param string "X-QS-Encryption-Customer-Algorithm" Encryption algorithm of the object
     * @param string "X-QS-Encryption-Customer-Key" Encryption key of the object
     * @param string "X-QS-Encryption-Customer-Key-MD5" MD5sum of encryption key
     * @param int "part_number" Object multipart upload part number
     * @param string "upload_id" Object multipart upload ID
     *
     * @return Signer
     */
    public function uploadMultipartQuery($object_key, $expires, $options = array())
    {
        $signer = $this->uploadMultipartRequest($object_key, $options);

        return $signer->query_sign($expires);
    }

    public function uploadMultipartValidate($operation)
    {
        if (!isset($operation['Params']['part_number'])
        || ($operation['Params']['part_number'] === ''
        || $operation['Params']['part_number'] === array()
        || $operation['Params']['part_number'] === null
    )) {
            throw new Exception\ParameterRequiredException('part_number', 'UploadMultipartInput');
        }
        if (!isset($operation['Params']['upload_id'])
        || ($operation['Params']['upload_id'] === ''
        || $operation['Params']['upload_id'] === array()
        || $operation['Params']['upload_id'] === null
    )) {
            throw new Exception\ParameterRequiredException('upload_id', 'UploadMultipartInput');
        }
    }
}
