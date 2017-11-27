<?php

/**
 * Login Controller for Administrator Login
 * @author KU 
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Categories extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Display login page for login
     */
    public function index() {
        $this->form_validation->set_rules('name', 'Name', 'trim|required|callback_catgeory_exists');
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
        $data['title'] = 'Remember Always Admin | Service Category';
        $this->load->view('admin/login', $data);
    }

    /**
     * Add a new service catgeory.
     *
     */
    public function add_cateory() {
        
//        $result = $this->users_model->get_user_detail(['name' => trim($value)]);
//        if (!empty($result)) {
//            if (trim($value) != $result['name']) {
//                $this->form_validation->set_message('login_validation', 'Invalid  Email/Password.');
//                return TRUE;
//            } else {
//
//                return FALSE;
//            }
//        } else {
//            return TRUE;
//        }
    }
    /**
     * Callback Validate function to check service category already exists or not.
     * @return boolean
     */
    public function catgeory_exists($value) {
//        $result = $this->users_model->get_user_detail(['name' => trim($value)]);
//        if (!empty($result)) {
//            if (trim($value) != $result['name']) {
//                $this->form_validation->set_message('login_validation', 'Invalid  Email/Password.');
//                return TRUE;
//            } else {
//
//                return FALSE;
//            }
//        } else {
//            return TRUE;
//        }
    }

}
