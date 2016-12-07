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

namespace QingStor\SDK;

use GuzzleHttp\Psr7\Request;

class Builder
{
    public $config = null;
    public $parsedURL = null;
    public $parsedParams = null;
    public $parsedHeaders = null;
    public $parsedProperties = null;
    public $parsedBody = null;
    public $operation = null;
    public $request;

    public function __construct($config, $operation)
    {
        $this->config = $config;
        $this->operation = $operation;
    }

    public function parse()
    {
        $this->parseRequestParams();
        $this->parseRequestProperties();
        $this->parseRequestURL();
        $this->parseRequestBody();
        $this->parseRequestHeaders();
        $this->request = new Request(
            $this->operation['Method'],
            $this->parsedURL,
            $this->parsedHeaders,
            $this->parsedBody
        );

        return $this->request;
    }

    public function parseRequestParams()
    {
        foreach ($this->operation['Params'] as $key => $value) {
            if ($value !== '' && $value !== array() && $value !== null) {
                $this->parsedParams[$key] = $value;
            }
        }
    }

    public function parseRequestHeaders()
    {
        foreach ($this->operation['Headers'] as $key => $value) {
            if ($value !== '' && $value !== array() && $value !== null) {
                $this->parsedHeaders[$key] = $value;
            }
        }
        $this->parsedHeaders['Date'] = isset($this->operation['Headers']['Date']) ? $this->operation['Headers']['Date'] : gmdate('D, d M Y H:i:s T');
        $this->parsedHeaders['User-Agent'] = sprintf(
            'qingstor-sdk-php/%s  (PHP v%s; %s)',
            $GLOBALS['version'],
            phpversion(),
            php_uname('s')
        );
        $this->parsedHeaders['Content-Type'] = isset($this->operation['Headers']['Content-Type']) ? $this->operation['Headers']['Content-Type'] : \GuzzleHttp\Psr7\mimetype_from_filename($this->parsedURL);
        if ($this->parsedHeaders['Content-Type'] === null) {
            $this->parsedHeaders['Content-Type'] = 'application/octet-stream';
        }
    }

    public function parseRequestBody()
    {
        if (!empty($this->operation['Body'])) {
            $this->parsedBody = $this->operation['Body'];
            $this->parsedHeaders['Content-Length'] = strlen($this->parsedBody);
        } elseif (!empty($this->operation['Elements'])) {
            $this->parsedBody = json_encode($this->operation['Elements']);
            $this->parsedHeaders['Content-Length'] = strlen($this->parsedBody);
        }
    }

    public function parseRequestProperties()
    {
        foreach ($this->operation['Properties'] as $key => $value) {
            if ($value !== '' && $value !== array() && $value !== null) {
                $this->parsedProperties[$key] = $value;
            }
        }
    }

    public function parseRequestURL()
    {
        $properties = $this->parsedProperties;
        if (isset($properties['zone'])) {
            $zone = $properties['zone'];
        } else {
            $zone = '';
        }
        $port = strval($this->config->port);
        $endpoint = $this->config->protocol.'://'.$this->config->host.':'.$port;
        if ($zone !== '') {
            $endpoint = $this->config->protocol.'://'.$zone.'.'.$this->config->host.':'.$port;
        }
        $requestURI = $this->operation['Uri'];
        if (count($properties)) {
            foreach ($properties as $key => $value) {
                $endpoint = str_replace('<'.$key.'>', $value, $endpoint);
                $requestURI = str_replace('<'.$key.'>', $value, $requestURI);
            }
        }
        $this->parsedURL = $endpoint.$requestURI;
        if (count($this->parsedParams)) {
            $paramsParts = array();
            foreach ($this->parsedParams as $key => $value) {
                $paramsParts[] = $key.'='.$value;
            }
            $joined = implode('&', $paramsParts);
            if ($joined) {
                $this->parsedURL = $this->parsedURL.'?'.$joined;
            }
        }
    }
}
