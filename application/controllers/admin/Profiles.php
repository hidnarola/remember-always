<?php

/**
 * Profiles controller to manage profile related things
 * @author KU 
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Profiles extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('admin/profile_model');
    }

    /**
     * Display listing of profiles
     */
    public function index() {
        $data['title'] = 'Remember Always Admin | Profiles';
        $this->template->load('admin', 'admin/all_profiles/index', $data);
    }

    /**
     * Get all profiles data for AJAX table
     * */
    public function get_profiles() {
        $final['recordsFiltered'] = $final['recordsTotal'] = $this->profile_model->get_profiles('count');
        $final['redraw'] = 1;
        $profiles = $this->profile_model->get_profiles('result');
        $start = $this->input->get('start') + 1;
        foreach ($profiles as $key => $val) {
            $profiles[$key] = $val;
            $profiles[$key]['sr_no'] = $start;
            if (strlen($val['life_bio']) > 100) {
                $profiles[$key]['life_bio'] = substr($val['life_bio'], 0, 100) . '...';
            }
            $profiles[$key]['created_at'] = date('d M Y', strtotime($val['created_at']));
            $start++;
        }

        $final['data'] = $profiles;
        echo json_encode($final);
    }

    /**
     * Change most visited and notable status of profile
     * */
    public function change_data_status() {
        $profile_status_type = $this->input->get('type');
        $profile_id = $this->input->get('id');
        $check_profile = $this->profile_model->sql_select(TBL_PROFILES, 'id', ['where' => ['id' => $profile_id]], ['single' => true]);
        if (!empty($check_profile)) {
            $val = $this->input->get('value');
            if ($profile_status_type == 'most_visited') {
                $update_array = array(
                    'most_visited' => $val
                );
            } elseif ($profile_status_type == 'notable') {
                $update_array = array(
                    'notable' => $val,
                );
            } else {
                echo 'fail';
                exit;
            }
            $this->profile_model->common_insert_update('update', TBL_PROFILES, $update_array, ['id' => $profile_id]);
            echo 'success';
        } else {
            echo 'fail';
        }
        exit;
    }

}
