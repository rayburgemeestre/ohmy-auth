<?php namespace ohmy\Auth2\Flow\ThreeLegged;

/*
 * Copyright (c) 2014, Yahoo! Inc. All rights reserved.
 * Copyrights licensed under the New BSD License.
 * See the accompanying LICENSE file for terms.
 */

use ohmy\Auth\Promise,
    ohmy\Auth\Response;

class Access extends Promise {

    public function __construct($callback, $client=null) {
        parent::__construct($callback);
        $this->client = $client;
    }

    public function GET($url, $params=array(), $headers=array()) {
        $url = parse_url($url);
        if (isset($url['query'])) parse_str($url['query'], $params);
        return $this->request(
            'GET', 
            $url['scheme'].'://'.$url['host'].$url['path'],
            $params,
            $headers
        );
    }

    public function POST($url, $params=array(), $headers=array()) {
        $url = parse_url($url);
        if (isset($url['query'])) parse_str($url['query'], $params);
        return $this->request(
            'POST',
            $url['scheme'].'://'.$url['host'].$url['path'],
            $params,
            $headers
        );
    }

    private function request($method, $url, $params=null, $headers=null) {
        $params['access_token'] = $this->value['access_token'];
        return $this->client->{$method}($url, $params, $headers);
    }
}
