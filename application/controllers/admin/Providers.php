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
        $this->template->load('admin', 'admin/service_providers/index', $data);
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
            $providers[$key]['created_at'] = date('m/d/Y', strtotime($val['created_at']));
            $start++;
        }

        $final['data'] = $providers;
        echo json_encode($final);
    }

    /**
     * Add a new service provider.
     *
     */
    public function add($id = null) {
        if (!is_null($id))
            $id = base64_decode($id);
        if (is_numeric($id)) {
            $provider_data = $this->providers_model->sql_select(TBL_SERVICE_PROVIDERS, null, ['where' => array('id' => trim($id), 'is_delete' => 0)], ['single' => true]);
            if (!empty($provider_data)) {
                $this->data['provider_data'] = $provider_data;
                $this->data['title'] = 'Remember Always Admin | Service Providers';
                $this->data['heading'] = 'Edit Service Provider';
            } else {
                custom_show_404();
            }
        } else {
            $this->data['title'] = 'Remember Always Admin | Service Providers';
            $this->data['heading'] = 'Add Service Provider';
        }

        $service_categories = $this->providers_model->sql_select(TBL_SERVICE_CATEGORIES, null, ['where' => array('is_delete' => 0)]);
        $this->data['service_categories'] = $service_categories;

        $this->form_validation->set_rules('service_category', 'Service Category', 'trim|required');
        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        $this->form_validation->set_rules('description', 'Description', 'trim|required');
        $this->form_validation->set_rules('location', 'Location', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $this->data['error'] = validation_errors();
        } else {
//            p($this->input->post(), 1);
            $flag = 0;
            $dataArr = [
                'service_category_id' => trim(htmlentities($this->input->post('service_category'))),
                'name' => trim(htmlentities($this->input->post('name'))),
                'description' => $this->input->post('description'),
                'location' => trim($this->input->post('location')),
                'latitute' => $this->input->post('latitute'),
                'longitute' => $this->input->post('longitute'),
            ];
            if (!empty($this->input->post('zipcode'))) {
                $dataArr['zipcode'] = $this->input->post('zipcode');
            }
            if (is_numeric($id)) {
                $dataArr['modified_at'] = date('Y-m-d H:i:s');
                $this->providers_model->common_insert_update('update', TBL_SERVICE_PROVIDERS, $dataArr, ['id' => $id]);
                $this->session->set_flashdata('success', 'Service Provider details has been updated successfully.');
            } else {
                $dataArr['created_at'] = date('Y-m-d H:i:s');
                $id = $this->providers_model->common_insert_update('insert', TBL_SERVICE_PROVIDERS, $dataArr);
                $this->session->set_flashdata('success', 'Service Provider details has been inserted successfully.');
            }
            redirect('admin/providers');
        }
        $this->template->load('admin', 'admin/service_providers/manage', $this->data);
    }
    
     /**
     * view a service provider .
     *
     */
    public function edit($id) {
        $this->add($id);
    }
    
    /**
     * Edit a Service Provider.
     *
     */
    public function view($id) {
         
        if (!is_null($id))
            $id = base64_decode($id);
        if (is_numeric($id)) {
            $this->data['title'] = 'Remember Always Admin | Service Providers';
            $this->data['heading'] = 'View Service Provider Details';
            $provider_data = $this->providers_model->sql_select(TBL_SERVICE_PROVIDERS, null, ['where' => array('id' => trim($id), 'is_delete' => 0)], ['single' => true]);
            if (!empty($provider_data)) {
                $this->data['provider_data'] = $provider_data;
            } else {
                custom_show_404();
            }
            $this->template->load('admin', 'admin/service_providers/view', $this->data);
        } else {
            custom_show_404();
        }
    }
}
