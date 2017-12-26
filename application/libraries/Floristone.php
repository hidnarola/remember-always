<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Floristone {

    public function __construct() {
        $this->ch = curl_init();
        $this->username = TEST_API_KEY;
        $this->password = TEST_PASSWORD;
        $this->auth = base64_encode("{$this->username}:{$this->password}");
    }

    public function send_flower($url = null) {
        if (isset($url) && !empty($url)) {
            curl_setopt_array(
                    $this->ch, array(
                CURLOPT_URL => $url,
//            CURLOPT_URL => "https://www.floristone.com/api/rest/flowershop/getproducts?code=T50-3A",
                CURLOPT_HTTPHEADER => array("Authorization: {$this->auth}"),
                CURLOPT_RETURNTRANSFER => true)
            );
            $output = json_decode(curl_exec($this->ch));
            curl_close($this->ch);
        } else {
            $output = json_decode(json_encode(array('errors' => 'Please pass url'), JSON_FORCE_OBJECT));
        }
        return $output;
    }
}
