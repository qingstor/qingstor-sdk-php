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

class Unpacker
{
    public function __construct($res)
    {
        $this->res = $res;
        $this->statusCode = $res->getStatusCode();
        $this->logger = Logger::getInstance();
        $this->unpackResponseHeaders();
        $this->unpackResponseBody();
    }

    public function unpackResponseHeaders()
    {
        foreach ($this->res->getHeaders() as $key => $value) {
            if (count($value) > 1) {
                $this->$key = $value;
            } else {
                $this->$key = $value[0];
            }
        }
        $this->logger->debug('Parse QingStor response headers: '.var_dump($this));
    }

    public function unpackResponseBody()
    {
        $body = $this->res->getBody();
        if ($this->{'Content-Type'} === 'application/json') {
            if ($body !== '') {
                $data = json_decode($body, true);
                foreach ($data as $key => $value) {
                    $this->$key = $value;
                }
            }
        } else {
            $this->body = $body;
        }
        $this->logger->debug('Parse QingStor response body: '.var_dump($this));
    }
}