<?php

/**
 * Providers Controller to manage service users
 * @author KU 
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Posts extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('admin/post_model');
    }

    /**
     * Display listing of service provider
     */
    public function index() {

        $data['title'] = 'Remember Always Admin | Posts';
        $this->template->load('admin', 'admin/posts/index', $data);
    }

    /**
     * Get users data for AJAX table
     * */
    public function get_posts() {
        $final['recordsFiltered'] = $final['recordsTotal'] = $this->post_model->get_posts('count');
        $final['redraw'] = 1;
        $users = $this->post_model->get_posts('result');
       
        $start = $this->input->get('start') + 1;
        foreach ($users as $key => $val) {
            $users[$key] = $val;
            $users[$key]['sr_no'] = $start;
            $users[$key]['created_at'] = date('d M Y', strtotime($val['created_at']));
            $start++;
        }
//         p($users, 1);
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
            $post_data = $this->post_model->sql_select(TBL_USERS, null, ['where' => array('id' => trim($id), 'is_delete' => 0)], ['single' => true]);
            if (!empty($post_data)) {
                $this->data['post_data'] = $post_data;
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
                if (!empty($post_data) && $post_data['email'] != trim($this->input->post('email'))) {
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
                $this->post_model->common_insert_update('update', TBL_USERS, $dataArr, ['id' => $id]);
                $this->session->set_flashdata('success', 'Uesr details has been updated successfully.');
            } else {
                $dataArr['password'] = password_hash($password, PASSWORD_BCRYPT);
                $dataArr['is_verify'] = 0;
                $dataArr['is_active'] = 0;
                $dataArr['verification_code'] = $verification_code;
                $dataArr['created_at'] = date('Y-m-d H:i:s');
                $id = $this->post_model->common_insert_update('insert', TBL_USERS, $dataArr);
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
            $this->data['title'] = 'Remember Always Admin | Posts';
            $this->data['heading'] = 'View Post Details';
            $post_data = $this->post_model->sql_select(TBL_POSTS . ' p', 'p.id as p_id,p.created_at as p_date,p.comment,u.firstname as user_fname,u.lastname as user_lname,pf.firstname as profile_fname,pf.lastname as profile_lname,pf.privacy,pf.type', ['where' => array('p.id' => trim($id), 'p.is_delete' => 0)], ['join' => [array('table' => TBL_PROFILES . ' pf', 'condition' => 'pf.id=p.profile_id AND pf.is_delete=0'), array('table' => TBL_USERS . ' u', 'condition' => 'u.id=p.user_id AND u.is_delete=0')], 'single' => true]);
//            p($post_data);
            if (!empty($post_data)) {
                $this->data['post_data'] = $post_data;
            } else {
                custom_show_404();
            }
            $this->template->load('admin', 'admin/posts/view', $this->data);
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
            $post_data = $this->post_model->sql_select(TBL_USERS, null, ['where' => array('id' => trim($id), 'is_delete' => 0)], ['single' => true]);
            if (!empty($post_data)) {
                $update_array = array(
                    'is_delete' => 1,
                    'updated_at' => date('Y-m-d H:i:s'),
                );
                $this->post_model->common_insert_update('update', TBL_USERS, $update_array, ['id' => $id]);
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
        $result = $this->post_model->get_user_detail(['email' => trim($this->input->post('email')), 'is_delete' => 0, 'role' => 'user']);
        if (!empty($result)) {
            $this->form_validation->set_message('email_validation', 'Email Already exist!');
            return FALSE;
        } else {
            return TRUE;
        }
    }

}
