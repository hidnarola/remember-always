<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');


class Googleplus {

    public function __construct($config) {
        $CI = & get_instance();
        require APPPATH . 'vendor/Google/autoload.php';
        $cache_path = $CI->config->item('cache_path');
        $GLOBALS['apiConfig']['ioFileCache_directory'] = ($cache_path == '') ? APPPATH . 'cache/' : $cache_path;

        $scopes = [
            'https://www.googleapis.com/auth/plus.login',
            'https://www.googleapis.com/auth/plus.me',
//            'https://www.googleapis.com/auth/plus.media.upload',
//            'https://www.googleapis.com/auth/plus.profiles.read',
//            'https://www.googleapis.com/auth/plus.stream.read',
//            'https://www.googleapis.com/auth/plus.stream.write',
            'https://www.googleapis.com/auth/userinfo.email',
//            'https://www.googleapis.com/auth/userinfo.profile'
        ];

        $this->client = new Google_Client();
        $this->client->setApplicationName($config['app_name']);
        $this->client->setClientId($config['client_id']);
        $this->client->setClientSecret($config['client_secret']);
        $this->client->setRedirectUri($config['redirect_uri']);
        $this->client->setDeveloperKey($config['api_key']);
        $this->client->setScopes($scopes);

        $this->plus = new Google_Service_Plus($this->client);
        
    }

    public function __get($name) {

        if (isset($this->plus->$name)) {
            return $this->plus->$name;
        }
        return false;
    }

    public function __call($name, $arguments) {

        if (method_exists($this->plus, $name)) {
            return call_user_func(array($this->plus, $name), $arguments);
        }
        return false;
    }

}

?>
