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
                show_404();
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
                'description' => htmlentities($this->input->post('description')),
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
            $slider = $this->pages_model->sql_select(TBL_PAGES, null, ['where' => array('id' => trim($id), 'is_delete' => 0)], ['single' => true]);
            if (!empty($slider)) {
                $this->data['slider'] = $slider;
            } else {
                show_404();
            }
            $this->template->load('admin', 'admin/pages/view', $this->data);
        } else {
            show_404();
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
     * Delete service category
     * @param int $id
     * */
    public function delete($id = NULL) {
        $id = base64_decode($id);
        if (is_numeric($id)) {
            $slider = $this->pages_model->sql_select(TBL_PAGES, null, ['where' => array('id' => trim($id), 'is_delete' => 0)], ['single' => true]);
            if (!empty($slider)) {
                $update_array = array(
                    'is_delete' => 1
                );
                $this->pages_model->common_insert_update('update', TBL_PAGES, $update_array, ['id' => $id]);
                $this->session->set_flashdata('success', 'Slider has been deleted successfully!');
            } else {
                $this->session->set_flashdata('error', 'Unable to delete slider!');
            }
        }
        redirect('admin/pages');
    }

    /**
     * Hide slider
     * @param int $id
     * */
    public function hide($id = NULL) {
        $id = base64_decode($id);
        if (is_numeric($id)) {
            $slider = $this->pages_model->sql_select(TBL_PAGES, null, ['where' => array('id' => trim($id), 'is_delete' => 0)], ['single' => true]);
            if (!empty($slider)) {
                $update_array = array(
                    'is_active' => 0
                );
                $this->pages_model->common_insert_update('update', TBL_PAGES, $update_array, ['id' => $id]);
                $this->session->set_flashdata('success', 'Slider will now be hidden!');
            } else {
                $this->session->set_flashdata('error', 'Unable to hide slider!');
            }
        }
        redirect('admin/pages');
    }

    /**
     * Show service category
     * @param int $id
     * */
    public function show($id = NULL) {
        $id = base64_decode($id);
        if (is_numeric($id)) {
            $slider = $this->pages_model->sql_select(TBL_PAGES, null, ['where' => array('id' => trim($id), 'is_delete' => 0)], ['single' => true]);
            if (!empty($slider)) {
                $update_array = array(
                    'is_active' => 1
                );
                $this->pages_model->common_insert_update('update', TBL_PAGES, $update_array, ['id' => $id]);
                $this->session->set_flashdata('success', 'Slider will now be visible!');
            } else {
                $this->session->set_flashdata('error', 'Unable to show slider!');
            }
        }
        redirect('admin/pages');
    }

}
