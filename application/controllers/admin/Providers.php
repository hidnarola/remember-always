<?php

/**
 * Providers Controller to manage service providers
 * @author KU 
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Providers extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('admin/providers_model');
    }

    /**
     * Display listing of service provider
     */
    public function index() {

        $data['title'] = 'Remember Always Admin | Service Providers';
        $this->template->load('admin', 'admin/service_providers/list_providers', $data);
    }

    /**
     * Get providers data for AJAX table
     * */
    public function get_providers() {
        $final['recordsFiltered'] = $final['recordsTotal'] = $this->providers_model->get_providers('count');
        $final['redraw'] = 1;
        $providers = $this->providers_model->get_providers('result');
        $start = $this->input->get('start') + 1;
        foreach ($providers as $key => $val) {
            $providers[$key] = $val;
            $providers[$key]['sr_no'] = $start;
            $providers[$key]['created_at'] = date('m/d/Y', strtotime($val['created']));
            $start++;
        }

        $final['data'] = $providers;
        echo json_encode($final);
    }

}
