<?php

/**
 * Login Controller for Administrator Login
 * @author KU 
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('admin/pages_model');
    }

    /**
     * Display login page for login
     */
    public function index() {

        $this->data['title'] = 'Remember Always Admin | Pages';
        $this->template->load('admin', 'admin/pages/index', $this->data);
    }

    /**
     * Display login page for login
     */
    public function get_pages() {
        $final['recordsFiltered'] = $final['recordsTotal'] = $this->pages_model->get_all_pages('count');
        $final['redraw'] = 1;
        $sliders = $this->pages_model->get_all_pages('result');
        $final['data'] = $sliders;
        echo json_encode($final);
    }

    /**
     * Add a new slider .
     *
     */
    public function add($id = null) {
        if (!is_null($id))
            $id = base64_decode($id);
        if (is_numeric($id)) {
            $page_data = $this->pages_model->sql_select(TBL_PAGES, null, ['where' => array('id' => trim($id), 'is_delete' => 0)], ['single' => true]);
            if (!empty($page_data)) {
                $this->data['page_data'] = $page_data;
                $this->data['title'] = 'Remember Always Admin | Pages';
                $this->data['heading'] = 'Edit Page';
            } else {
                custom_show_404();
            }
        } else {
            $this->data['title'] = 'Remember Always Admin | Pages';
            $this->data['heading'] = 'Add Page';
        }
        $this->form_validation->set_rules('navigation_name', 'Navigation name', 'trim|required');
        $this->form_validation->set_rules('title', 'Title', 'trim|required');
        $this->form_validation->set_rules('description', 'Description', 'trim|required');
        $this->form_validation->set_rules('meta_title', 'SEO meta title', 'trim|required');
        $this->form_validation->set_rules('meta_keyword', 'SEO meta keyword', 'trim|required');
        $this->form_validation->set_rules('meta_description', 'SEO meta description', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $this->data['error'] = validation_errors();
        } else {
            $flag = 0;
            $dataArr = [
                'navigation_name' => trim(htmlentities($this->input->post('navigation_name'))),
                'title' => trim(htmlentities($this->input->post('title'))),
                'description' => $this->input->post('description'),
                'meta_title' => trim(htmlentities($this->input->post('meta_title'))),
                'meta_keyword' => trim(htmlentities($this->input->post('meta_keyword'))),
                'meta_description' => trim(htmlentities($this->input->post('meta_description'))),
            ];
            if (!empty($_FILES['banner_image']['name'])) {
                $image_name = upload_image('banner_image', PAGE_BANNER);
                if (is_array($image_name)) {
                    $this->data['profile_image_validation'] = $image_name['errors'];
                } else {
                    if (is_numeric($id)) {
                        $page_data = $this->pages_model->sql_select(TBL_PAGES, null, ['where' => array('id' => trim($id), 'is_delete' => 0)], ['single' => true]);
                        if (!empty($page_data) && !empty($page_data['banner_image'])) {
                            unlink(PAGE_BANNER . $page_data['banner_image']);
                        }
                    }
                    $slider_image = $image_name;
                    $dataArr['banner_image'] = $slider_image;
                }
            } else {
                if (is_numeric($id)) {
                    $page_data = $this->pages_model->sql_select(TBL_PAGES, null, ['where' => array('id' => trim($id), 'is_delete' => 0)], ['single' => true]);
                    if (!empty($page_data)) {
                        $slider_image = $page_data['banner_image'];
                        $dataArr['banner_image'] = $page_data['banner_image'];
                    }
                }
            }
            if (is_numeric($id)) {
                $dataArr['modified_at'] = date('Y-m-d H:i:s');
                $this->pages_model->common_insert_update('update', TBL_PAGES, $dataArr, ['id' => $id]);
                $this->session->set_flashdata('success', 'Page details has been updated successfully.');
            } else {
                $dataArr['created_at'] = date('Y-m-d H:i:s');
                $id = $this->pages_model->common_insert_update('insert', TBL_PAGES, $dataArr);
                $this->session->set_flashdata('success', 'Page details has been inserted successfully.');
            }
            redirect('admin/pages');
        }
        $this->template->load('admin', 'admin/pages/manage', $this->data);
    }

    /**
     * Edit a slider .
     *
     */
    public function view($id) {
         
        if (!is_null($id))
            $id = base64_decode($id);
        if (is_numeric($id)) {
            $this->data['title'] = 'Remember Always Admin | Pages';
            $this->data['heading'] = 'View Page Details';
            $page_data = $this->pages_model->sql_select(TBL_PAGES, null, ['where' => array('id' => trim($id), 'is_delete' => 0)], ['single' => true]);
            if (!empty($page_data)) {
                $this->data['page_data'] = $page_data;
            } else {
                custom_show_404();
            }
            $this->template->load('admin', 'admin/pages/view', $this->data);
        } else {
            custom_show_404();
        }
    }

    /**
     * view a slider .
     *
     */
    public function edit($id) {
        $this->add($id);
    }

    /**
     * @method : action function
     * @uses : this function is used to apply action of page
     * @author : AKK
     * */
    public function actions($action, $user_id) {
        if (!is_null($user_id))
            $id = base64_decode($user_id);
        if (is_numeric($id)) {
            $where = 'id = ' . $this->db->escape($id);
            $page = $this->pages_model->sql_select(TBL_PAGES, null, ['where' => array('id' => $id, 'is_delete' => 0)], ['single' => true]);
            if (!empty($page)) {
                if ($action == 'delete') {
                    $update_array = array(
                        'is_delete' => 1
                    );
                    $this->session->set_flashdata('success', 'Page successfully deleted!');
                } else if ($action == 'inactive') {
                    $update_array = array(
                        'active' => 0
                    );
                    $this->session->set_flashdata('success', 'Page successfully inactivated!');
                } else {
                    $update_array = array(
                        'active' => 1
                    );
                    $this->session->set_flashdata('success', 'Page successfully activated!');
                }
                $this->pages_model->common_insert_update('update', TBL_PAGES, $update_array, ['id' => $id]);
            } else {
                $this->session->set_flashdata('error', 'Invalid request. Please try again!');
            }
        } else {
            $this->session->set_flashdata('error', 'Invalid request. Please try again!');
        }
        redirect(site_url('admin/pages'));
    }

    /**
     * @method : Change_data_status function
     * @uses : this function is used to changes status based on show in header and footer
     * @author : AKK
     * */
    public function change_data_status() {
         if (!is_null($this->input->post('id')))
            $id = base64_decode($this->input->post('id'));
        if (is_numeric($id)) {
            $user_array = array($this->input->post('type') => $this->input->post('value'));
            $this->pages_model->common_insert_update('update', TBL_PAGES, $user_array, ['id' => $id]);
            echo 'success';
        }
        exit;
    }

}
