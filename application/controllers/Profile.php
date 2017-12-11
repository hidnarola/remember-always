<?php

/**
 * Profile Controller
 * Manage profile related functions
 * @author KU 
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Display login page for login
     */
    public function index($slug = null) {
        $data['title'] = 'Profile';
        $data['breadcrumb'] = ['title' => 'User Profile', 'links' => [['link' => site_url(), 'title' => 'Home']]];
        $this->template->load('default', 'profile/profile_detail', $data);
    }

    /**
     * Create Profile Page
     */
    public function create() {
        if (!$this->is_user_loggedin) {
            $this->session->set_flashdata('error', 'You must login to access this page');
            redirect('/');
        }
        // check any user's profile is left to be published
        $is_left = $this->users_model->sql_select(TBL_PROFILES, '*', ['where' => ['is_published' => 0, 'is_delete' => 0, 'user_id' => $this->user_id]], ['single' => true, 'order_by' => 'id DESC']);
        if (!empty($is_left)) {
            $data['profile'] = $is_left;
        }
        if ($_POST) {
            $this->form_validation->set_rules('firstname', 'Firstname', 'trim|required');
            $this->form_validation->set_rules('lastname', 'Lastname', 'trim|required');
            $this->form_validation->set_rules('date_of_birth', 'Date of Birth', 'trim|required');
            $this->form_validation->set_rules('date_of_death', 'Date of Death', 'trim|required');

            if ($this->form_validation->run() == FALSE) {
                $data['error'] = validation_errors();
                $data['success'] = false;
            } else {

                $profile_process = $this->input->post('profile_process');
                $flag = 0;
                $profile_image = '';
                if (!empty($is_left)) {
                    $profile_image = $is_left['profile_image'];
                }
                if (!empty($this->input->post('nickname'))) {
                    $slug = trim($this->input->post('nickname'));
                } else {
                    $slug = trim($this->input->post('firstname')) . '-' . trim($this->input->post('lastname'));
                }
                if (!empty($is_left)) {
                    $slug = slug($slug, TBL_PROFILES, $is_left['id']);
                }

                //-- check if profile image is there in $_FILES array
                if ($_FILES['profile_image']['name'] != '') {
                    $directory = 'user_' . $this->user_id;
                    if (!file_exists(PROFILE_IMAGES . $directory)) {
                        mkdir(PROFILE_IMAGES . $directory);
                    }
                    $image_data = upload_image('profile_image', PROFILE_IMAGES . $directory);
                    if (is_array($image_data)) {
                        $flag = 1;
                        $data['error'] = $image_data['errors'];
                        $data['success'] = false;
                    } else {
                        if ($profile_image != '') {
                            unlink(PROFILE_IMAGES . $profile_image);
                        }
                        $profile_image = $directory . '/' . $image_data;
                    }
                }

                if ($flag != 1) {
                    $data = array(
                        'user_id' => $this->user_id,
                        'profile_process' => $this->input->post('profile_process'),
                        'firstname' => trim($this->input->post('firstname')),
                        'lastname' => trim($this->input->post('lastname')),
                        'nickname' => trim($this->input->post('nickname')),
                        'slug' => $slug,
                        'profile_image' => $profile_image,
                        'life_bio' => trim($this->input->post('life_bio')),
                        'date_of_birth' => date('Y-m-d H:i:s', strtotime($this->input->post('date_of_birth'))),
                        'date_of_death' => date('Y-m-d H:i:s', strtotime($this->input->post('date_of_death'))),
                    );
                    if (!empty($is_left)) {
                        $data['updated_at'] = date('Y-m-d H:i:s');
                        $this->users_model->common_insert_update('update', TBL_PROFILES, $data, ['id' => $is_left['id']]);
                    } else {
                        $data['created_at'] = date('Y-m-d H:i:s');
                        $this->users_model->common_insert_update('insert', TBL_PROFILES, $data);
                    }

                    $data['success'] = true;
                    $data['data'] = $data;
                }
            }
            echo json_encode($data);
            exit;
        }
        $data['breadcrumb'] = ['title' => 'Create a Life Profile', 'links' => [['link' => site_url(), 'title' => 'Home']]];
        $data['title'] = 'Remember Always | Create Profile';
        $this->template->load('default', 'profile/profile_form', $data);
    }

}
