<?php

/**
 * Providers Controller to manage service providers
 * @author KU 
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Providers extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('admin/provider_model');
    }

    /**
     * Display listing of service provider
     */
    public function index() {

        $data['title'] = 'Remember Always Admin | Service Providers';
        $this->template->load('admin', 'admin/service-providers/index', $data);
    }

}
