<?php

/**
 * Providers Controller to manage service users
 * @author KU 
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('users_model', 'post_model');
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
                $verification_code = base64_encode($verification_code);
                $encoded_verification_code = urlencode($verification_code);
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

    /**
     * Add a new service provider.
     *
     */
    public function postadd($user_id = null, $id = null) {
        $unique_email = '';
        if (!is_null($user_id)) {
            $this->data['user_id'] = $user_id;
            $user_id = base64_decode($user_id);
        }
        if (is_numeric($user_id)) {
            $profiles = $this->post_model->sql_select(TBL_PROFILES, null, ['where' => array('is_delete' => 0, 'user_id' => $user_id)]);
            if (!empty($profiles)) {
                $this->data['profiles'] = $profiles;
            }
        }
        if (!is_null($id))
            $id = base64_decode($id);
        if (is_numeric($id)) {
//            $post_data = $this->post_model->sql_select(TBL_POSTS, null, ['where' => array('id' => trim($id), 'is_delete' => 0)], ['single' => true]);
            $post_data = $this->post_model->sql_select(TBL_POSTS . ' p', 'p.*,pf.user_id as pf_user_id,u.firstname as user_fname,u.lastname as user_lname,pf.firstname as profile_fname,pf.lastname as profile_lname,pf.privacy,pf.type', ['where' => array('p.id' => $id, 'p.is_delete' => 0)], ['join' => [array('table' => TBL_PROFILES . ' pf', 'condition' => 'pf.id=p.profile_id AND pf.is_delete=0'), array('table' => TBL_USERS . ' u', 'condition' => 'u.id=pf.user_id AND u.is_delete=0')], 'single' => true]);
            if (!empty($post_data)) {
                $profiles = $this->post_model->sql_select(TBL_PROFILES, null, ['where' => array('is_delete' => 0, 'user_id' => $post_data['pf_user_id'])]);
                if (!empty($profiles)) {
                    $this->data['profiles'] = $profiles;
                }
                $post_media = $this->post_model->sql_select(TBL_POST_MEDIAS, null, ['where' => array('is_delete' => 0, 'post_id' => $id)]);
                if (!empty($post_media)) {
                    $dataArr_media = $post_media;
                    $this->data['post_media'] = $post_media;
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
        $this->form_validation->set_rules('comment', 'comment', 'callback_al_least_one_value');
        if ($this->form_validation->run() == FALSE) {
            $this->data['error'] = validation_errors();
        } else {
            if (isset($_FILES['image']) && !empty($_FILES['image']['name'][0])) {
                if (is_numeric($id)) {
                    if (isset($post_media) && !empty($post_media)) {
                        $exist_files = $this->input->post('hidden_other_image_id');
                        if (!empty($exist_files)) {
                            foreach ($dataArr_media as $key => $value) {
                                if ($value['type'] == '1') {
                                    $exist_images_index = array_search($value['id'], $exist_files);
                                    if ($exist_images_index === false) {
                                        $update_media[$value['id']] = $value['id'];
                                    }
                                }
                            }
                        } else {
                            foreach ($dataArr_media as $key => $value) {
                                if ($value['type'] == '1') {
                                    $dataArr_media[$key]['is_delete'] = 1;
                                }
                            }
                        }
                    }
                }
                foreach ($_FILES['image']['name'] as $key => $value) {
                    $extension = explode('/', $_FILES['image']['type'][$key]);
                    $_FILES['custom_image']['name'] = $_FILES['image']['name'][$key];
                    $_FILES['custom_image']['type'] = $_FILES['image']['type'][$key];
                    $_FILES['custom_image']['tmp_name'] = $_FILES['image']['tmp_name'][$key];
                    $_FILES['custom_image']['error'] = $_FILES['image']['error'][$key];
                    $_FILES['custom_image']['size'] = $_FILES['image']['size'][$key];
                    $image_data = upload_multiple_image('custom_image', end($extension), POST_IMAGES);
                    if (is_array($image_data)) {
                        $flag = 1;
                        $data['image_validation'] = $image_data['errors'];
                    } else {
                        $image = $image_data;
                        if (is_numeric($id)) {
                            $dataArr_media[] = array(
                                'id' => "''",
                                'post_id' => $id,
                                'media' => $image,
                                'type' => 1,
                                'created_at' => date('Y-m-d H:i:s'),
                            );
                        } else {
                            $dataArr_media[] = array(
                                'media' => $image,
                                'type' => 1,
                                'created_at' => date('Y-m-d H:i:s'),
                            );
                        }
                    }
                }
            } else {
                if (is_numeric($id)) {
                    if (isset($post_media) && !empty($post_media)) {
                        $exist_files = $this->input->post('hidden_other_image_id');
                        if (!empty($exist_files)) {
                            foreach ($dataArr_media as $key => $value) {
                                if ($value['type'] == '1') {
                                    $exist_images_index = array_search($value['id'], $exist_files);
                                    if ($exist_images_index === false) {
                                        $update_media[$value['id']] = $value['id'];
                                    }
                                }
                            }
                        } else {
                            foreach ($dataArr_media as $key => $value) {
                                if ($value['type'] == '1') {
                                    $dataArr_media[$key]['is_delete'] = 1;
                                }
                            }
                        }
                    }
                }
            }

            if (isset($_FILES['video']) && !empty($_FILES['video']['name'][0])) {
                if (is_numeric($id)) {
                    if (isset($post_media) && !empty($post_media)) {
                        $exist_video_files = $this->input->post('hidden_other_video_id');
                        if (!empty($exist_video_files)) {
                            foreach ($dataArr_media as $key => $value) {
                                if ($value['type'] == '2') {
                                    $exist_video_index = array_search($value['id'], $exist_video_files);
                                    if ($exist_video_index === false) {
                                        $update_media[$value['id']] = $value['id'];
                                    }
                                }
                            }
                        } else {
                            foreach ($dataArr_media as $key => $value) {
                                if ($value['type'] == '2') {
                                    $dataArr_media[$key]['is_delete'] = 1;
                                }
                            }
                        }
                    }
                }
                foreach ($_FILES['video']['name'] as $key => $value) {
                    $extension = explode('/', $_FILES['video']['type'][$key]);
                    $_FILES['custom_video']['name'] = $_FILES['video']['name'][$key];
                    $_FILES['custom_video']['type'] = $_FILES['video']['type'][$key];
                    $_FILES['custom_video']['tmp_name'] = $_FILES['video']['tmp_name'][$key];
                    $_FILES['custom_video']['error'] = $_FILES['video']['error'][$key];
                    $_FILES['custom_video']['size'] = $_FILES['video']['size'][$key];
                    $video_data = upload_multiple_image('custom_video', end($extension), POST_IMAGES, 'video', 'mp4');
                    if (is_array($video_data)) {
                        $flag = 1;
                        $data['video_validation'] = $video_data['errors'];
                    } else {
                        $video = $video_data;
                        if (is_numeric($id)) {
                            $dataArr_media[] = array(
                                'id' => "''",
                                'post_id' => $id,
                                'media' => $video,
                                'type' => 2,
                                'created_at' => date('Y-m-d H:i:s'),
                            );
                        } else {
                            $dataArr_media[] = array(
                                'media' => $video,
                                'type' => 2,
                                'created_at' => date('Y-m-d H:i:s'),
                            );
                        }
                    }
                }
            } else {
                if (is_numeric($id)) {
                    if (isset($post_media) && !empty($post_media)) {
                        $exist_video_files = $this->input->post('hidden_other_video_id');
                        if (!empty($exist_video_files)) {
                            foreach ($dataArr_media as $key => $value) {
                                if ($value['type'] == '2') {
                                    $exist_video_index = array_search($value['id'], $exist_video_files);
                                    if ($exist_video_index === false) {
                                        $update_media[$value['id']] = $value['id'];
                                    }
                                }
                            }
                        } else {
                            foreach ($dataArr_media as $key => $value) {
                                if ($value['type'] == 2) {
//                                    var_dump($value);
//                                    p($dataArr_media[$key]['is_delete']);
                                    $dataArr_media[$key]['is_delete'] = 1;
                                }
                            }
                        }
                    }
                }
            }
            $dataArr = array(
                'profile_id' => base64_decode(trim($this->input->post('profile_id'))),
                'user_id' => 1,
            );
            if (!empty(trim($this->input->post('comment')))) {
                $dataArr['comment'] = trim($this->input->post('comment'));
            }

            if (is_numeric($id)) {
                $dataArr['updated_at'] = date('Y-m-d H:i:s');
                $this->post_model->common_insert_update('update', TBL_POSTS, $dataArr, ['id' => $id]);
                if (isset($dataArr_media) && !empty($dataArr_media)) {
                    foreach ($dataArr_media as $key => $values) {
                        $values['media'] = "'" . $values['media'] . "'";
                        $values['created_at'] = "'" . $values['created_at'] . "'";
                        $values['updated_at'] = "'" . date('Y-m-d H:i:s') . "'";
                        if (isset($update_media)) {
                            if (array_key_exists($values['id'], $update_media)) {
                                $values['is_delete'] = 1;
                            } else {
                                $values['is_delete'] = 0;
                            }
                        } else {
                            if (!isset($values['is_delete'])) {
                                $values['is_delete'] = 0;
                            }
                        }
                        $inser_keys = implode(',', array_keys($values));
                        $insert_data[] = '(' . implode(',', $values) . ')';
                    }

                    $keys = explode(',', $inser_keys);
                    foreach ($keys as $k) {
                        $update_keys[] = $k . '= VALUES(' . $k . ')';
                    }
                    $this->db->query('INSERT INTO ' . TBL_POST_MEDIAS . '(' . $inser_keys . ') VALUES ' . implode(',', $insert_data) . ' ON DUPLICATE KEY UPDATE ' . implode(',', $update_keys) . '');
                }
                $this->session->set_flashdata('success', 'Post details has been updated successfully.');
            } else {
                $dataArr['created_at'] = date('Y-m-d H:i:s');
                $id = $this->post_model->common_insert_update('insert', TBL_POSTS, $dataArr);
                if (isset($dataArr_media) && !empty($dataArr_media)) {
                    foreach ($dataArr_media as $key => $value) {
                        $dataArr_media[$key]['post_id'] = $id;
                    }
                    $this->post_model->batch_insert_update('insert', TBL_POST_MEDIAS, $dataArr_media);
//                    p($dataArr_media, 1);
                }
                $this->session->set_flashdata('success', 'Post details has been inserted successfully.');
            }
            redirect('admin/users/posts/' . base64_encode($user_id));
        }
        $this->template->load('admin', 'admin/posts/manage', $this->data);
    }

    /**
     * view a service provider .
     *
     */
    public function postedit($user_id, $id) {
        $this->postadd($user_id, $id);
    }

    /**
     * Delete service provider
     * @param int $id
     * */
    public function postdelete($user_id = NULL, $id = NULL) {
        $id = base64_decode($id);
        $user_id = base64_decode($user_id);
        if (is_numeric($id) || is_numeric($user_id)) {
            $post_data = $this->post_model->sql_select(TBL_POSTS, null, ['where' => array('id' => trim($id), 'is_delete' => 0)], ['single' => true]);
            if (!empty($post_data)) {
                $post_media = $this->post_model->sql_select(TBL_POST_MEDIAS, null, ['where' => array('post_id' => trim($id), 'is_delete' => 0)], ['single' => true]);
                $update_array = array(
                    'is_delete' => 1,
                    'updated_at' => date('Y-m-d H:i:s'),
                );
                $this->post_model->common_insert_update('update', TBL_POSTS, $update_array, ['id' => $id]);
                if (!empty($post_media)) {
                    $this->post_model->common_insert_update('update', TBL_POST_MEDIAS, $update_array, ['post_id' => $id]);
                }
                $this->session->set_flashdata('success', 'Post has been deleted successfully!');
            } else {
                $this->session->set_flashdata('error', 'Unable to User slider!');
            }
        } else {
            $this->session->set_flashdata('error', 'Invalid request. Please try again!');
        }
        redirect('admin/users/posts/' . base64_encode($user_id));
    }

    /**
     * Callback Validate function to check service category already exists or not.
     * @return boolean
     */
    public function al_least_one_value($value) {
        if (trim($this->input->post('comment')) == '' && ((isset($_FILES['image']) && empty($_FILES['image']['name'][0])) && ((isset($_FILES['video']) && empty($_FILES['video']['name'][0]))))) {
            $this->form_validation->set_message('al_least_one_value', 'Please enter commment or select image or select video.');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    /**
     * Display listing of profiles of particular user.
     */
    public function profile($user_id = null) {
        if ($user_id != null) {
            $data['user_id'] = $user_id;
        }
        $data['title'] = 'Remember Always Admin | User Profile';
        $this->template->load('admin', 'admin/profile/index', $data);
    }

    /**
     * Get profiles data for AJAX table
     * */
    public function get_profiles($user_id = null) {
        $final['recordsFiltered'] = $final['recordsTotal'] = $this->users_model->get_profiles('count', base64_decode($user_id));
        $final['redraw'] = 1;
        $users = $this->users_model->get_profiles('result', base64_decode($user_id));
//        qry();
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

}
