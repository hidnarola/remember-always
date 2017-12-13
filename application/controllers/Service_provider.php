<?php

/**
 * Service Provider Controller
 * Manage profile related functions
 * @author KU 
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Service_provider extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('providers_model');
    }

    /**
     * Display login page for login
     */
    public function index() {
        $service_categories = $this->providers_model->sql_select(TBL_SERVICE_CATEGORIES, '*', ['where' => ['is_delete' => 0]]);
        $services = $this->providers_model->get_providers('result', $this->input->get());

        $data['service_categories'] = $service_categories;
        $data['services'] = $services;
        $data['title'] = 'Services Provider Directory';
        $data['breadcrumb'] = ['title' => 'Services Provider Directory', 'links' => [['link' => site_url(), 'title' => 'Home']]];
        $this->template->load('default', 'service_provider/index', $data);
    }

}
