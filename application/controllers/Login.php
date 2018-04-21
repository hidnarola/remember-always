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
            $data['success'] = false;
        } else {
            if ($this->input->get('type') == 'ajax') {
                $profile_id = base64_decode($this->input->post('profile_id'));
                if (isset($_FILES['post_upload']) && !empty($_FILES['post_upload']['name'][0])) {
                    $directory = 'profile_' . $profile_id;
                    if (!file_exists(POST_IMAGES . $directory)) {
                        mkdir(POST_IMAGES . $directory);
                        chmod(POST_IMAGES . $directory, 0777);
                    }
                    foreach ($_FILES['post_upload']['name'] as $key => $value) {
                        $extension = explode('/', $_FILES['post_upload']['type'][$key]);
                        $_FILES['custom_image']['name'] = $_FILES['post_upload']['name'][$key];
                        $_FILES['custom_image']['type'] = $_FILES['post_upload']['type'][$key];
                        $_FILES['custom_image']['tmp_name'] = $_FILES['post_upload']['tmp_name'][$key];
                        $_FILES['custom_image']['error'] = $_FILES['post_upload']['error'][$key];
                        $_FILES['custom_image']['size'] = $_FILES['post_upload']['size'][$key];
                        if ($this->input->post('post_types')[$key] == 1) {
                            $image_data = upload_multiple_image('custom_image', end($extension), POST_IMAGES . $directory);
                        } else {
                            $image_data = upload_multiple_image('custom_image', end($extension), POST_IMAGES . $directory, 'video', 'mp4');
                        }
                        if (!is_array($image_data)) {
                            $image = $image_data;
                            $dataArr_media[] = array(
                                'media' => $directory . '/' . $image,
                                'type' => $this->input->post('post_types')[$key],
                                'created_at' => date('Y-m-d H:i:s'),
                            );
                        }
                    }
                }
                if (!empty(trim($this->input->post('comment')))) {
                    $dataArr = array(
                        'profile_id' => $profile_id,
                        'user_id' => $this->session->userdata('remalways_user')['id'],
                        'created_at' => date('Y-m-d H:i:s'),
                    );

                    $dataArr['comment'] = trim($this->input->post('comment'));

                    $id = $this->users_model->common_insert_update('insert', TBL_POSTS, $dataArr);
                    if (isset($dataArr_media) && !empty($dataArr_media)) {
                        foreach ($dataArr_media as $key => $value) {
                            $dataArr_media[$key]['post_id'] = $id;
                        }
                        $this->users_model->batch_insert_update('insert', TBL_POST_MEDIAS, $dataArr_media);
                    }
                    $this->session->set_flashdata('success', 'Post details has been inserted successfully.');
                }

                $data['success'] = true;
//            $this->session->set_flashdata('success', 'Logged in successfully!');
            }
            //-- If redirect is set in URL then redirect user back to that page
            if ($this->input->get('type') == 'ajax') {
                echo json_encode($data);
                exit;
            } else if ($this->input->get('redirect')) {
                redirect(base64_decode($this->input->get('redirect')));
            } else {
                redirect('/');
            }
        }
    }

    /**
     * Callback Validate function to authentication of user
     * @return boolean
     */
    public function login_validation() {
        $result = $this->users_model->get_user_detail(['email' => trim($this->input->post('email')), 'is_delete' => 0, 'role' => 'user']);
        if (!empty($result)) {
            if (!password_verify($this->input->post('password'), $result['password'])) {
                if ($this->input->get('type') != 'ajax') {
                    $this->session->set_flashdata('error', 'Invalid Email/Password.');
                }
                $this->form_validation->set_message('login_validation', 'Invalid Email/Password.');
                return FALSE;
            } elseif ($result['is_verify'] == 0) {
                $resend_link = site_url('signup/resend_verification?uid=' . base64_encode($result['id']));
                if ($this->input->get('type') != 'ajax') {
                    $this->session->set_flashdata('error', 'You have not verified your email yet! Please verify it first. <a href=\'' . $resend_link . '\'>Click here</a> to resend verification email.');
                }
                $this->form_validation->set_message('login_validation', 'You have not verified your email yet! Please verify it first. <a href="' . $resend_link . '">Click here</a> to resend verification email.');
                return FALSE;
            } elseif ($result['is_active'] == 0) {
                if ($this->input->get('type') != 'ajax') {
                    $this->session->set_flashdata('error', 'Your account is blocked! Please contact system Administrator.');
                }
                $this->form_validation->set_message('login_validation', 'Your account is blocked! Please contact system Administrator.');
                return FALSE;
            } else {
                //-- If input details are valid then store data into session
                if ($this->input->post('remember_me') == 1)
                    $this->users_model->activate_user_remember_me($result['email']);
                unset($result['password']);
                $this->session->set_userdata('remalways_user', $result);
                return TRUE;
            }
        } else {
            if ($this->input->get('type') != 'ajax') {
                $this->session->set_flashdata('error', 'Invalid Email/Password');
            }
            $this->form_validation->set_message('login_validation', 'Invalid Email/Password.');
            return FALSE;
        }
    }

    /**
     * Clears the session and log out user
     */
    public function logout() {
        $this->session->unset_userdata('remalways_user');
        delete_cookie(REMEMBER_ME_USER_COOKIE);
//        $this->session->set_flashdata('success', 'Logout successfully!');
        redirect('/');
    }

    public function forgot_password() {
        $this->form_validation->set_rules('email', 'Email', 'trim|required|callback_email_validation');
        if ($this->form_validation->run() == FALSE) {
            $data['error'] = validation_errors();
            $error_msg = str_replace(array("\r", "\n"), '', $data['error']);
            $this->session->set_flashdata('error', $error_msg);
        } else {
            $user = $this->users_model->get_user_detail("email='" . trim($this->input->post('email')) . "' AND is_delete=0 AND is_active=1 AND role='user' AND facebook_id IS NULL AND google_id IS NULL");
            $verification_code = verification_code();
            $this->users_model->common_insert_update('update', TBL_USERS, array('verification_code' => $verification_code), array('id' => $user['id']));

//            $verification_code = $this->encrypt->encode($verification_code);
            $encoded_verification_code = base64_encode($verification_code);

            $email_data = [];
            $email_data['url'] = site_url() . 'reset_password?code=' . $encoded_verification_code;
            $email_data['name'] = $user['firstname'] . ' ' . $user['lastname'];
            $email_data['email'] = trim($this->input->post('email'));
            $email_data['subject'] = 'Reset Password - Remember Always';
            send_mail(trim($this->input->post('email')), 'forgot_password', $email_data);
            $this->session->set_flashdata('success', 'Email has been successfully sent to reset password! Please check email');
        }
        redirect('/');
    }

    /**
     * Forgot password email validation
     */
    public function email_validation() {
        $requested_email = trim($this->input->post('email'));
        $user = $this->users_model->get_user_detail(['email' => $requested_email, 'is_delete' => 0, 'is_active' => 1, 'role' => 'user']);
        if (empty($user)) {
            $this->form_validation->set_message('email_validation', 'Invalid Email Address');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    /**
     * Check email is valid or not
     */
    public function check_email() {
        $requested_email = trim($this->input->get('email'));
        $user = $this->users_model->get_user_detail(['email' => $requested_email, 'is_delete' => 0, 'is_active' => 1, 'role' => 'user']);
        if ($user) {
            echo "true";
        } else {
            echo "false";
        }
        exit;
    }

    /**
     * Reset password page
     */
    public function reset_password() {
        $this->controller = strtolower($this->router->fetch_class());
        $data['title'] = 'Remember Always | Reset Password';
        $org_code = $verification_code = $this->input->get('code');
//        $verification_code = $this->encrypt->decode($verification_code);
        $verification_code = base64_decode($verification_code);
        $this->is_user_loggedin = false;
        //--- check varification code is valid or not
        $result = $this->users_model->check_verification_code($verification_code);
        if (!empty($result)) {
            $this->form_validation->set_rules('password', 'Password', 'trim|required');
            $this->form_validation->set_rules('con_password', 'Confirm password', 'trim|required|matches[password]');

            if ($this->form_validation->run() == FALSE) {
                $data['error'] = validation_errors();
            } else {

                //--- if valid then reset password and generate new verification code
                //--- generate verification code
                $new_verification_code = NULL;
                $id = $result['id'];
                $data = array(
                    'password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT),
                    'verification_code' => $new_verification_code
                );
                $this->users_model->common_insert_update('update', TBL_USERS, $data, ['id' => $id]);
                $this->session->set_flashdata('success', 'Your password changed successfully');
                redirect('/');
            }
            $data['reset_password'] = true;
            $data['reset_password_code'] = $org_code;
            $data['title'] = 'Remember Always';
            $data['slider_images'] = $this->users_model->sql_select(TBL_SLIDER, 'image,description', ['where' => ['is_delete' => 0, 'is_active' => 1]]);
            $this->template->load('default', 'home', $data);
        } else {
            //--- if invalid verification code
            $this->session->set_flashdata('error', 'Invalid request or already changed password');
            redirect('/');
        }
    }

}
