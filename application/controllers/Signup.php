<?php

/**
 * SignUp Controller for user SignUp
 * @author KU 
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Signup extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Display SignUp page
     */
    public function index() {
        $this->form_validation->set_rules('email', 'Email', 'trim|required|callback_email_validation');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        $this->form_validation->set_rules('firstname', 'Firstname', 'trim|required');
        $this->form_validation->set_rules('lastname', 'Lastname', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $data['error'] = validation_errors();
            $error_msg = str_replace(array("\r", "\n"), '', $data['error']);
            $this->session->set_flashdata('error', $error_msg);
        } else {
            $verification_code = verification_code();
            $data = array(
                'role' => 'user',
                'firstname' => trim($this->input->post('firstname')),
                'lastname' => trim($this->input->post('lastname')),
                'email' => trim($this->input->post('email')),
                'password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT),
                'verification_code' => $verification_code,
                'is_verify' => 0,
                'is_active' => 0,
                'created_at' => date('Y-m-d H:i:s')
            );
            $this->users_model->common_insert_update('insert', TBL_USERS, $data);

//            $verification_code = $this->encrypt->encode($verification_code);
            $verification_code = base64_encode($verification_code);
            $encoded_verification_code = urlencode($verification_code);

            $email_data = [];
            $email_data['url'] = site_url() . 'verify?code=' . $encoded_verification_code;
            $email_data['name'] = trim($this->input->post('firstname')) . ' ' . trim($this->input->post('lastname'));
            $email_data['email'] = trim($this->input->post('email'));
            $email_data['subject'] = 'Verify Email | Remember Always';
            send_mail(trim($this->input->post('email')), 'verify_email', $email_data);
            $this->session->set_flashdata('success', 'You have been registered successfully and verification mail is sent! Please verify your email to login');
        }
        redirect('/');
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

    /**
     * Check email exist or not for user SignUp functionality
     */
    public function check_email() {
        $requested_email = trim($this->input->get('email'));
        $user = $this->users_model->get_user_detail(['email' => $requested_email, 'is_delete' => 0, 'role' => 'user']);
        if (!empty($user)) {
            echo "false";
        } else {
            echo "true";
        }
        exit;
    }

    public function verify() {
        $verification_code = $this->input->get('code');
//        $verification_code = $this->encrypt->decode(urldecode($verification_code));
        $verification_code = base64_decode(urldecode($verification_code));
        //--- check varification code is valid or not
        $result = $this->users_model->check_verification_code($verification_code);
        if (!empty($result)) {
            //--- if valid then change is_verify and is_active status
            //--- generate verification code
            $new_verification_code = verification_code();
            $id = $result['id'];
            $data = array(
                'is_verify' => 1,
                'is_active' => 1,
                'updated_at' => date('Y-m-d H:i:s'),
                'verification_code' => $new_verification_code
            );
            $this->users_model->common_insert_update('update', TBL_USERS, $data, ['id' => $id]);
            $this->session->set_flashdata('success', 'You have successfully verified your email. Login to continue..');
        } else {
            //--- if invalid verification code
            $this->session->set_flashdata('error', 'Invalid request or already verified your email');
        }
        redirect('/');
    }

    public function resend_verification() {
        $uid = base64_decode($this->input->get('uid'));
        $user = $this->users_model->get_user_detail(['id' => $uid, 'is_delete' => 0, 'role' => 'user']);
        if (!empty($user) && $user['verification_code'] != '') {
            $verification_code = base64_encode($user['verification_code']);
            $encoded_verification_code = urlencode($verification_code);

            $email_data = [];
            $email_data['url'] = site_url() . 'verify?code=' . $encoded_verification_code;
            $email_data['name'] = $user['firstname'] . ' ' . $user['lastname'];
            $email_data['email'] = $user['email'];
            $email_data['subject'] = 'Verify Email | Remember Always';
            send_mail($user['email'], 'verify_email', $email_data);
            $this->session->set_flashdata('success', 'Verification email sent successfully');
        } else {
            $this->session->set_flashdata('error', 'Invalid request or already verified your email');
        }
        redirect('/');
    }

}
