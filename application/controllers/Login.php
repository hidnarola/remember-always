<?php

/**
 * Login Controller for user Login
 * @author KU 
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('users_model');
    }

    /**
     * Display login page
     */
    public function index() {
        $this->form_validation->set_rules('email', 'Email', 'trim|required|callback_login_validation');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $data['error'] = validation_errors();
        } else {
            //-- If redirect is set in URL then redirect user back to that page
            if ($this->input->get('redirect')) {
                redirect(base64_decode($this->input->get('redirect')));
            } else {
                redirect('home');
            }
        }
        $data['title'] = 'Remember Always | Login';
        $this->template->load('defaukt', 'login', $data);
    }

    /**
     * Callback Validate function to check Super Admin/Business User 
     * @return boolean
     */
    public function login_validation() {
        $result = $this->users_model->get_user_detail(['email' => trim($this->input->post('email')), 'is_delete' => 0, 'role' => 'user']);
        if (!empty($result)) {
            if ($result['is_verify'] == 0) {
                $this->form_validation->set_message('login_validation', 'You have not verified your email yet! Please verify it first.');
                return FALSE;
            } elseif ($result['is_active'] == 0) {
                $this->form_validation->set_message('login_validation', 'Your account is blocked! Please contact system Administrator.');
                return FALSE;
            } else {
                unset($result['password']);
                $this->session->set_userdata('remalways_user', $result);
                return TRUE;
            }
        } else {
            $this->form_validation->set_message('login_validation', 'Invalid Email/Password.');
            return FALSE;
        }
    }

    /**
     * Clears the session and log out user
     */
    public function logout() {
        $this->session->sess_destroy();
        redirect('login');
    }

}
