<?php

/**
 * Profile Controller
 * Manage profile related functions
 * @author KU 
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Display login page for login
     */
    public function index($slug) {

        $is_left = $this->users_model->sql_select(TBL_PROFILES, '*', ['where' => ['is_delete' => 0, 'slug' => $slug]], ['single' => true]);
        if (!empty($is_left)) {
            $funnel_services_data = [];
            $post_data = [];
            $final_post_data = [];
            $post_id = 0;
            $fun_facts = $this->users_model->sql_select(TBL_FUN_FACTS . ' f', 'f.*', ['where' => array('f.profile_id' => trim($is_left['id']), 'f.is_delete' => 0)], ['order_by' => 'f.id DESC']);
            $posts = $this->users_model->sql_select(TBL_POSTS . ' p', 'p.*,u.firstname,u.lastname,u.profile_image,pm.media,pm.type', ['where' => array('p.profile_id' => trim($is_left['id']), 'p.is_delete' => 0)], ['join' => [array('table' => TBL_POST_MEDIAS . ' pm', 'condition' => 'pm.post_id=p.id AND pm.is_delete=0'), array('table' => TBL_USERS . ' u', 'condition' => 'u.id=p.user_id AND u.is_delete=0')], 'order_by' => 'p.id DESC']);
            $funnel_services = $this->users_model->sql_select(TBL_FUNERAL_SERVICES . ' fs', 'fs.*,c.name as city_name,s.name as state_name', ['where' => array('fs.profile_id' => trim($is_left['id']), 'fs.is_delete' => 0)], ['join' => [array('table' => TBL_STATE . ' s', 'condition' => 's.id=fs.state'), array('table' => TBL_CITY . ' c', 'condition' => 'c.id=fs.city')], 'order_by' => 'fs.id DESC']);
            $life_gallery = $this->users_model->sql_select(TBL_FUNERAL_SERVICES . ' fs', 'fs.*,c.name as city_name,s.name as state_name', ['where' => array('fs.profile_id' => trim($is_left['id']), 'fs.is_delete' => 0)], ['join' => [array('table' => TBL_STATE . ' s', 'condition' => 's.id=fs.state'), array('table' => TBL_CITY . ' c', 'condition' => 'c.id=fs.city')], 'order_by' => 'fs.id DESC']);
            $funnel_services_data = ['Burial' => [], 'Funeral' => [], 'Memorial' => []];
            if (!empty($funnel_services)) {
                foreach ($funnel_services as $key => $value) {
                    if ($value['service_type'] == 'Burial') {
                        $funnel_services_data['Burial'] = $value;
                    } else if ($value['service_type'] == 'Memorial') {
                        $funnel_services_data['Memorial'] = $value;
                    } else if ($value['service_type'] == 'Funeral') {
                        $funnel_services_data['Funeral'] = $value;
                    }
                }
            }
            if (!empty($posts)) {
                foreach ($posts as $key => $value) {
                    if ($post_id != $value['id']) {
                        $post_id = $value['id'];
                        $post_data[$post_id][] = $value;
                    } else {
                        $post_data[$post_id][] = $value;
                    }
                }
                foreach ($post_data as $key => $value) {
                    $final_post_data[$key] = array('id' => $value[0]['id'],
                        'profile_id' => $value[0]['profile_id'],
                        'user_id' => $value[0]['user_id'],
                        'firstname' => $value[0]['firstname'],
                        'lastname' => $value[0]['lastname'],
                        'profile_image' => $value[0]['profile_image'],
                        'comment' => $value[0]['comment'],
                        'created_at' => $value[0]['created_at'],
                        'updated_at' => $value[0]['updated_at'],
                        'is_delete' => $value[0]['is_delete'],
                    );
                    foreach ($value as $k => $val) {
                        if ($val['media'] != null) {
                            $final_post_data[$key]['media'][$val['type']][] = $val['media'];
                        }
                    }
                }
            }
            if ($_POST) {
//                p($this->input->post(), 1);
                $this->form_validation->set_rules('comment', 'comment', 'trim|required');
                if ($this->form_validation->run() == FALSE) {
                    $this->data['error'] = validation_errors();
                } else {
                    $dataArr = array(
                        'profile_id' => $is_left['id'],
                        'user_id' => $is_left['user_id'],
                        'created_at' => date('Y-m-d H:i:s'),
                    );
                    if (!empty(trim($this->input->post('comment')))) {
                        $dataArr['comment'] = trim($this->input->post('comment'));
                    }
                    $id = $this->users_model->common_insert_update('insert', TBL_POSTS, $dataArr);
//                    if (isset($dataArr_media) && !empty($dataArr_media)) {
//                        foreach ($dataArr_media as $key => $value) {
//                            $dataArr_media[$key]['post_id'] = $id;
//                        }
//                        $this->post_model->batch_insert_update('insert', TBL_POST_MEDIAS, $dataArr_media);
////                    p($dataArr_media, 1);
//                    }
                    $this->session->set_flashdata('success', 'Post details has been inserted successfully.');
                    redirect('profile/' . $slug);
                }
            }
            $data['url'] = current_url();
            $data['profile'] = $is_left;
            $data['fun_facts'] = $fun_facts;
            $data['funnel_services'] = $funnel_services_data;
            $data['posts'] = $final_post_data;
            $data['title'] = 'Profile';
            $data['breadcrumb'] = ['title' => 'User Profile', 'links' => [['link' => site_url(), 'title' => 'Home']]];
            $this->template->load('default', 'profile/profile_detail', $data);
        }
    }

    /**
     * Create Profile Page
     * @author KU
     */
    public function create() {
        if (!$this->is_user_loggedin) {
            $this->session->set_flashdata('error', 'You must login to access this page');
            redirect('/');
        }
        // check any user's profile is left to be published
        $is_left = $this->users_model->sql_select(TBL_PROFILES, '*', ['where' => ['is_published' => 0, 'is_delete' => 0, 'user_id' => $this->user_id]], ['single' => true, 'order_by' => 'id DESC']);
        if (!empty($is_left)) {
            $data['profile'] = $is_left;
            $data['profile_gallery'] = $this->users_model->sql_select(TBL_GALLERY, '*', ['where' => ['profile_id' => $is_left['id'], 'is_delete' => 0]], ['order_by' => 'id DESC']);
        }
        if ($_POST) {
            $this->form_validation->set_rules('firstname', 'Firstname', 'trim|required');
            $this->form_validation->set_rules('lastname', 'Lastname', 'trim|required');
            $this->form_validation->set_rules('date_of_birth', 'Date of Birth', 'trim|required');
            $this->form_validation->set_rules('date_of_death', 'Date of Death', 'trim|required');

            if ($this->form_validation->run() == FALSE) {
                $data['error'] = validation_errors();
                $data['success'] = false;
            } else {

                $profile_process = $this->input->post('profile_process');
                $flag = 0;
                $profile_image = '';
                if (!empty($is_left)) {
                    $profile_image = $is_left['profile_image'];
                }
                if (!empty($this->input->post('nickname'))) {
                    $slug = trim($this->input->post('nickname'));
                } else {
                    $slug = trim($this->input->post('firstname')) . '-' . trim($this->input->post('lastname'));
                }
                if (!empty($is_left)) {
                    $slug = slug($slug, TBL_PROFILES, $is_left['id']);
                } else {
                    $slug = slug($slug, TBL_PROFILES);
                }

                //-- check if profile image is there in $_FILES array
                if ($_FILES['profile_image']['name'] != '') {
                    $directory = 'user_' . $this->user_id;
                    if (!file_exists(PROFILE_IMAGES . $directory)) {
                        mkdir(PROFILE_IMAGES . $directory);
                    }

                    $image_data = upload_image('profile_image', PROFILE_IMAGES . $directory);
                    if (is_array($image_data)) {
                        $flag = 1;
                        $data['error'] = $image_data['errors'];
                        $data['success'] = false;
                    } else {
                        if ($profile_image != '') {
                            unlink(PROFILE_IMAGES . $profile_image);
                        }
                        $profile_image = $directory . '/' . $image_data;
                    }
                }

                if ($flag != 1) {
                    $data = array(
                        'user_id' => $this->user_id,
                        'profile_process' => $this->input->post('profile_process'),
                        'firstname' => trim($this->input->post('firstname')),
                        'lastname' => trim($this->input->post('lastname')),
                        'nickname' => trim($this->input->post('nickname')),
                        'slug' => $slug,
                        'profile_image' => $profile_image,
                        'life_bio' => trim($this->input->post('life_bio')),
                        'date_of_birth' => date('Y-m-d H:i:s', strtotime($this->input->post('date_of_birth'))),
                        'date_of_death' => date('Y-m-d H:i:s', strtotime($this->input->post('date_of_death'))),
                    );
                    if (!empty($is_left)) {
                        $data['updated_at'] = date('Y-m-d H:i:s');
                        $this->users_model->common_insert_update('update', TBL_PROFILES, $data, ['id' => $is_left['id']]);
                        $profile_id = $is_left['id'];
                    } else {
                        $data['created_at'] = date('Y-m-d H:i:s');
                        $profile_id = $this->users_model->common_insert_update('insert', TBL_PROFILES, $data);
                    }
                    if (!file_exists(PROFILE_IMAGES . 'user_' . $this->user_id . '/profile_' . $profile_id)) {
                        mkdir(PROFILE_IMAGES . 'user_' . $this->user_id . '/profile_' . $profile_id);
                        if ($_FILES['profile_image']['name'] != '') {
                            rename(PROFILE_IMAGES . $profile_image, PROFILE_IMAGES . 'user_' . $this->user_id . '/profile_' . $profile_id . '/' . $image_data);
                            $this->users_model->common_insert_update('update', TBL_PROFILES, ['profile_image' => 'user_' . $this->user_id . '/profile_' . $profile_id . '/' . $image_data], ['id' => $profile_id]);
                        }
                    }
                    $data['id'] = $profile_id;
                    $data['success'] = true;
                    $data['data'] = $data;
                }
            }
            echo json_encode($data);
            exit;
        }
        $data['breadcrumb'] = ['title' => 'Create a Life Profile', 'links' => [['link' => site_url(), 'title' => 'Home']]];
        $data['title'] = 'Remember Always | Create Profile';
        $this->template->load('default', 'profile/profile_form', $data);
    }

    /**
     * Upload profile gallery
     * @author KU
     */
    public function upload_gallery() {
        $data = [];
        if ($_FILES) {
            $profile_id = base64_decode($this->input->post('profile_id'));
            $profile = $this->users_model->sql_select(TBL_PROFILES, 'user_id', ['where' => ['id' => $profile_id, 'is_delete' => 0]], ['single' => true]);
            if (!empty($profile)) {

                $directory = 'user_' . $profile['user_id'];
                if (!file_exists(PROFILE_IMAGES . $directory)) {
                    mkdir(PROFILE_IMAGES . $directory);
                }
                $sub_directory = 'profile_' . $profile_id;
                if (!file_exists(PROFILE_IMAGES . $directory . '/' . $sub_directory)) {
                    mkdir(PROFILE_IMAGES . $directory . '/' . $sub_directory);
                }
                if ($this->input->post('type') == 'image') {

                    $image_data = upload_image('gallery', PROFILE_IMAGES . $directory . '/' . $sub_directory);
                    if (is_array($image_data)) {
                        $data['error'] = $image_data['errors'];
                        $data['success'] = false;
                    } else {
                        $id = $this->users_model->common_insert_update('insert', TBL_GALLERY, ['profile_id' => $profile_id, 'user_id' => $this->user_id, 'media' => $directory . '/' . $sub_directory . '/' . $image_data, 'type' => 1, 'created_at' => date('Y-m-d H:i:s')]);
                        $data['success'] = true;
                        $data['data'] = base64_encode($id);
                    }
                } elseif ($this->input->post('type') == 'video') {
                    $video_data = upload_video('gallery', PROFILE_IMAGES . $directory . '/' . $sub_directory);
                    if (is_array($video_data)) {
                        $data['error'] = $video_data['errors'];
                        $data['success'] = false;
                    } else {
                        $id = $this->users_model->common_insert_update('insert', TBL_GALLERY, ['profile_id' => $profile_id, 'user_id' => $this->user_id, 'media' => $directory . '/' . $sub_directory . '/' . $video_data, 'type' => 2, 'created_at' => date('Y-m-d H:i:s')]);
                        $data['success'] = true;
                        $data['data'] = base64_encode($id);
                    }
                }
            } else {
                $data['success'] = false;
                $data['error'] = "Something went wrong!";
            }
        } else {
            $data['success'] = false;
            $data['error'] = "Invalid data!";
        }
        echo json_encode($data);
        exit;
    }

    /**
     * Delete uploaded profile gallery 
     * @author KU
     */
    public function delete_gallery() {
        $gallery = base64_decode($this->input->post('gallery'));
        $gallery_media = $this->users_model->sql_select(TBL_GALLERY, 'media', ['where' => ['id' => $gallery, 'is_delete' => 0]], ['single' => true]);
        if (!empty($gallery_media)) {
            $this->users_model->common_delete(TBL_GALLERY, ['id' => $gallery]);
            unlink(PROFILE_IMAGES . $gallery_media['media']);
            $data['success'] = true;
        } else {
            $data['success'] = false;
            $data['error'] = "Invalid request!";
        }
        echo json_encode($data);
        exit;
    }

}
