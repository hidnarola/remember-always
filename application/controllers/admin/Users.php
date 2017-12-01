<?php

/**
 * Providers Controller to manage service users
 * @author KU 
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('users_model');
    }

    /**
     * Display listing of service provider
     */
    public function index() {

        $data['title'] = 'Remember Always Admin | Users';
        $this->template->load('admin', 'admin/users/index', $data);
    }

    /**
     * Get users data for AJAX table
     * */
    public function get_users() {
        $final['recordsFiltered'] = $final['recordsTotal'] = $this->users_model->get_users('count');
        $final['redraw'] = 1;
        $users = $this->users_model->get_users('result');
        $start = $this->input->get('start') + 1;
        foreach ($users as $key => $val) {
            $users[$key] = $val;
            $users[$key]['sr_no'] = $start;
            $users[$key]['created_at'] = date('d M Y', strtotime($val['created_at']));
            $start++;
        }

        $final['data'] = $users;
        echo json_encode($final);
    }

    /**
     * Add a new service provider.
     *
     */
    public function add($id = null) {
        $unique_email = '';
        if (!is_null($id))
            $id = base64_decode($id);
        if (is_numeric($id)) {
            $user_data = $this->users_model->sql_select(TBL_USERS, null, ['where' => array('id' => trim($id), 'is_delete' => 0)], ['single' => true]);
            if (!empty($user_data)) {
                $this->data['user_data'] = $user_data;
                $this->data['title'] = 'Remember Always Admin | Users';
                $this->data['heading'] = 'Edit User';
            } else {
                custom_show_404();
            }
        } else {
            $this->data['title'] = 'Remember Always Admin | Users';
            $this->data['heading'] = 'Add User';
        }
        if (strtolower($this->input->method()) == 'post') {
            if (is_numeric($id)) {
                if (!empty($user_data) && $user_data['email'] != trim($this->input->post('email'))) {
                    $unique_email = '|callback_email_validation';
                }
            } else {
                $unique_email = '|callback_email_validation';
            }
        }
        $this->form_validation->set_rules('firstname', 'Firstname', 'trim|required');
        $this->form_validation->set_rules('lastname', 'Lastname', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required' . $unique_email);

        if ($this->form_validation->run() == FALSE) {
            $this->data['error'] = validation_errors();
        } else {
//            p($this->input->post(), 1);
            $verification_code = verification_code();
            $password = randomPassword();
            $dataArr = array(
                'role' => 'user',
                'firstname' => trim($this->input->post('firstname')),
                'lastname' => trim($this->input->post('lastname')),
                'email' => trim($this->input->post('email')),
            );
            if (is_numeric($id)) {
                $dataArr['updated_at'] = date('Y-m-d H:i:s');
                $this->users_model->common_insert_update('update', TBL_USERS, $dataArr, ['id' => $id]);
                $this->session->set_flashdata('success', 'Uesr details has been updated successfully.');
            } else {
                $dataArr['password'] = password_hash($password, PASSWORD_BCRYPT);
                $dataArr['is_verify'] = 0;
                $dataArr['is_active'] = 0;
                $dataArr['verification_code'] = $verification_code;
                $dataArr['created_at'] = date('Y-m-d H:i:s');
                $id = $this->users_model->common_insert_update('insert', TBL_USERS, $dataArr);
                $verification_code = $this->encrypt->encode($verification_code);
                $encoded_verification_code = $verification_code;
                $email_data = [];
                $email_data['url'] = site_url() . 'verify?code=' . $encoded_verification_code;
                $email_data['title'] = trim("Login Credentails And Verification");
                $email_data['name'] = trim($this->input->post('firstname')) . ' ' . trim($this->input->post('lastname'));
                $email_data['email'] = trim($this->input->post('email'));
                $email_data['password'] = $password;
                $email_data['subject'] = 'Login Credentails and Verify Email | Remember Always';
                send_mail(trim($this->input->post('email')), 'verify_email', $email_data);
                $this->session->set_flashdata('success', 'Uesr details has been inserted successfully.');
            }
            redirect('admin/users');
        }
        $this->template->load('admin', 'admin/users/manage', $this->data);
    }

    /**
     * view a service provider .
     *
     */
    public function edit($id) {
        $this->add($id);
    }

    /**
     * Edit a Uesr.
     *
     */
    public function view($id) {

        if (!is_null($id))
            $id = base64_decode($id);
        if (is_numeric($id)) {
            $this->data['title'] = 'Remember Always Admin | Users';
            $this->data['heading'] = 'View Uesr Details';
            $user_data = $this->users_model->sql_select(TBL_USERS, null, ['where' => array('id' => trim($id), 'is_delete' => 0)], ['single' => true]);
            if (!empty($user_data)) {
                $this->data['user_data'] = $user_data;
            } else {
                custom_show_404();
            }
            $this->template->load('admin', 'admin/users/view', $this->data);
        } else {
            custom_show_404();
        }
    }

    /**
     * Delete service provider
     * @param int $id
     * */
    public function delete($id = NULL) {
        $id = base64_decode($id);
        if (is_numeric($id)) {
            $user_data = $this->users_model->sql_select(TBL_USERS, null, ['where' => array('id' => trim($id), 'is_delete' => 0)], ['single' => true]);
            if (!empty($user_data)) {
                $update_array = array(
                    'is_delete' => 1,
                    'updated_at' => date('Y-m-d H:i:s'),
                );
                $this->users_model->common_insert_update('update', TBL_USERS, $update_array, ['id' => $id]);
                $this->session->set_flashdata('success', 'User has been deleted successfully!');
            } else {
                $this->session->set_flashdata('error', 'Unable to User slider!');
            }
        } else {
            $this->session->set_flashdata('error', 'Invalid request. Please try again!');
        }
        redirect('admin/users');
    }

    /**
     * Callback Validate function to check unique email validation
     * @return boolean
     */
    public function email_validation() {
        $result = $this->users_model->get_user_detail(['email' => trim($this->input->post('email')), 'is_delete' => 0, 'role' => 'user']);
        if (!empty($result)) {
            $this->form_validation->set_message('email_validation', 'Email Already exist!');
            return FALSE;
        } else {
            return TRUE;
        }
    }

}
