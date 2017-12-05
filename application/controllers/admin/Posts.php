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
            $post_data = $this->post_model->sql_select(TBL_POSTS, null, ['where' => array('id' => trim($id), 'is_delete' => 0)], ['single' => true]);
            if (!empty($post_data)) {
                $profiles = $this->post_model->sql_select(TBL_PROFILES, null, ['where' => array('is_delete' => 0, 'user_id' => $post_data['user_id'])]);
                if (!empty($profiles)) {
                    $this->data['profiles'] = $profiles;
                }
                $this->data['post_data'] = $post_data;
                $this->data['title'] = 'Remember Always Admin | Posts';
                $this->data['heading'] = 'Edit Post';
            } else {
                custom_show_404();
            }
        } else {
            $this->data['title'] = 'Remember Always Admin | Posts';
            $this->data['heading'] = 'Add Post';
        }
        $users = $this->post_model->sql_select(TBL_USERS, null, ['where' => array('is_delete' => 0, 'role' => 'user')]);
        if (!empty($users)) {
            $this->data['users'] = $users;
        }
        $this->form_validation->set_rules('profile_id', 'Profile', 'trim|required');
        $this->form_validation->set_rules('user_id', 'User', 'trim|required');
        $this->form_validation->set_rules('comment', 'comment', 'callback_al_least_one_value');


        if ($this->input->method() == 'post') {
            $profiles = $this->post_model->sql_select(TBL_PROFILES, null, ['where' => array('is_delete' => 0, 'user_id' => base64_decode($this->input->post('user_id')))]);
            if (!empty($profiles)) {
                $this->data['profiles'] = $profiles;
            }
        }
//        $this->form_validation->set_rules('comment', 'Comment', 'trim|required' . $unique_email);

        if ($this->form_validation->run() == FALSE) {
            $this->data['error'] = validation_errors();
        } else {
            p($_FILES);
            $dataArr = array(
                'profile_id' => trim($this->input->post('profile_id')),
                'user_id' => trim($this->input->post('user_id')),
            );
            if (!empty(trim($this->input->post('comment')))) {
                $dataArr['comment'] = trim($this->input->post('comment'));
            }
            p($dataArr, 1);
            if (is_numeric($id)) {
                $dataArr['updated_at'] = date('Y-m-d H:i:s');
                $this->post_model->common_insert_update('update', TBL_POSTS, $dataArr, ['id' => $id]);
                $this->session->set_flashdata('success', 'Post details has been updated successfully.');
            } else {
                $dataArr['created_at'] = date('Y-m-d H:i:s');
                $id = $this->post_model->common_insert_update('insert', TBL_POSTS, $dataArr);
                $this->session->set_flashdata('success', 'Post details has been inserted successfully.');
            }
            redirect('admin/users');
        }
        $this->template->load('admin', 'admin/posts/manage', $this->data);
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
            $post_data = $this->post_model->sql_select(TBL_POSTS . ' p', 'p.id as p_id,p.created_at as p_date,p.comment,u.firstname as user_fname,u.lastname as user_lname,pf.firstname as profile_fname,pf.lastname as profile_lname,pf.privacy,pf.type', ['where' => array('p.id' => trim($id), 'p.is_delete' => 0)], ['join' => [array('table' => TBL_PROFILES . ' pf', 'condition' => 'pf.id=p.profile_id AND pf.is_delete=0'), array('table' => TBL_POSTS . ' u', 'condition' => 'u.id=p.user_id AND u.is_delete=0')], 'single' => true]);
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
//    public function delete($id = NULL) {
//        $id = base64_decode($id);
//        if (is_numeric($id)) {
//            $post_data = $this->post_model->sql_select(TBL_POSTS, null, ['where' => array('id' => trim($id), 'is_delete' => 0)], ['single' => true]);
//            if (!empty($post_data)) {
//                $update_array = array(
//                    'is_delete' => 1,
//                    'updated_at' => date('Y-m-d H:i:s'),
//                );
//                $this->post_model->common_insert_update('update', TBL_POSTS, $update_array, ['id' => $id]);
//                $this->session->set_flashdata('success', 'User has been deleted successfully!');
//            } else {
//                $this->session->set_flashdata('error', 'Unable to User slider!');
//            }
//        } else {
//            $this->session->set_flashdata('error', 'Invalid request. Please try again!');
//        }
//        redirect('admin/users');
//    }
    /**
     * Delete service provider
     * @param int $id
     * */
    public function get_user_profile() {
        $id = base64_decode($this->input->post('id'));
        $options = '<option value="">-- Select User Profile --</option>';
        if (is_numeric($id)) {
            $post_data = $this->post_model->sql_select(TBL_PROFILES, null, ['where' => array('user_id' => trim($id), 'is_delete' => 0)]);
            qry();
            if (!empty($post_data)) {
                foreach ($post_data as $row) {
                    $options .= "<option value = '" . base64_encode($row['id']) . "'>" . $row['firstname'] . ' ' . $row['lastname'] . "</option>";
                }
            }
        }
        echo $options;
    }

    /**
     * Callback Validate function to check service category already exists or not.
     * @return boolean
     */
    public function al_least_one_value($value) {
//        p($_FILES['image']['name'][0], 1);
//var_dump((isset($_FILES['image']) && empty($_FILES['image']['name'][0])));
//var_dump((isset($_FILES['video']) && empty($_FILES['video']['name'][0])));
        if (trim($this->input->post('comment')) == '' && ((isset($_FILES['image']) && empty($_FILES['image']['name'][0])) && ((isset($_FILES['video']) && empty($_FILES['video']['name'][0]))))) {
            $this->form_validation->set_message('al_least_one_value', 'Please enter commment or select image or select video.');
            return FALSE;
        } else {
            return TRUE;
        }
    }

}
