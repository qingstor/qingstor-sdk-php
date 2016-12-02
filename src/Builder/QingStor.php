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

class QingStor extends Base
{
    public function __construct($config, $operation)
    {
        parent::__construct($config, $operation);
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
