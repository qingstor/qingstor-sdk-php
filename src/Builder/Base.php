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

namespace QingStor\SDK\Builder;

use GuzzleHttp\Psr7\Request;

class Base
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
        $this->parseRequestHeaders();
        $this->parseRequestBody();
        $this->parseRequestProperties();
        $this->parseRequestURL();
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
        $this->parsedURL = $this->operation['Uri'];
    }
}
