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
            if ($is_left['country'] != '') {
                $states = $this->users_model->sql_select(TBL_STATE, null, ['where' => array('country_id' => $is_left['country'])]);
                if (!empty($states)) {
                    $data['states'] = $states;
                }
            }
            if ($is_left['state'] != '') {
                $cities = $this->users_model->sql_select(TBL_CITY, null, ['where' => array('state_id' => $is_left['state'])]);
                if (!empty($cities)) {
                    $data['cities'] = $cities;
                }
            }
        }
        $countries = $this->users_model->customQuery('SELECT id,name FROM ' . TBL_COUNTRY . ' order by id=231 DESC');
        $data['countries'] = $countries;

        $states = $this->users_model->sql_select(TBL_STATE, null, ['where' => array('country_id' => base64_decode($this->input->post('country')))]);
        if (!empty($states)) {
            $data['states'] = $states;
        }
        $cities = $this->users_model->sql_select(TBL_CITY, null, ['where' => array('state_id' => base64_decode($this->input->post('state')))]);
        if (!empty($cities)) {
            $data['cities'] = $cities;
        }
        $this->form_validation->set_rules('firstname', 'Firstname', 'trim|required');
        $this->form_validation->set_rules('lastname', 'Lastname', 'trim|required');
//            $this->form_validation->set_rules('address1', 'Address 1', 'trim|required');
//            $this->form_validation->set_rules('country', 'Country', 'trim|required');
//            $this->form_validation->set_rules('state', 'State', 'trim|required');
//            $this->form_validation->set_rules('city', 'City', 'trim|required');
//            $this->form_validation->set_rules('phone', 'Phone number', 'trim|required');
//            $this->form_validation->set_rules('zipcode', 'Zipcode', 'trim|required');
        if (isset($_POST['old_password']) && !empty(trim($_POST['old_password']))) {
            $this->form_validation->set_rules('old_password', 'Password', 'trim|required|callback_check_password');
            $this->form_validation->set_rules('new_password', 'Password', 'trim|required');
            $this->form_validation->set_rules('confirm_password', 'Confirm password', 'trim|required|matches[new_password]');
        }
        if ($this->form_validation->run() == FALSE) {
            $data['error'] = validation_errors();
            $data['success'] = false;
        } else {
            $flag = 0;
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
                    $data['image_error'] = $image_data['errors'];
                    $data['success'] = false;
                } else {
                    $profile_image = $directory . '/' . $image_data;
                }
            }
            //-- If not any error in uploading profile then save the data
            if ($flag == 0) {
                $data = array(
                    'firstname' => trim($this->input->post('firstname')),
                    'lastname' => trim($this->input->post('lastname')),
                    'address1' => trim($this->input->post('address1')),
                    'country' => base64_decode(trim($this->input->post('country'))),
                    'state' => base64_decode(trim($this->input->post('state'))),
                    'city' => base64_decode(trim($this->input->post('city'))),
                    'zipcode' => trim($this->input->post('zipcode')),
                    'phone' => trim($this->input->post('phone')),
                    'profile_image' => $profile_image,
                );
                if (!empty(trim($this->input->post('address2')))) {
                    $data['address2'] = trim($this->input->post('address2'));
                }
//                $result = $this->users_model->get_user_detail(['id' => $this->user_id, 'is_delete' => 0]);
//                if (!password_verify($this->input->post('old_password'), $is_left['password'])) {
//                    $this->session->set_flashdata('error', 'You have entered wrong old password! Please try again.');
//                } else {
                if (!empty($this->input->post('new_password'))) {
                    $data['password'] = password_hash($this->input->post('new_password'), PASSWORD_BCRYPT);
                }
                if (!empty($is_left)) {
                    $data['updated_at'] = date('Y-m-d H:i:s');
                    $this->users_model->common_insert_update('update', TBL_USERS, $data, ['id' => $is_left['id']]);
                    $result = $this->users_model->get_user_detail(['id' => $this->user_id, 'is_delete' => 0]);
                    unset($result['password']);
                    $this->session->set_userdata('remalways_user', $result);
                    $data['user_data'] = $result;
                    $this->session->set_flashdata('success', 'Your Profile has been updated!');
                    redirect('editprofile');
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

    /**
     * Check password is correct or not.
     */
    public function check_password() {
        $is_left = $this->users_model->sql_select(TBL_USERS, '*', ['where' => ['id' => $this->user_id, 'is_delete' => 0,]], ['single' => true]);
        if (!empty($is_left)) {
            if (!password_verify($this->input->post('old_password'), $is_left['password'])) {
                $this->form_validation->set_message('check_password', 'You have entered wrong current password! Please try again.');
                return FALSE;
            } else {
                return TRUE;
            }
        } else {
            $this->form_validation->set_message('check_password', 'You have entered wrong current password! Please try again.');
            return FALSE;
        }
    }

    /**
     * Get cities  or state based on type passed as data.
     * */
    public function get_data() {
        $id = base64_decode($this->input->post('id'));
        $type = $this->input->post('type');
        $options = '';
        if ($type == 'city') {
            $options = '<option value="">-- Select City --</option>';
            if (is_numeric($id)) {
                $data = $this->users_model->sql_select(TBL_CITY, null, ['where' => array('state_id' => trim($id))]);
                if (!empty($data)) {
                    foreach ($data as $row) {
                        $options .= "<option value = '" . base64_encode($row['id']) . "'>" . $row['name'] . "</option>";
                    }
                }
            }
        } else if ($type == 'state') {
            $options = '<option value="">-- Select State --</option>';
            if (is_numeric($id)) {
                $data = $this->users_model->sql_select(TBL_STATE, null, ['where' => array('country_id' => trim($id))]);
                if (!empty($data)) {
                    foreach ($data as $row) {
                        $options .= "<option value = '" . base64_encode($row['id']) . "'>" . $row['name'] . "</option>";
                    }
                }
            }
        }
        echo $options;
    }

}
