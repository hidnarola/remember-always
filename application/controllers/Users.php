<?php

/**
 * Providers Controller to manage service users
 * @author KU 
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Display listing of service provider
     */
    public function index() {

        $data['title'] = 'Remember Always Admin | Users';
        $this->template->load('admin', 'admin/users/index', $data);
    }

    /**
     * Edit profile for user.
     */
    public function edit_profile() {
        if (!$this->is_user_loggedin) {
            $this->session->set_flashdata('error', 'You must login to access this page');
            redirect('/');
        }
        $is_left = $this->users_model->sql_select(TBL_USERS, '*', ['where' => ['id' => $this->user_id, 'is_delete' => 0,]], ['single' => true]);
        if (!empty($is_left)) {
            $data['user_data'] = $is_left;
        }
        if ($_POST) {
            $this->form_validation->set_rules('firstname', 'Firstname', 'trim|required');
            $this->form_validation->set_rules('lastname', 'Lastname', 'trim|required');
            if ($this->form_validation->run() == FALSE) {
                $data['error'] = validation_errors();
                $data['success'] = false;
            } else {
                $profile_image = '';
                if (!empty($is_left)) {
                    $profile_image = $is_left['profile_image'];
                }

                //-- check if profile image is there in $_FILES array
                if ($_FILES['profile_image']['name'] != '') {
                    $directory = 'user_' . $this->user_id;
                    if (!file_exists(USER_IMAGES . $directory)) {
                        mkdir(USER_IMAGES . $directory);
                    }
                    $image_data = upload_image('profile_image', USER_IMAGES . $directory);
                    if (is_array($image_data)) {
                        $flag = 1;
                        $data['error'] = $image_data['errors'];
                        $data['success'] = false;
                    } else {
                        $profile_image = $directory . '/' . $image_data;
                    }
                }

                $data = array(
                    'firstname' => trim($this->input->post('firstname')),
                    'lastname' => trim($this->input->post('lastname')),
                    'profile_image' => $profile_image,
                );
                if (!empty($is_left)) {
                    $data['updated_at'] = date('Y-m-d H:i:s');
                    $this->users_model->common_insert_update('update', TBL_USERS, $data, ['id' => $is_left['id']]);
                    $result = $this->users_model->get_user_detail(['id' => $this->user_id, 'is_delete' => 0]);
                    unset($result['password']);
                    $this->session->set_userdata('remalways_user', $result);
                    $data['user_data'] = $result;
                    $this->session->set_flashdata('success', 'Your Profile has been updated!');
                }
            }
        }
        $data['breadcrumb'] = ['title' => 'Edit Profile', 'links' => [['link' => site_url(), 'title' => 'Home']]];
        $data['title'] = 'Remember Always | Edit Profile';
        $this->template->load('default', 'edit_profile_form', $data);
    }

    /**
     * Updates password for user
     */
    public function update_password() {
        if (!$this->is_user_loggedin) {
            $this->session->set_flashdata('error', 'You must login to access this page');
            redirect('/');
        }
        $this->form_validation->set_rules('old_password', 'Password', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        $this->form_validation->set_rules('confirm_password', 'Confirm password', 'trim|required|matches[password]');

        if ($this->form_validation->run() == FALSE) {
            $error = validation_errors();
            $this->session->set_flashdata('error', $error);
        } else {
            $result = $this->users_model->get_user_detail(['id' => $this->user_id, 'is_delete' => 0]);
            if (!password_verify($this->input->post('old_password'), $result['password'])) {
                $this->session->set_flashdata('error', 'You have entered wrong old password! Please try again.');
            } else {
                $id = $result['id'];
                $data = array(
                    'password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT),
                );
                $this->users_model->common_insert_update('update', TBL_USERS, $data, ['id' => $id]);
                $this->session->set_flashdata('success', 'Your password changed successfully');
            }
        }
        $data['breadcrumb'] = ['title' => 'Change Password', 'links' => [['link' => site_url(), 'title' => 'Home']]];
        $data['title'] = 'Remember Always | Change Password';
        $this->template->load('default', 'change_password', $data);
    }

}
