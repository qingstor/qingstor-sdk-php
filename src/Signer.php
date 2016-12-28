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

class Signer
{
    public $req;
    public $keyid;
    public $keysecret;
    public $logger;

    public function __construct(Request $req, $keyid, $keysecret)
    {
        $this->req = $req;
        $this->keyid = $keyid;
        $this->keysecret = $keysecret;
    }

    public function sign()
    {
        $req = $this->req->withHeader(
            'Authorization',
            'QS '.$this->keyid.':'.$this->getAuthorization()
        );

        return $req;
    }

    public function query_sign($expires)
    {
        $req = $this->req->withUri(
            $this->req->getUri()->withQuery(
                'signature='.$this->getQuerySignature($expires)
                .'&'.'access_key_id='.$this->keyid
                .'&'.'expires='.$expires
            )
        );

        return $req;
    }

    public function getContentMD5()
    {
        return $this->req->getHeaderLine('Content-MD5');
    }

    public function getContentType()
    {
        return $this->req->getHeaderLine('Content-Type');
    }

    public function getDate()
    {
        return $this->req->getHeaderLine('Date');
    }

    public function getCanonicalizedHeaders()
    {
        $header = $this->req->getHeaders();
        $keys = array();
        foreach ($header as $key => $value) {
            if (!strncasecmp(strtolower($key), 'x-qs-', 5)) {
                $keys[trim(strtolower($key))] = trim($value[0]);
            }
        }
        ksort($keys);
        $canonicalizedHeaders = '';
        if (count($keys) > 0) {
            foreach ($keys as $key => $value) {
                $canonicalizedHeaders = $canonicalizedHeaders.$key.':'.$value."\n";
            }
        }

        return $canonicalizedHeaders;
    }

    public function getCanonicalizedResource()
    {
        $path = $this->req->getUri()->getPath();
        $query = explode('&', $this->req->getUri()->getQuery());
        $keys = array();
        foreach ($query as $values) {
            $values = explode('=', $values);
            if ($this->isSubResource($values[0])) {
                if (count($values) > 1) {
                    $keys[] = $values[0].'='.urldecode($values[1]);
                } else {
                    $keys[] = $values[0];
                }
            }
        }
        sort($keys);
        $joinedKeys = implode('&', $keys);
        if ($joinedKeys !== '') {
            $path = $path.'?'.$joinedKeys;
        }

        return $path;
    }

    public function getAuthorization()
    {
        $string_to_sign = $this->req->getMethod()."\n"
            .$this->getContentMD5()."\n"
            .$this->getContentType()."\n"
            .$this->getDate()."\n"
            .$this->getCanonicalizedHeaders()
            .$this->getCanonicalizedResource();
        $GLOBALS['logger']->debug($string_to_sign);
        $sign = hash_hmac('sha256', $string_to_sign, $this->keysecret, true);
        $sign_b64 = base64_encode($sign);
        $GLOBALS['logger']->debug($sign_b64);

        return $sign_b64;
    }

    public function getQuerySignature($expires)
    {
        $string_to_sign = $this->req->getMethod()."\n"
            .$this->getContentMD5()."\n"
            .$this->getContentType()."\n"
            .$expires."\n"
            .$this->getCanonicalizedHeaders()
            .$this->getCanonicalizedResource();
        $GLOBALS['logger']->debug($string_to_sign);
        $sign = hash_hmac('sha256', $string_to_sign, $this->keysecret, true);
        $sign_b64 = urlencode(base64_encode($sign));
        $GLOBALS['logger']->debug($sign_b64);

        return $sign_b64;
    }

    public function isSubResource($key)
    {
        $keysMap = array(
            'acl',
            'cors',
            'delete',
            'mirror',
            'part_number',
            'policy',
            'stats',
            'upload_id',
            'uploads',
            'response-expires',
            'response-cache-control',
            'response-content-type',
            'response-content-language',
            'response-content-encoding',
            'response-content-disposition',
        );

        return in_array($key, $keysMap);
    }
}
