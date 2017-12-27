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
                $states = $this->users_model->sql_select(TBL_STATE, null, ['where' => array('country_id' => $user_data['country'])]);
                if (!empty($states)) {
                    $this->data['states'] = $states;
                }
                $cities = $this->users_model->sql_select(TBL_CITY, null, ['where' => array('state_id' => $user_data['state'])]);
                if (!empty($cities)) {
                    $this->data['cities'] = $cities;
                }
                $this->data['title'] = 'Remember Always Admin | Users';
                $this->data['heading'] = 'Edit User';
            } else {
                custom_show_404();
            }
        } else {
            $this->data['title'] = 'Remember Always Admin | Users';
            $this->data['heading'] = 'Add User';
        }
        
        $countries = $this->users_model->sql_select(TBL_COUNTRY . ' c');
        $this->data['countries'] = $countries;
        if (strtolower($this->input->method()) == 'post') {
            if (is_numeric($id)) {
                if (!empty($user_data) && $user_data['email'] != trim($this->input->post('email'))) {
                    $unique_email = '|callback_email_validation';
                }
            } else {
                $unique_email = '|callback_email_validation';
            }

            $states = $this->users_model->sql_select(TBL_STATE, null, ['where' => array('country_id' => base64_decode($this->input->post('country')))]);
            if (!empty($states)) {
                $this->data['states'] = $states;
            }
            $cities = $this->users_model->sql_select(TBL_CITY, null, ['where' => array('state_id' => base64_decode($this->input->post('state')))]);
            if (!empty($cities)) {
                $this->data['cities'] = $cities;
            }
        }
        $this->form_validation->set_rules('firstname', 'Firstname', 'trim|required');
        $this->form_validation->set_rules('lastname', 'Lastname', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required' . $unique_email);
        $this->form_validation->set_rules('address1', 'Address 1', 'trim|required');
        $this->form_validation->set_rules('country', 'Country', 'trim|required');
        $this->form_validation->set_rules('state', 'State', 'trim|required');
        $this->form_validation->set_rules('city', 'City', 'trim|required');
        $this->form_validation->set_rules('phone', 'Phone number', 'trim|required');
        $this->form_validation->set_rules('zipcode', 'Zipcode', 'trim|required');

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
                'address1' => trim($this->input->post('address1')),
                'country' => base64_decode(trim($this->input->post('country'))),
                'state' => base64_decode(trim($this->input->post('state'))),
                'city' => base64_decode(trim($this->input->post('city'))),
                'zipcode' => trim($this->input->post('zipcode')),
                'phone' => trim($this->input->post('phone')),
            );
            if (!empty(trim($this->input->post('address2')))) {
                $dataArr['address2'] = trim($this->input->post('address2'));
            }
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
     * View a Uesr.
     *
     */
    public function view($id) {

        if (!is_null($id))
            $id = base64_decode($id);
        if (is_numeric($id)) {
            $this->data['title'] = 'Remember Always Admin | Users';
            $this->data['heading'] = 'View Uesr Details';
            $user_data = $this->users_model->sql_select(TBL_USERS . ' u', 'u.*,con.name as country_name,st.name as state_name,c.name as city_name', ['where' => array('u.id' => trim($id), 'is_delete' => 0)], ['join'=>[array('table' => TBL_COUNTRY . ' con', 'condition' => 'con.id=u.country'),array('table' => TBL_STATE . ' st', 'condition' => 'st.id=u.state'),array('table' => TBL_CITY . ' c', 'condition' => 'c.id=u.city')],'single' => true]);
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
                                    $dataArr_media[$key]['is_delete'] = 1;
                                }
                            }
                        }
                    }
                }
            }
            $dataArr = array(
                'profile_id' => base64_decode(trim($this->input->post('profile_id'))),
                'user_id' => base64_decode(trim($this->input->post('user_id'))),
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

    /**
     * Actions for user profiles
     * @param int $id
     * */
    public function profile_action($action, $id = NULL, $user_id) {
        $id = base64_decode($id);
        if (is_numeric($id) && !empty($action)) {
            $profile_data = $this->users_model->sql_select(TBL_PROFILES, null, ['where' => array('id' => trim($id), 'is_delete' => 0)], ['single' => true]);
            if (!empty($profile_data)) {
                if ($action == 'delete') {
                    $update_array = array(
                        'is_delete' => 1,
                        'updated_at' => date('Y-m-d H:i:s'),
                    );
                    $this->session->set_flashdata('success', 'Profile has been deleted successfully!');
                } else if ($action == 'block') {
                    $update_array = array(
                        'is_blocked' => 1,
                        'updated_at' => date('Y-m-d H:i:s'),
                    );
                    $this->session->set_flashdata('success', 'Profile has been blocked successfully!');
                } else if ($action == 'unblock') {
                    $update_array = array(
                        'is_blocked' => 0,
                        'updated_at' => date('Y-m-d H:i:s'),
                    );
                    $this->session->set_flashdata('success', 'Profile has been unblocked successfully!');
                }
                $this->users_model->common_insert_update('update', TBL_PROFILES, $update_array, ['id' => $id]);
            } else {
                $this->session->set_flashdata('error', 'Unable to User slider!');
            }
        } else {
            $this->session->set_flashdata('error', 'Invalid request. Please try again!');
        }
        redirect('admin/users/profile/' . $user_id);
    }

    /**
     * View a USer profile data.
     *
     */
    public function viewprofile($id) {

        if (!is_null($id))
            $id = base64_decode($id);
        if (is_numeric($id)) {
            $this->data['title'] = 'Remember Always Admin | User Profile';
            $this->data['heading'] = 'View User Profile Details';
            $profile_data = $this->users_model->sql_select(TBL_PROFILES . ' p', 'p.*,u.firstname as user_fname,u.lastname as user_lname,fp.goal,fp.title,fp.details,fp.end_date,fp.created_at as fp_created_at', ['where' => array('p.id' => trim($id), 'p.is_delete' => 0)], ['join' => [array('table' => TBL_USERS . ' u', 'condition' => 'u.id=p.user_id AND u.is_delete=0'), array('table' => TBL_FUNDRAISER_PROFILES . ' fp', 'condition' => 'fp.profile_id=p.id AND fp.is_delete=0')], 'single' => true]);
            if (!empty($profile_data)) {
                $fun_facts = $this->users_model->sql_select(TBL_FUN_FACTS . ' f', 'f.*', ['where' => array('f.profile_id' => trim($id), 'f.is_delete' => 0)]);
//                $affiliations = $this->users_model->sql_select(TBL_PROFILE_AFFILIATION . ' ap', 'ap.*,u.firstname as user_fname,u.lastname as user_lname,p.firstname as p_fname,p.lastname as p_lname', ['where' => array('ap.profile_id' => trim($id), 'a.is_delete' => 0)], ['join' => [
//                        array('table' => TBL_AFFILIATIONS . ' a', 'condition' => 'ap.affiliation_id=a.id AND a.is_delete=0'),
//                        array('table' => TBL_USERS . ' u', 'condition' => 'u.id=a.user_id AND u.is_delete=0'),
//                        array('table' => TBL_PROFILES . ' p', 'condition' => 'p.id=ap.profile_id AND p.is_delete=0'),
//                        array('table' => TBL_AFFILIATIONS_CATEGORY . ' ac', 'condition' => 'a.category_id=ac.id AND ac.is_delete=0')]]);
//                p(qry(),1);
                $sql = "SELECT * FROM ("
                        . "SELECT id,affiliation_text as name,'1' as free_text,created_at,'NULL' as category_name FROM " . TBL_PROFILE_AFFILIATIONTEXTS . " WHERE profile_id=" . $profile_data['id'] . "
                           UNION ALL
                           SELECT p.id,a.name,'0' as free_text,p.created_at,ac.name as category_name FROM " . TBL_PROFILE_AFFILIATION . " p JOIN " . TBL_AFFILIATIONS . " a ON p.affiliation_id=a.id LEFT JOIN " . TBL_AFFILIATIONS_CATEGORY . " ac ON ac.id=a.category_id WHERE p.profile_id=" . $profile_data['id'] . " AND a.is_delete=0) a";
                $affiliations = $this->users_model->customQuery($sql);
//                p(qry());
                $funnel_services = $this->users_model->sql_select(TBL_FUNERAL_SERVICES . ' fs', 'fs.*,c.name as city_name,s.name as state_name', ['where' => array('fs.profile_id' => trim($id), 'fs.is_delete' => 0)], ['join' => [array('table' => TBL_STATE . ' s', 'condition' => 's.id=fs.state'), array('table' => TBL_CITY . ' c', 'condition' => 'c.id=fs.city')]]);
                $funnel_services_data = ['Burial' => [], 'Funeral' => [], 'Memorial' => []];
                foreach ($funnel_services as $key => $value) {
                    if ($value['service_type'] == 'Burial') {
                        $funnel_services_data['Burial'] = $value;
                    } else if ($value['service_type'] == 'Memorial') {
                        $funnel_services_data['Memorial'] = $value;
                    } else if ($value['service_type'] == 'Funeral') {
                        $funnel_services_data['Funeral'] = $value;
                    }
                }
                $this->data['profile_data'] = $profile_data;
                $this->data['affiliations'] = $affiliations;
                $this->data['fun_facts'] = $fun_facts;
                $this->data['funnel_services'] = $funnel_services_data;
            } else {
                custom_show_404();
            }
            $this->template->load('admin', 'admin/profile/view', $this->data);
        } else {
            custom_show_404();
        }
    }

    /**
     * Display login page for login
     */
    public function load_data() {
        $offset = 2;
        $id = base64_decode($this->input->post('id'));
        $type = $this->input->post('type');
        if ($type == 'affiliation') {
            $affiliations = $this->users_model->sql_select(TBL_AFFILIATIONS . ' a', 'a.*,ac.name as category_name,co.name as country_name,c.name as city_name,s.name as state_name', ['where' => array('a.id' => trim($id), 'a.is_delete' => 0)], ['single' => true, 'join' => [array('table' => TBL_AFFILIATIONS_CATEGORY . ' ac', 'condition' => 'ac.id=a.category_id AND ac.is_delete=0'), array('table' => TBL_COUNTRY . ' co', 'condition' => 'co.id=a.country'), array('table' => TBL_STATE . ' s', 'condition' => 's.id=a.state'), array('table' => TBL_CITY . ' c', 'condition' => 'c.id=a.city')]]);
            if (!empty($affiliations)) {
                $affiliations['created_at'] = date('d M Y', strtotime($affiliations['created_at']));
                if ($affiliations['image'] != null) {
                    $affiliations['url'] = AFFILIATION_IMAGE . $affiliations['image'];
                }
                echo json_encode($affiliations);
            } else {
                echo json_encode([]);
            }
        }
//        else if ($type == 'funfact') {
//            $affiliations = $this->users_model->sql_select(TBL_FUN_FACTS . ' a', 'a.*,ac.name as category_name,co.name as country_name,c.name as city_name,s.name as state_name', ['where' => array('a.id' => trim($id), 'a.is_delete' => 0)], ['single' => true, 'join' => [array('table' => TBL_AFFILIATIONS_CATEGORY . ' ac', 'condition' => 'ac.id=a.category_id AND ac.is_delete=0'), array('table' => TBL_COUNTRY . ' co', 'condition' => 'co.id=a.country'), array('table' => TBL_STATE . ' s', 'condition' => 's.id=a.state'), array('table' => TBL_CITY . ' c', 'condition' => 'c.id=a.city')]]);
//            if (!empty($affiliations)) {
//                $affiliations['created_at'] = date('d M Y', strtotime($affiliations['created_at']));
//                echo $affiliations;
//                exit;
//            } else {
//                echo '';
//                exit;
//            }
//        }
    }

}
