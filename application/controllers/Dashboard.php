<?php

/**
 * Dashboard controller for Administrator dashboard
 * @author KU 
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Display dashboard page
     */
    public function index($slug = '') {
        if (!$this->is_user_loggedin) {
            $this->session->set_flashdata('error', 'You must login to access this page');
            redirect('/');
        }
        if ($slug == '') {
            $profiles = $this->users_model->sql_select(TBL_PROFILES, '*', ['where' => ['is_delete' => 0, 'user_id' => $this->user_id]]);
            $data['profiles'] = $profiles;
            $data['slug'] = '';
        } else if ($slug == 'affiliations') {
            $affiliations = $this->users_model->sql_select(TBL_AFFILIATIONS . ' a', 'a.*,ac.name as category_name', ['where' => ['a.is_delete' => 0, 'a.user_id' => $this->user_id]], ['join' => [array('table' => TBL_AFFILIATIONS_CATEGORY . ' ac', 'condition' => 'ac.id=a.category_id AND ac.is_delete=0')]]);
            $data['affiliations'] = $affiliations;
            $data['slug'] = 'affiliations';
        } else if ($slug == 'profiles') {
            $profiles = $this->users_model->sql_select(TBL_PROFILES, '*', ['where' => ['is_delete' => 0, 'user_id' => $this->user_id]]);
            $data['profiles'] = $profiles;
            $data['slug'] = 'profiles';
        }
        $data['title'] = 'Dashboard';
        $this->template->load('default', 'dashboard', $data);
    }

    /**
     * This function is used to publish user's profile.
     */
    public function profile_publish($slug) {
        $data = [];
        if (!empty($slug)) {
            $is_left = $this->users_model->sql_select(TBL_PROFILES, '*', ['where' => ['is_delete' => 0, 'slug' => $slug]], ['single' => true]);
            if (!empty($is_left)) {
                $this->users_model->common_insert_update('update', TBL_PROFILES, ['is_published' => 1, 'updated_at' => date('Y-m-d H:i:s')], ['id' => $is_left['id']]);
                $this->session->set_flashdata('success', 'Profile has been published successfully!');
                $data['success'] = true;
                $data['data'] = 'Profile has been published successfully!';
            } else {
                $this->session->set_flashdata('error', 'Invalid request profile not found.');
                $data['success'] = false;
                $data['error'] = 'Invalid request profile not found.';
            }
        } else {
            $this->session->set_flashdata('error', 'Invalid request. Please try again!');
            $data['success'] = false;
            $data['error'] = 'Invalid request. Please try again!';
        }
        echo json_encode($data);
    }

    /**
     * Actions for user profiles
     * @param int $id
     * */
    public function profile_action($action, $slug = NULL) {
        $data = [];
        if (!empty($slug) && !empty($action)) {
            $profile_data = $this->users_model->sql_select(TBL_PROFILES, null, ['where' => array('slug' => trim($slug), 'is_delete' => 0)], ['single' => true]);
            if (!empty($profile_data)) {
                if ($action == 'delete') {
                    $update_array = array(
                        'is_delete' => 1,
                        'updated_at' => date('Y-m-d H:i:s'),
                    );
                }
                $this->users_model->common_insert_update('update', TBL_PROFILES, $update_array, ['id' => $profile_data['id']]);
                $this->session->set_flashdata('success', 'Profile has been deleted successfully!');
                $data['success'] = true;
                $data['data'] = 'Profile has been deleted successfully!';
            } else {
                $this->session->set_flashdata('error', 'Invalid request profile not found!');
                $data['success'] = false;
                $data['error'] = 'Invalid request profile not found.';
            }
        } else {
            $this->session->set_flashdata('error', 'Invalid request. Please try again!');
            $data['success'] = false;
            $data['error'] = 'Invalid request. Please try again!';
        }
        echo json_encode($data);
    }

}
