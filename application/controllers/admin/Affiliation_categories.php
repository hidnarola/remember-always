<?php

/**
 * Categories Controller for Affiliation provider categories
 * @author AKK 
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Affiliation_categories extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('admin/category_model');
    }

    /**
     * Display login page for login
     */
    public function index() {

        $this->data['title'] = 'Remember Always Admin | Affiliation Category';
        $this->template->load('admin', 'admin/affiliation_category/index', $this->data);
    }

    /**
     * Display login page for login
     */
    public function get_affiliation_categories() {
        $final['recordsFiltered'] = $final['recordsTotal'] = $this->category_model->get_all_affiliation_categories('count');
        $final['redraw'] = 1;
        $donors = $this->category_model->get_all_affiliation_categories('result');
        $final['data'] = $donors;
        echo json_encode($final);
    }

    /**
     * Add a new allifiation catgeory.
     *
     */
    public function add($id = null) {
        $uniqe_category_str = '';
        if (!is_null($id))
            $id = base64_decode($id);
        if (is_numeric($id)) {
            $category = $this->category_model->sql_select(TBL_AFFILIATIONS_CATEGORY, null, ['where' => array('id' => trim($id), 'is_delete' => 0)], ['single' => true]);
            if (!empty($category)) {
                $this->data['category'] = $category;
                $this->data['title'] = 'Remember Always Admin | Affiliation Category';
                $this->data['heading'] = 'Edit Affiliation Category';
            } else {
                custom_show_404();
            }
        } else {
            $this->data['title'] = 'Remember Always Admin | Affiliation Category';
            $this->data['heading'] = 'Add Affiliation Category';
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
                $dataArr['modified_at'] = date('Y-m-d H:i:s');
                $this->category_model->common_insert_update('update', TBL_AFFILIATIONS_CATEGORY, $dataArr, ['id' => $id]);
                $this->session->set_flashdata('success', 'Affiliation Categorty details has been updated successfully.');
            } else {
                $dataArr['created_at'] = date('Y-m-d H:i:s');
                $id = $this->category_model->common_insert_update('insert', TBL_AFFILIATIONS_CATEGORY, $dataArr);
                $this->session->set_flashdata('success', 'Affiliation Categorty has been inserted successfully.');
            }
            redirect('admin/affiliation_categories');
        }
        $this->template->load('admin', 'admin/affiliation_category/manage', $this->data);
    }

    /**
     * Edit a allifiation catgeory.
     *
     */
    public function edit($id) {
        $this->add($id);
    }

    /**
     * Delete allifiation category
     * @param int $id
     * */
    public function delete($id = NULL) {
        $id = base64_decode($id);
        if (is_numeric($id)) {
            $category = $this->category_model->sql_select(TBL_AFFILIATIONS_CATEGORY, null, ['where' => array('id' => trim($id), 'is_delete' => 0)], ['single' => true]);
            if (!empty($category)) {
                $update_array = array(
                'is_delete' => 1,
                'modified_at' => date('Y-m-d H:i:s')
                );
                $this->category_model->common_insert_update('update', TBL_AFFILIATIONS_CATEGORY, $update_array, ['id' => $id]);
                $this->session->set_flashdata('success', 'Affiliation categories has been deleted successfully!');
            } else {
                $this->session->set_flashdata('error', 'Unable to delete allifiation categories!');
            }
        }
        redirect('admin/affiliation_categories');
    }

    /**
     * Callback Validate function to check allifiation category already exists or not.
     * @return boolean
     */
    public function catgeory_exists($value) {
//        p($value);
        $result = $this->category_model->sql_select(TBL_AFFILIATIONS_CATEGORY, 'name', ['where' => array('name' => trim($value), 'is_delete' => 0)], ['single' => true]);
//        p($result, 1);
        if (!empty($result)) {
            if (trim($value) != $result['name']) {
                return TRUE;
            } else {
                $this->form_validation->set_message('catgeory_exists', 'Affiliation category already exists.');
                return FALSE;
            }
        } else {
            return TRUE;
        }
    }

}
