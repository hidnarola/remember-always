<?php

/**
 * Questions Controller
 * Display search results
 * @author KU 
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Questions extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('community_model');
    }

    /**
     * Display all questions pages.
     */
    public function index() {
//        $data['title'] = 'Remember Always | Community';
//        $data['breadcrumb'] = ['title' => 'List of all questions', 'links' => [['link' => site_url(), 'title' => 'Home']]];
//        $this->template->load('default', 'community/questions', $data);
    }

    /**
     * Display question details pages.
     */
    public function view($slug = null) {
        if ($slug != null) {
            $data['url'] = current_url();
            $question_data = $this->community_model->sql_select(TBL_QUESTIONS . ' q', 'q.*,u.firstname,u.lastname,u.profile_image,u.facebook_id,u.google_id', ['where' => array('slug' => trim($slug), 'q.is_delete' => 0)], ['join' => [array('table' => TBL_USERS . ' u', 'condition' => 'u.id=q.user_id AND u.is_delete=0')], 'single' => true]);
            if (!empty($question_data)) {
                $data['question'] = $question_data;
            } else {
                custom_show_404();
            }
            $data['title'] = 'Remember Always | Community';
            $data['breadcrumb'] = ['title' => 'Question Details', 'links' => [['link' => site_url(), 'title' => 'Home'],['link' => site_url('questions'), 'title' => 'Questions']]];
            $this->template->load('default', 'community/questions', $data);
        } else {
            custom_show_404();
        }
    }

    /**
     * It is used to add new answer of particular question.
     */
    public function add_answers() {
        $slug = $this->input->post('slug');
        $data = [];
        if ($slug != null) {
            $question_data = $this->community_model->sql_select(TBL_QUESTIONS . ' q', null, ['where' => array('slug' => trim($slug), 'q.is_delete' => 0)], ['single' => true]);
            if (!empty($question_data)) {

                $dataArr = array('description' => $this->input->post('description'),
                    'user_id' => $this->user_id,
                    'question_id' => $question_data['id'],
                    'created_at' => date('Y-m-d H:i:s'));
                $id = $this->community_model->common_insert_update('insert', TBL_ANSWERS, $dataArr);
                $this->session->set_flashdata('success', 'Answer has been added successfully.');
                $data['success'] = true;
            } else {
                $data['success'] = false;
                $data['error'] = 'something wnet wrong pelase try again!';
            }
        } else {
            $data['success'] = false;
            $data['error'] = 'something wnet wrong pelase try again!';
        }

        echo json_encode($data);
        exit;
    }

}
