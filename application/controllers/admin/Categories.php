<?php

/**
 * Login Controller for Administrator Login
 * @author KU 
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Categories extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('admin/category_model');
    }

    /**
     * Display login page for login
     */
    public function index() {

        $this->data['title'] = 'Remember Always Admin | Service Category';
        $this->template->load('admin', 'admin/category/index', $this->data);
    }

    /**
     * Display login page for login
     */
    public function get_categories() {
        $final['recordsFiltered'] = $final['recordsTotal'] = $this->category_model->get_all_categories('count');
        $final['redraw'] = 1;
        $donors = $this->category_model->get_all_categories('result');
        foreach ($donors as $key => $val) {
            $donors[$key] = $val;
            $donors[$key]['created'] = date('m/d/Y', strtotime($val['created']));
        }

        $final['data'] = $donors;
        echo json_encode($final);
    }

    /**
     * Add a new service catgeory.
     *
     */
    public function add($id = null) {

        if (!is_null($id))
            $id = base64_decode($id);
        if (is_numeric($id)) {
            $donor = $this->donors_model->get_donor_details($id);
            if (!empty($donor)) {
                $this->data['title'] = 'Remember Always Admin | Service Category';
                $this->data['heading'] = 'Edit Service Category';
            } else {
                show_404();
            }
        } else {
            $this->data['title'] = 'Remember Always Admin | Service Category';
            $this->data['heading'] = 'Add Service Category';
        }
        $this->form_validation->set_rules('name', 'Name', 'trim|required|callback_catgeory_exists');
        if ($this->form_validation->run() == FALSE) {
            $this->data['error'] = validation_errors();
        } else {
            
        }
        $this->template->load('admin', 'admin/category/manage', $this->data);
    }

    /**
     * Edit a service catgeory.
     *
     */
    public function edit($id) {
        $this->add($id);
    }

    /**
     * Callback Validate function to check service category already exists or not.
     * @return boolean
     */
    public function catgeory_exists($value) {
        p($value);
        $result = $this->category_model->get_all_details('service_categories', ['name' => trim($value)]);
        p($result);
        if (!empty($result)) {
            if (trim($value) != $result['name']) {
                $this->form_validation->set_message('catgeory_exists', 'Service category already exists.');
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return TRUE;
        }
    }

}
