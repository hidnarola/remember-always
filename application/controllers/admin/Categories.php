<?php

/**
 * Categories Controller for Service provider categories and Affiliation categories
 * @author AKK 
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Categories extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('admin/category_model');
    }

    /**
     * Display service categories listing page
     */
    public function index() {

        $this->data['title'] = 'Remember Always Admin | Service Category';
        $this->template->load('admin', 'admin/category/index', $this->data);
    }

    /**
     * Get category list for Ajax data table
     */
    public function get_categories() {
        $final['recordsFiltered'] = $final['recordsTotal'] = $this->category_model->get_all_categories('count');
        $final['redraw'] = 1;
        $start = $this->input->get('start') + 1;
        $categories = $this->category_model->get_all_categories('result');
        foreach ($categories as $key => $cat) {
            $categories[$key]['test_id'] = $start++;
        }
        $final['data'] = $categories;
        echo json_encode($final);
    }

    /**
     * Add a new service provider category.
     *
     */
    public function add($id = null) {
        $uniqe_category_str = '';
        if (!is_null($id))
            $id = base64_decode($id);
        if (is_numeric($id)) {
            $category = $this->category_model->sql_select(TBL_SERVICE_CATEGORIES, null, ['where' => array('id' => trim($id), 'is_delete' => 0)], ['single' => true]);
            if (!empty($category)) {
                $this->data['category'] = $category;
                $this->data['title'] = 'Remember Always Admin | Service Category';
                $this->data['heading'] = 'Edit Service Provider Category';
            } else {
                custom_show_404();
            }
        } else {
            $this->data['title'] = 'Remember Always Admin | Service Category';
            $this->data['heading'] = 'Add Service Provider Category';
        }
        if (strtolower($this->input->method()) == 'post') {
            if (is_numeric($id)) {
                if (!empty($category) && $category['name'] != trim(htmlentities($this->input->post('name')))) {
                    $uniqe_category_str = '|callback_catgeory_exists';
                }
            } else {
                $uniqe_category_str = '|callback_catgeory_exists';
            }
        }
        $this->form_validation->set_rules('name', 'Name', 'trim|required' . $uniqe_category_str);
        if ($this->form_validation->run() == FALSE) {
            $this->data['error'] = validation_errors();
        } else {
            $dataArr = ['name' => trim(htmlentities($this->input->post('name')))];
            if (is_numeric($id)) {
                $dataArr['updated_at'] = date('Y-m-d H:i:s');
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
     * Edit a service provider category.
     *
     */
    public function edit($id) {
        $this->add($id);
    }

    /**
     * Delete service category
     * @param int $id
     * */
    public function delete($id = NULL) {
        $id = base64_decode($id);
        if (is_numeric($id)) {
            $category = $this->category_model->sql_select(TBL_SERVICE_CATEGORIES, null, ['where' => array('id' => trim($id), 'is_delete' => 0)], ['single' => true]);
            if (!empty($category)) {
                $update_array = array(
                    'is_delete' => 1,
                    'updated_at' => date('Y-m-d H:i:s')
                );
                $this->category_model->common_insert_update('update', TBL_SERVICE_CATEGORIES, $update_array, ['id' => $id]);
                $this->session->set_flashdata('success', 'Service categories has been deleted successfully!');
            } else {
                $this->session->set_flashdata('error', 'Unable to delete service categories!');
            }
        }
        redirect('admin/categories');
    }

    /**
     * Callback Validate function to check service category already exists or not.
     * @return boolean
     */
    public function catgeory_exists($value) {
        $result = $this->category_model->sql_select(TBL_SERVICE_CATEGORIES, 'name', ['where' => array('name' => trim($value), 'is_delete' => 0)], ['single' => true]);
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
