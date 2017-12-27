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

    public function send_flower($url = null, $options = null) {
        if (isset($url) && !empty($url)) {
            $curl_options = array(CURLOPT_URL => $url,
                CURLOPT_HTTPHEADER => array("Authorization: {$this->auth}"),
                CURLOPT_RETURNTRANSFER => true);
                if($options != null && !empty($options) && is_array($options)){
                    foreach ($options as $key => $val){
                        $curl_options[$key] = $val;
                     }
                }
            curl_setopt_array($this->ch, $curl_options);

            $output = json_decode(curl_exec($this->ch));
            curl_close($this->ch);
        } else {
            $output = json_decode(json_encode(array('errors' => 'Please pass url'), JSON_FORCE_OBJECT));
        }
        return $output;
    }

}
