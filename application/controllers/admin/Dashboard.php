<?php

/**
 * Dashboard controller for Administrator dashboard
 * @author KU 
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Display dashboard page
     */
    public function index() {
        $this->data['title'] = 'Remember Always Admin | Dashboard';
        $this->template->load('admin', 'admin/dashboard', $this->data);
    }

    /**
     * Update Administrator Profile
     */
    public function profile() {
        $data['title'] = 'Remember Always | Admin Profile';
        $this->form_validation->set_rules('firstname', 'First Name', 'trim|required');
        if ($this->form_validation->run() == TRUE) {
            $flag = 0;
            $profile_image = $this->session->userdata('remalways_admin')['profile_image'];
            if ($_FILES['profile_image']['name'] != '') {
                $image_data = upload_image('profile_image', USER_IMAGES);
                if (is_array($image_data)) {
                    $flag = 1;
                    $data['profile_image_validation'] = $image_data['errors'];
                } else {
                    if ($profile_image != '') {
                        unlink(USER_IMAGES . $profile_image);
                    }
                    $profile_image = $image_data;
                }
            }
            if ($flag != 1) {

                //--Unlink the previosly uploaded image if new image is uploaded
                $update_array = array(
                    'firstname' => trim($this->input->post('firstname')),
                    'lastname' => trim($this->input->post('lastname')),
                    'profile_image' => $profile_image,
                    'updated_at' => date('Y-m-d H:i:s')
                );
                $this->users_model->common_insert_update('update', TBL_USERS, $update_array, ['id' => $this->session->userdata('remalways_admin')['id']]);
                $this->session->set_flashdata('success', 'Profile updated successfully!');

                $result = $this->users_model->get_user_detail(['email' => $this->session->userdata('remalways_admin')['email'], 'is_delete' => 0]);
                unset($result['password']);

                $this->session->set_userdata('remalways_admin', $result);
                redirect('admin/profile');
            }
        }
        $this->template->load('admin', 'admin/profile', $data);
    }

    /**
     * Updates password for Administrator
     */
    public function update_password() {
        $this->form_validation->set_rules('old_password', 'Password', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        $this->form_validation->set_rules('confirm_password', 'Confirm password', 'trim|required|matches[password]');

        if ($this->form_validation->run() == FALSE) {
            $error = validation_errors();
            $this->session->set_flashdata('error', $error);
        } else {
            $result = $this->users_model->get_user_detail(['email' => $this->session->userdata('remalways_admin')['email'], 'is_delete' => 0]);
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
        redirect('admin/profile');
    }

}
