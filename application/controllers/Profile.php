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
        $data['title'] = 'User Profile';
        $this->load->view('coming_soon', $data);
    }

    /**
     * Create Profile Page
     */
    public function create() {
        if (!$this->is_user_loggedin) {
            $this->session->set_flashdata('error', 'You must login to access this page');
            redirect('/');
        }
        $this->form_validation->set_rules('profile_image', 'Profile Image', 'trim|required');
        $this->form_validation->set_rules('firstname', 'Firstname', 'trim|required');
        $this->form_validation->set_rules('lastname', 'Lastname', 'trim|required');
        $this->form_validation->set_rules('date_of_birth', 'Date of Birth', 'trim|required');
        $this->form_validation->set_rules('date_of_death', 'Date of Death', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $data['error'] = validation_errors();
        } else {
            $profile_image = '';
            $slug = trim($this->input->post('firstname')) . '-' . trim($this->input->post('lastname'));
            $slug = slug($slug, TBL_PROFILES);
            $data = array(
                'user_id' => $this->session->userdata('remalways_user')['id'],
                'firstname' => trim($this->input->post('firstname')),
                'lastname' => trim($this->input->post('lastname')),
                'nickname' => trim($this->input->post('nickname')),
                'slug' => $slug,
                'profile_image' => $profile_image,
                'life_bio' => trim($this->input->post('life_bio')),
                'date_of_birth' => date('Y-m-d H:i:s', strtotime($this->input->post('date_of_birth'))),
                'date_of_death' => date('Y-m-d H:i:s', strtotime($this->input->post('date_of_death'))),
                'created_at' => date('Y-m-d H:i:s')
            );
            $this->users_model->common_insert_update('insert', TBL_PROFILES, $data);

            $this->session->set_flashdata('success', 'Profile Created successfully!');
            redirect('profile/' . $slug);
        }
        $data['breadcrumb'] = ['title' => 'Create a Life Profile', 'links' => [['link' => site_url(), 'title' => 'Home']]];
        $data['title'] = 'Remember Always | Create Profile';
        $this->template->load('default', 'profile/profile_form', $data);
    }

}
