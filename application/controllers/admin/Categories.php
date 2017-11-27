<?php

/**
 * Login Controller for Administrator Login
 * @author KU 
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Categories extends MY_Controller {

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
//        foreach ($donors as $key => $val) {
//            $donors[$key] = $val;
//            $donors[$key]['created'] = date('m/d/Y', strtotime($val['created']));
//        }

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
            $category = $this->category_model->sql_select(TBL_SERVICE_CATEGORIES, null, ['where' => array('id' => trim($id), 'is_delete' => 0)], ['single' => true]);
            if (!empty($category)) {
                $this->data['category'] = $category;
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
            $dataArr = ['name' => trim($this->input->post('name'))];
            if (is_numeric($id)) {
                $dataArr['modified_at'] = date('Y-m-d H:i:s');
                $this->category_model->common_insert_update('update', TBL_SERVICE_CATEGORIES, $dataArr, ['id' => $id]);
                $this->session->set_flashdata('success', 'Service Categirty details has been updated successfully.');
            } else {
                $dataArr['created_at'] = date('Y-m-d H:i:s');
                $id = $this->category_model->common_insert_update('insert', TBL_SERVICE_CATEGORIES, $dataArr);
                $this->session->set_flashdata('success', 'Service Categirty has been inserted successfully.');
            }
            redirect('admin/categories');
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
//        p($value);
        $result = $this->category_model->sql_select(TBL_SERVICE_CATEGORIES, 'name', ['where' => array('name' => trim($value), 'is_delete' => 0)], ['single' => true]);
//        p($result, 1);
        if (!empty($result)) {
            if (trim($value) != $result['name']) {
                return TRUE;
            } else {
                $this->form_validation->set_message('catgeory_exists', 'Service category already exists.');
                return FALSE;
            }
        } else {
            return TRUE;
        }
    }

}
