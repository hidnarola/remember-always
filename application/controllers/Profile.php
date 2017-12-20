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

            $post_id = 0;
            $fun_facts = $this->users_model->sql_select(TBL_FUN_FACTS . ' f', 'f.*', ['where' => array('f.profile_id' => trim($is_left['id']), 'f.is_delete' => 0)], ['order_by' => 'f.id DESC']);

            $funnel_services = $this->users_model->sql_select(TBL_FUNERAL_SERVICES . ' fs', 'fs.*,c.name as city_name,s.name as state_name', ['where' => array('fs.profile_id' => trim($is_left['id']), 'fs.is_delete' => 0)], ['join' => [array('table' => TBL_STATE . ' s', 'condition' => 's.id=fs.state'), array('table' => TBL_CITY . ' c', 'condition' => 'c.id=fs.city')], 'order_by' => 'fs.id DESC']);
            $life_gallery = $this->users_model->sql_select(TBL_GALLERY . ' pg', 'pg.*', ['where' => array('pg.profile_id' => trim($is_left['id']), 'pg.is_delete' => 0)], ['join' => [array('table' => TBL_PROFILES . ' p', 'condition' => 'p.id=pg.profile_id')], 'order_by' => 'pg.id DESC']);
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
            $posts = $this->load_posts(0, $is_left['id'], true);
            if ($_POST) {
                $data = [];
                $this->form_validation->set_rules('comment', 'comment', 'trim');
                if ($this->form_validation->run() == FALSE) {
                    $this->data['error'] = validation_errors();
                    $data['success'] = false;
                    $data['error'] = 'Post not added.';
                } else {
                    if (isset($_FILES['post_upload']) && !empty($_FILES['post_upload']['name'][0])) {
                        $directory = 'profile_' . $is_left['id'];
                        if (!file_exists(POST_IMAGES . $directory)) {
                            mkdir(POST_IMAGES . $directory);
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
                            if (is_array($image_data)) {
                                $flag = 1;
                                $data['success'] = false;
                                $data['error'] = $image_data['errors'];
                            } else {
                                $image = $image_data;
                                $dataArr_media[] = array(
                                    'media' => $directory . '/' . $image,
                                    'type' => $this->input->post('post_types')[$key],
                                    'created_at' => date('Y-m-d H:i:s'),
                                );
                            }
                        }
                    }
                    $dataArr = array(
                        'profile_id' => $is_left['id'],
                        'user_id' => $is_left['user_id'],
                        'created_at' => date('Y-m-d H:i:s'),
                    );
                    if (!empty(trim($this->input->post('comment')))) {
                        $dataArr['comment'] = trim($this->input->post('comment'));
                    }
                    $id = $this->users_model->common_insert_update('insert', TBL_POSTS, $dataArr);
                    if (isset($dataArr_media) && !empty($dataArr_media)) {
                        foreach ($dataArr_media as $key => $value) {
                            $dataArr_media[$key]['post_id'] = $id;
                        }
                        $this->users_model->batch_insert_update('insert', TBL_POST_MEDIAS, $dataArr_media);
                    }
                    $this->session->set_flashdata('success', 'Post details has been inserted successfully.');
                    $data['success'] = true;
                    $data['data'] = 'Post details has been inserted successfully.';
                }
                echo json_encode($data);
                exit;
            }
            $data['url'] = current_url();
            $data['profile'] = $is_left;
            $data['fun_facts'] = $fun_facts;
            $data['funnel_services'] = $funnel_services_data;
            $data['posts'] = $posts;
            $data['life_gallery'] = $life_gallery;
            $data['title'] = 'Profile';
            $data['breadcrumb'] = ['title' => 'User Profile', 'links' => [['link' => site_url(), 'title' => 'Home']]];
            $this->template->load('default', 'profile/profile_detail', $data);
        }
    }

    /**
     * Display Post on page load and called on scroll event.
     */
    public function load_posts($start, $profile_id ,$static = false) {
        $offset = 5;
        if ($static === false) {
            $profile_id = base64_decode($profile_id);
        }
        $final_post_data = [];
        $posts = $this->users_model->sql_select(TBL_POSTS . ' p', 'p.*,u.firstname,u.lastname,u.profile_image', ['where' => array('p.profile_id' => trim($profile_id), 'p.is_delete' => 0)], ['join' => [array('table' => TBL_USERS . ' u', 'condition' => 'u.id=p.user_id AND u.is_delete=0')], 'order_by' => 'p.id DESC', 'limit' => $offset, 'offset' => $start]);
        if (!empty($posts)) {
            foreach ($posts as $key => $value) {
                $final_post_data[$key] = array('id' => $value['id'],
                    'profile_id' => $value['profile_id'],
                    'user_id' => $value['user_id'],
                    'firstname' => $value['firstname'],
                    'lastname' => $value['lastname'],
                    'profile_image' => $value['profile_image'],
                    'comment' => $value['comment'],
                    'created_at' => $value['created_at'],
                    'updated_at' => $value['updated_at'],
                    'is_delete' => $value['is_delete'],
                );
                $post_media = $this->users_model->sql_select(TBL_POST_MEDIAS . ' p', '*', ['where' => array('p.post_id' => trim($value['id']), 'p.is_delete' => 0)]);
                if (!empty($post_media)) {
                    foreach ($post_media as $k => $val) {
                        $final_post_data[$key]['media'][$val['type']][] = $val['media'];
                    }
                }
            }
        }
        if ($static === true) {
            return $final_post_data;
        } else {
            if (!empty($final_post_data)) {
                echo json_encode($final_post_data);
            } else {
                echo '';
            }
        }
    }

    /**
     * Upload cover image
     * @author AKK
     */
    public function upload_cover_image() {
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
                $image_data = upload_image('cover_image', PROFILE_IMAGES . $directory . '/' . $sub_directory);
                if (is_array($image_data)) {
                    $data['error'] = $image_data['errors'];
                    $data['success'] = false;
                } else {
                    $this->users_model->common_insert_update('update', TBL_PROFILES, ['cover_image' => $directory . '/' . $sub_directory . '/' . $image_data, 'updated_at' => date('Y-m-d H:i:s')], ['id' => $profile_id]);
                    $data['success'] = true;
                    $data['url'] = site_url('uploads/profile-images/' . $directory . '/' . $sub_directory . '/' . $image_data);
                    $data['data'] = 'Background Image uploaded successfully!';
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
            $data['fun_facts'] = $this->users_model->sql_select(TBL_FUN_FACTS, '*', ['where' => ['profile_id' => $is_left['id'], 'is_delete' => 0]]);
            //-- Get profile Affiliations
            $sql = "SELECT * FROM ("
                    . "SELECT id,affiliation_text as name,'1' as free_text,created_at FROM " . TBL_PROFILE_AFFILIATIONTEXTS . " WHERE profile_id=" . $is_left['id'] . "
                       UNION ALL
                       SELECT p.id,a.name,'0' as free_text,p.created_at FROM " . TBL_PROFILE_AFFILIATION . " p JOIN " . TBL_AFFILIATIONS . " a on p.affiliation_id=a.id WHERE p.profile_id=" . $is_left['id'] . " AND a.is_delete=0 
                    ) a order by created_at";
            $data['profile_affiliations'] = $this->users_model->customQuery($sql);
            $data['timeline'] = $this->users_model->sql_select(TBL_LIFE_TIMELINE, '*', ['where' => ['profile_id' => $is_left['id'], 'is_delete' => 0]]);
            $services = $this->users_model->sql_select(TBL_FUNERAL_SERVICES, '*', ['where' => ['profile_id' => $is_left['id'], 'is_delete' => 0]]);
            $data['burial_service'] = $data['funeral_service'] = $data['memorial_service'] = $data['burial_cities'] = $data['funeral_cities'] = $data['memorial_cities'] = [];
            foreach ($services as $service) {
                if ($service['service_type'] == 'Burial') {
                    $data['burial_service'] = $service;
                    $data['burial_cities'] = $this->users_model->sql_select(TBL_CITY, 'id,name', ['where' => ['state_id' => $service['state']]]);
                } elseif ($service['service_type'] == 'Funeral') {
                    $data['funeral_service'] = $service;
                    $data['funeral_cities'] = $this->users_model->sql_select(TBL_CITY, 'id,name', ['where' => ['state_id' => $service['state']]]);
                } elseif ($service['service_type'] == 'Memorial') {
                    $data['memorial_service'] = $service;
                    $data['memorial_cities'] = $this->users_model->sql_select(TBL_CITY, 'id,name', ['where' => ['state_id' => $service['state']]]);
                }
            }
        }
        if ($this->input->post('profile_process')) {
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
        $data['cities'] = [];
        $data['states'] = $this->users_model->sql_select(TBL_STATE, 'id,name', ['where' => ['country_id' => 234]]);
        $data['affiliations'] = $this->users_model->sql_select(TBL_AFFILIATIONS, 'id,name', ['where' => ['is_approved' => 1, 'is_delete' => 0]]);
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

    /**
     * Ajax call to this function Proceed profile steps
     * @author KU
     */
    public function proceed_steps() {
        if ($this->input->post('profile_process')) {
            $profile_id = base64_decode($this->input->post('profile_id'));
            $profile_process = $this->input->post('profile_process');
            //-- Get profile detail from profile_id
            $profile = $this->users_model->sql_select(TBL_PROFILES, 'profile_process', ['where' => ['id' => $profile_id, 'is_delete' => 0]], ['single' => true]);
            if (!empty($profile)) {
                if ($profile['profile_process'] <= $profile_process)
                    $this->users_model->common_insert_update('update', TBL_PROFILES, ['profile_process' => $profile_process], ['id' => $profile_id]);
                $data = ['success' => true];
            } else {
                $data = ['success' => false, 'error' => 'Invalid request!'];
            }
        } else {
            $data = ['success' => false, 'error' => 'Invalid request!'];
        }
        echo json_encode($data);
        exit;
    }

    /**
     * Upload profile gallery
     * @author KU
     */
    public function add_facts() {
        $profile_id = base64_decode($this->input->post('profile_id'));
        $profile = $this->users_model->sql_select(TBL_PROFILES, 'user_id', ['where' => ['id' => $profile_id, 'is_delete' => 0]], ['single' => true]);
        if (!empty($profile)) {
            $id = $this->users_model->common_insert_update('insert', TBL_FUN_FACTS, ['profile_id' => $profile_id, 'user_id' => $this->user_id, 'facts' => trim($this->input->post('facts')), 'created_at' => date('Y-m-d H:i:s')]);
            $data['success'] = true;
            $data['data'] = base64_encode($id);
        } else {
            $data['success'] = false;
            $data['error'] = "Something went wrong!";
        }
        echo json_encode($data);
        exit;
    }

    /**
     * Check fact is already added or not
     * @param type $id
     */
    public function check_facts($id) {
        $facts = trim($this->input->get('fun_fact'));
        $profile_id = base64_decode($id);
        $fact = $this->users_model->sql_select(TBL_FUN_FACTS, 'id', ['where' => ['facts' => $facts, 'profile_id' => $profile_id, 'is_delete' => 0]]);
        if (!empty($fact)) {
            echo "false";
        } else {
            echo "true";
        }
        exit;
    }

    /**
     * Delete fun facts
     * @author KU
     */
    public function delete_facts() {
        $fact = base64_decode($this->input->post('fact'));
        $fact_detail = $this->users_model->sql_select(TBL_FUN_FACTS, 'facts', ['where' => ['id' => $fact, 'is_delete' => 0]], ['single' => true]);
        if (!empty($fact_detail)) {
            $this->users_model->common_insert_update('update', TBL_FUN_FACTS, ['is_delete' => 1], ['id' => $fact]);
            $data['success'] = true;
        } else {
            $data['success'] = false;
            $data['error'] = "Invalid request!";
        }
        echo json_encode($data);
        exit;
    }

    /**
     * Add Affiliation
     * @author KU
     */
    public function add_affiliation() {
        $profile_id = base64_decode($this->input->post('profile_id'));
        $profile = $this->users_model->sql_select(TBL_PROFILES, 'user_id', ['where' => ['id' => $profile_id, 'is_delete' => 0]], ['single' => true]);
        if (!empty($profile)) {
            $id_arr = [];
            if ($this->input->post('select_affiliation') != '') {
                $sql = 'INSERT IGNORE INTO ' . TBL_PROFILE_AFFILIATION . ' (profile_id,affiliation_id,created_at) VALUES (' . $profile_id . ',' . $this->input->post('select_affiliation') . ',\'' . date('Y-m-d H:i:s') . '\')';
                $this->db->query($sql);
                $id = $this->db->insert_id();
                $affiliation = $this->users_model->sql_select(TBL_AFFILIATIONS, 'name', ['where' => ['id' => $this->input->post('select_affiliation')]], ['single' => true]);
                if ($id != 0) {
                    $id_arr[] = ['id' => base64_encode($id), 'type' => 0, 'name' => $affiliation['name']];
                }
            }
            if (trim($this->input->post('affiliation_text')) != '') {
                $sql = 'INSERT IGNORE INTO ' . TBL_PROFILE_AFFILIATIONTEXTS . ' (profile_id,affiliation_text,created_at) VALUES (' . $profile_id . ',\'' . trim($this->input->post('affiliation_text')) . '\',\'' . date('Y-m-d H:i:s') . '\')';
                $this->db->query($sql);
                $id = $this->db->insert_id();
                if ($id != 0) {
                    $id_arr[] = ['id' => base64_encode($id), 'type' => 1, 'name' => trim($this->input->post('affiliation_text'))];
                }
            }
            $sql = "SELECT count(id) as count FROM ("
                    . "SELECT id FROM " . TBL_PROFILE_AFFILIATIONTEXTS . " WHERE profile_id=" . $profile_id . "
                       UNION ALL
                       SELECT p.id FROM " . TBL_PROFILE_AFFILIATION . " p JOIN " . TBL_AFFILIATIONS . " a on p.affiliation_id=a.id WHERE p.profile_id=" . $profile_id . " AND a.is_delete=0 
                    ) a";
            $count = $this->users_model->customQuery($sql, 2);
            $data['success'] = true;
            $data['data'] = $id_arr;
            $data['affiliation_count'] = $count['count'];
        } else {
            $data['success'] = false;
            $data['error'] = "Something went wrong!";
        }
        echo json_encode($data);
        exit;
    }

    /**
     * Check affiliation is already added or not
     * @param type $id
     */
    public function check_affiliation($id) {
        $affiliation_text = trim($this->input->get('affiliation_text'));
        $profile_id = base64_decode($id);
        $affiliation = $this->users_model->sql_select(TBL_PROFILE_AFFILIATIONTEXTS, 'id', ['where' => ['affiliation_text' => $affiliation_text, 'profile_id' => $profile_id]]);
        if (!empty($affiliation)) {
            echo "false";
        } else {
            echo "true";
        }
        exit;
    }

    /**
     * Delete affiliation
     * @author KU
     */
    public function delete_affiliation() {
        $id = base64_decode($this->input->post('affiliation'));
        if ($this->input->post('type') == 1) {
            $this->users_model->common_delete(TBL_PROFILE_AFFILIATIONTEXTS, ['id' => $id]);
        } else {
            $this->users_model->common_delete(TBL_PROFILE_AFFILIATION, ['id' => $id]);
        }

        $data['success'] = true;
        echo json_encode($data);
        exit;
    }

    /**
     * Add life time line
     */
    public function add_timeline() {
        $post_arr = $this->input->post();
        $profile_id = base64_decode($this->input->post('profile_id'));
        $profile = $this->users_model->sql_select(TBL_PROFILES, 'user_id', ['where' => ['id' => $profile_id, 'is_delete' => 0]], ['single' => true]);
        $flag = 0;
        if (!empty($profile)) {
            $life_timeline = [];
            foreach ($post_arr['title'] as $key => $arr) {
                $lif_arr = ['profile_id' => $profile_id];
                $lif_arr['title'] = trim($this->input->post('title')[$key]);
                if ($this->input->post('date')[$key] != '') {
                    $lif_arr['date'] = date('Y-m-d', strtotime($this->input->post('date')[$key]));
                    $lif_arr['month'] = date('n', strtotime($this->input->post('date')[$key]));
                    $lif_arr['year'] = date('Y', strtotime($this->input->post('date')[$key]));
                } elseif ($this->input->post('month')[$key] != '') {
                    $lif_arr['month'] = $this->input->post('month')[$key];
                    $lif_arr['year'] = $this->input->post('month_year')[$key];
                    $lif_arr['date'] = null;
                } elseif ($this->input->post('year')[$key] != '') {
                    $lif_arr['month'] = null;
                    $lif_arr['year'] = $this->input->post('year')[$key];
                    $lif_arr['date'] = null;
                }
                $lif_arr['details'] = $this->input->post('details')[$key];


                if ($_FILES['life_pic']['name'][$key] != '') {

                    $directory = 'user_' . $profile['user_id'];
                    if (!file_exists(PROFILE_IMAGES . $directory)) {
                        mkdir(PROFILE_IMAGES . $directory);
                    }
                    $sub_directory = 'profile_' . $profile_id;
                    if (!file_exists(PROFILE_IMAGES . $directory . '/' . $sub_directory)) {
                        mkdir(PROFILE_IMAGES . $directory . '/' . $sub_directory);
                    }

                    $extension = explode('/', $_FILES['life_pic']['type'][$key]);
                    $extension = end($extension);
                    // check file extension image/video
                    if (in_array($extension, ['jpg', 'jpeg', 'png', 'bmp', 'gif'])) {
                        $_FILES['life_image']['name'] = $_FILES['life_pic']['name'][$key];
                        $_FILES['life_image']['type'] = $_FILES['life_pic']['type'][$key];
                        $_FILES['life_image']['tmp_name'] = $_FILES['life_pic']['tmp_name'][$key];
                        $_FILES['life_image']['error'] = $_FILES['life_pic']['error'][$key];
                        $_FILES['life_image']['size'] = $_FILES['life_pic']['size'][$key];
                        $image_data = upload_image('life_image', PROFILE_IMAGES . $directory . '/' . $sub_directory);
                        if (is_array($image_data)) {
                            $flag = 1;
                            $data['success'] = false;
                            $data['error'] = $image_data['errors'];
                            break;
                        } else {
                            $lif_arr['timeline_media'] = $directory . '/' . $sub_directory . '/' . $image_data;
                        }
                    } elseif ($extension == 'mp4') {
                        $_FILES['life_video']['name'] = $_FILES['life_pic']['name'][$key];
                        $_FILES['life_video']['type'] = $_FILES['life_pic']['type'][$key];
                        $_FILES['life_video']['tmp_name'] = $_FILES['life_pic']['tmp_name'][$key];
                        $_FILES['life_video']['error'] = $_FILES['life_pic']['error'][$key];
                        $_FILES['life_video']['size'] = $_FILES['life_pic']['size'][$key];
                        $video_data = upload_video('life_video', PROFILE_IMAGES . $directory . '/' . $sub_directory);
                        if (is_array($video_data)) {
                            $flag = 1;
                            $data['success'] = false;
                            $data['error'] = $video_data['errors'];
                            break;
                        } else {
                            $lif_arr['timeline_media'] = $directory . '/' . $sub_directory . '/' . $video_data;
                        }
                    } else {
                        $flag = 1;
                        $data['success'] = false;
                        $data['error'] = 'You have not uploaded valid image/upload';
                        break;
                    }
                }
                $life_timeline[] = $lif_arr;
            }
            if ($flag == 0) {
                foreach ($life_timeline as $key => $arr) {
                    if (isset($this->input->post('timelineid')[$key])) {
                        $arr['updated_at'] = date('Y-m-d H:i:s');
                        $this->users_model->common_insert_update('update', TBL_LIFE_TIMELINE, $arr, ['id' => base64_decode($this->input->post('timelineid')[$key])]);
                    } else {
                        $arr['created_at'] = date('Y-m-d H:i:s');
                        $this->users_model->common_insert_update('insert', TBL_LIFE_TIMELINE, $arr);
                    }
                }
//                $this->users_model->batch_insert_update('insert', TBL_LIFE_TIMELINE, $life_timeline);
                $this->users_model->common_insert_update('update', TBL_PROFILES, ['profile_process' => 4], ['id' => $profile_id]);

                $data['success'] = true;
            }
        }
        echo json_encode($data);
        exit;
    }

    public function delete_timeline() {
        $id = base64_decode($this->input->post('id'));
        if (!empty($id)) {
            $this->users_model->common_insert_update('update', TBL_LIFE_TIMELINE, ['is_delete' => 1], ['id' => $id]);
            $data['success'] = true;
        } else {
            $data['success'] = false;
            $data['error'] = 'Something went wrong';
        }

        echo json_encode($data);
        exit;
    }

    /**
     * Get life time-line of particular profile
     */
    public function lifetimeline() {
        $id = base64_decode($this->input->post('profile_id'));
        $timeline = $this->users_model->sql_select(TBL_LIFE_TIMELINE, '*', ['where' => ['profile_id' => $id, 'is_delete' => 0]]);
        if (!empty($timeline)) {
            $timeline_count = count($timeline) - 1;
            $str = '';
            foreach ($timeline as $key => $value) {
                $str .= '<input type="hidden" name="timelineid[]" value="' . base64_encode($value['id']) . '"/>
                        <div class="step-06">
                            <div class="step-06-l">
                                <div class="input-wrap">
                                    <label class="label-css">Title</label>
                                    <input type="text" name="title[]" placeholder="Title" class="input-css" value="' . $value['title'] . '">
                                </div>
                                <div class="input-wrap four-input">
                                    <input type="text" name="date[]" placeholder="Date" class="input-css date-picker" value="' . date('m/d/Y', strtotime($value['date'])) . '"> <span>Or</span>
                                    <input type="number" name="month[]" placeholder="Month" class="input-css" value="' . $value['month'] . '">
                                    <input type="number" name="month_year[]" placeholder="Year" class="input-css" value="' . $value['year'] . '"><span>Or</span>
                                    <input type="number" name="year[]" placeholder="Year" class="input-css" value="' . $value['year'] . '">
                                    <p>You may enter a Year a, Month/Year, or a full date.</p>
                                </div>
                                <div class="input-wrap">
                                    <textarea class="input-css textarea-css" name="details[]" placeholder="Details(optional)">' . $value['details'] . '</textarea>
                                </div>';
                if ($key == $timeline_count) {
                    $str .= '<a class="add_timeline_btn label-css"><i class="fa fa-plus"></i> Add another life timeline entry.</a>';
                } else {
                    $str .= '<a class="remove_org_timeline_btn text-danger mb-20 label-css" data-id="' . base64_encode($value['id']) . '"><i class="fa fa-trash"></i> Remove</a>';
                }
                $str .= '</div>
                        <div class="step-06-r">
                            <div class="select-file">
                                <div class="select-file-upload"> 
                                    <span class="select-file_up_btn">';

                if ($value['timeline_media'] != '') {
                    if ($value['media_type'] == 1) {
                        $str .= '<img src="' . PROFILE_IMAGES . $value['timeline_media'] . '" style="width: 170px; border-radius: 2px;" alt="">';
                    } else if ($value['media_type'] == 2) {

                        $str .= '<video style="width:100%;" controls><source src="' . $value['timeline_media'] . '">Your browser does not support HTML5 video.</video>';
                    }
                } else {
                    $str .= 'Upload Picture or Video? <span>Select</span>';
                }
                $str .= '</span>
                                <input type="file" name="life_pic[]" multiple="false" class="timeline-media"> 
                            </div>
                        </div>
                    </div>
                </div>';
            }
        } else {
            $str .= '<div class="step-06">
                        <div class="step-06-l">
                            <div class="input-wrap">
                                <label class="label-css">Title</label>
                                <input type="text" name="title[]" placeholder="Title" class="input-css">
                            </div>
                            <div class="input-wrap four-input">
                                <input type="text" name="date[]" placeholder="Date" class="input-css date-picker"> <span>Or</span>
                                <input type="number" name="month[]" placeholder="Month" class="input-css">
                                <input type="number" name="month_year[]" placeholder="Year" class="input-css"><span>Or</span>
                                <input type="number" name="year[]" placeholder="Year" class="input-css">
                                <p>You may enter a Year a, Month/Year, or a full date.</p>
                            </div>
                            <div class="input-wrap">
                                <textarea class="input-css textarea-css" name="details[]" placeholder="Details(optional)"></textarea>
                            </div>
                            <a class="add_timeline_btn label-css"><i class="fa fa-plus"></i> Add another life timeline entry.</a>
                        </div>
                        <div class="step-06-r">
                            <div class="select-file">
                                <div class="select-file-upload"> 
                                    <span class="select-file_up_btn">Upload Picture or Video? <span>Select</span></span>
                                    <input type="file" name="life_pic[]" multiple="false" class="timeline-media"> 
                                </div>
                            </div>
                        </div>
                    </div>';
        }
        echo $str;
        exit;
    }

    /**
     * Upload profile post
     * @author AKK
     */
    public function upload_post() {
        $data = [];
        if ($_FILES) {
            $profile_id = base64_decode($this->input->post('profile_id'));
            $post_id = base64_decode($this->input->post('post_id'));
            if ($this->input->post('post_id') == '0') {
                $post_insert_data = ['profile_id' => $profile_id,
                    'user_id' => $this->user_id,
                    'created_at' => date('Y-m-d H:i:s')];
                $post_id = $this->users_model->common_insert_update('insert', TBL_POSTS, $post_insert_data);
            }
            $post = $this->users_model->sql_select(TBL_POSTS, '*', ['where' => ['id' => $post_id, 'is_delete' => 0]], ['single' => true]);
            if (!empty($post)) {
                $directory = 'profile_' . $profile_id;
                if (!file_exists(POST_IMAGES . $directory)) {
                    mkdir(POST_IMAGES . $directory);
                }
                if ($this->input->post('type') == 'image') {
                    $image_data = upload_image('post_upload', POST_IMAGES . $directory);
                    if (is_array($image_data)) {
                        $data['error'] = $image_data['errors'];
                        $data['success'] = false;
                    } else {
                        $id = $this->users_model->common_insert_update('insert', TBL_POST_MEDIAS, ['post_id' => $post_id, 'media' => $directory . '/' . $image_data, 'type' => 1, 'created_at' => date('Y-m-d H:i:s')]);
                        $data['success'] = true;
                        $data['data'] = json_encode(array('id' => base64_encode($id), 'post_id' => base64_encode($post['id'])));
                    }
                } elseif ($this->input->post('type') == 'video') {
                    $video_data = upload_video('post_upload', POST_IMAGES . $directory);
                    if (is_array($video_data)) {
                        $data['error'] = $video_data['errors'];
                        $data['success'] = false;
                    } else {
                        $id = $this->users_model->common_insert_update('insert', TBL_POST_MEDIAS, ['post_id' => $post_id, 'media' => $directory . '/' . $video_data, 'type' => 2, 'created_at' => date('Y-m-d H:i:s')]);
                        $data['success'] = true;
                        $data['data'] = json_encode(array('id' => base64_encode($id), 'post_id' => base64_encode($post['id'])));
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
        p($data);
        echo json_encode($data);
        exit;
    }

    /**
     * Delete uploaded profile post 
     * @author AKK
     */
    public function delete_post() {
        $gallery = base64_decode($this->input->post('post'));
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
