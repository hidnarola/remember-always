<?php

/**
 * Community Controller
 * Manage Online Community
 * @author KU 
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Community extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('community_model');
    }

    /**
     * Listing of all question with pagination for online community
     * @param int $start
     */
    public function index($start = 0) {
        $page_config = front_pagination();
        $page_config['per_page'] = 5;
        $page_config['base_url'] = site_url('community');
        if ($this->input->get('keyword') != '') {
            $page_config['suffix'] = '?keyword=' . $this->input->get('keyword');
            $page_config['first_url'] = site_url('community') . '?keyword=' . $this->input->get('keyword');
        }
        $offset = 5;
        $page_config['total_rows'] = $this->community_model->get_results('count');
        $data['questions'] = $this->community_model->get_results('result', $start, $offset);
        $this->pagination->initialize($page_config);

        $data['links'] = $this->pagination->create_links();

        $data['title'] = 'Remember Always | Community';
        $data['breadcrumb'] = ['title' => 'Online Community', 'links' => [['link' => site_url(), 'title' => 'Home']]];
        $this->template->load('default', 'community/listing', $data);
    }

    /**
     * Post question functionality
     * @author KU
     */
    public function post_question() {
        //-- check user is logged in or not
        if ($this->is_user_loggedin) {
            if ($this->input->post('question_slug') != '') {
                $select = '(SELECT count(id) FROM ' . TBL_ANSWERS . ' WHERE question_id=q.id AND is_delete=0) answers';
                $question = $this->community_model->sql_select(TBL_QUESTIONS . ' q', 'q.id,q.title,' . $select, ['where' => array('q.slug' => trim($this->input->post('question_slug')), 'q.is_delete' => 0, 'q.user_id' => $this->user_id)], ['single' => true]);
                if (!empty($question)) {
                    if (trim($this->input->post('que_title')) != $question['title']) {
                        $this->form_validation->set_rules('que_title', 'Title', 'trim|required|min_length[5]|callback_title_validation');
                    } else {
                        $this->form_validation->set_rules('que_title', 'Title', 'trim|required|min_length[5]');
                    }
                }
            } else {
                $this->form_validation->set_rules('que_title', 'Title', 'trim|required|min_length[5]|callback_title_validation');
            }
            $this->form_validation->set_rules('que_description', 'Description', 'trim|required|min_length[10]');
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('error', validation_errors());
            } else {

                $data = [
                    'user_id' => $this->user_id,
                    'title' => trim($this->input->post('que_title')),
                    'description' => trim($this->input->post('que_description')),
                ];

                if ($this->input->post('question_slug') != '') {
                    if (!empty($question) && $question['answers'] == 0) {
                        $data['updated_at'] = date('Y-m-d H:i:s');
                        $data['slug'] = slug(trim($this->input->post('que_title')), TBL_QUESTIONS, $question['id']);
                        $id = $this->community_model->common_insert_update('update', TBL_QUESTIONS, $data, ['id' => $question['id']]);
                        $this->session->set_flashdata('success', 'Your question updated successfully!');
                    } else {
                        $this->session->set_flashdata('error', 'Something went worng! Please try again later.');
                    }
                } else {
                    $data['created_at'] = date('Y-m-d H:i:s');
                    $data['slug'] = slug(trim($this->input->post('que_title')), TBL_QUESTIONS);
                    $id = $this->community_model->common_insert_update('insert', TBL_QUESTIONS, $data);
                    $this->session->set_flashdata('success', 'Your question posted successfully!');
                }
            }
            redirect('community');
        } else {
            custom_show_404();
        }
    }

    /**
     * Callback Validate function to validate uniqueness of question title
     * @return boolean
     */
    public function title_validation() {
        $question = $this->community_model->sql_select(TBL_QUESTIONS, 'id', ['where' => array('title' => trim($this->input->post('que_title')), 'is_delete' => 0)], ['single' => true]);
        if (!empty($question)) {
            $this->form_validation->set_message('title_validation', 'Question already exist!');
            return false;
        } else {
            return true;
        }
    }

    /**
     * Check question already exist or not
     * @param string $slug
     */
    public function check_question($slug = null) {
        $title = trim($this->input->get('que_title'));
        $where = ['title' => $title, 'is_delete' => 0];
        if (!is_null($slug)) {
            $where = ['title' => $title, 'is_delete' => 0, 'slug!=' => $slug];
        }
        $question = $this->users_model->sql_select(TBL_QUESTIONS, 'id', ['where' => $where], ['single' => true]);
        if (!empty($question)) {
            echo "false";
        } else {
            echo "true";
        }
        exit;
    }

    /**
     * Ajax call to this function get question detail to edit particular question
     * @author KU
     */
    public function get_question() {
        $slug = $this->input->post('slug');
        $question_data = $this->community_model->sql_select(TBL_QUESTIONS, 'title,slug,description', ['where' => array('slug' => trim($slug), 'is_delete' => 0, 'user_id' => $this->user_id)], ['single' => true]);
        if (!empty($question_data)) {
            $data['question'] = $question_data;
            $data['success'] = true;
        } else {
            $data['success'] = false;
            $data['error'] = 'something went wrong pelase try again!';
        }
        echo json_encode($data);
        exit;
    }

    /**
     * Delete uploaded question
     * @param string $slug
     */
    public function delete_question($slug = null) {
        if (!is_null($slug)) {
            $question = $this->community_model->sql_select(TBL_QUESTIONS, 'id', ['where' => array('slug' => trim($slug), 'is_delete' => 0, 'user_id' => $this->user_id)], ['single' => true]);
            if (!empty($question)) {
                $this->community_model->common_insert_update('update', TBL_QUESTIONS, ['is_delete' => 1], ['id' => $question['id']]);
                $this->session->set_flashdata('success', 'Your question deleted successfully!');
                redirect('community');
            } else {
                custom_show_404();
            }
        } else {
            custom_show_404();
        }
    }

    /**
     * Display question details pages.
     */
    public function view($slug = null) {
        if ($slug != null) {
            $data['url'] = current_url();
            $select = '(SELECT count(id) FROM ' . TBL_ANSWERS . ' WHERE question_id=q.id AND is_delete=0) answers';
            $question_data = $this->community_model->sql_select(TBL_QUESTIONS . ' q', 'q.*,u.firstname,u.lastname,u.profile_image,u.facebook_id,u.google_id,' . $select, ['where' => array('slug' => trim($slug), 'q.is_delete' => 0)], ['join' => [array('table' => TBL_USERS . ' u', 'condition' => 'u.id=q.user_id AND u.is_delete=0')], 'single' => true]);
            if (!empty($question_data)) {
                $data['question'] = $question_data;
                $data['recent_questions'] = $this->community_model->sql_select(TBL_QUESTIONS . ' q', 'q.title,q.slug,u.firstname,u.lastname', ['where' => array('q.slug!=' => trim($slug), 'q.is_delete' => 0)], ['join' => [array('table' => TBL_USERS . ' u', 'condition' => 'u.id=q.user_id')], 'order_by' => 'q.created_at DESC', 'limit' => 5]);
                $comment = '(SELECT count(id) FROM ' . TBL_COMMENTS . ' WHERE answer_id=a.id AND is_delete=0) comments';
                $data['answers'] = $answers = $this->community_model->sql_select(TBL_ANSWERS . ' a', 'a.answer,a.created_at,a.id,u.firstname,u.lastname,u.profile_image,u.facebook_id,u.google_id,' . $comment, ['where' => array('a.question_id' => $question_data['id'], 'a.is_delete' => 0)], ['join' => [array('table' => TBL_USERS . ' u', 'condition' => 'u.id=a.user_id')]]);
                /*
                  $comments = [];
                  if (!empty($answers)) {
                  $ids = array_column($answers, 'id');
                  $comments = $this->community_model->sql_select(TBL_COMMENTS . ' c', 'c.comment,c.created_at,c.answer_id', ['where' => array('c.is_delete' => 0), 'where_in' => array('c.answer_id' => $ids)], ['join' => [array('table' => TBL_ANSWERS . ' a', 'condition' => 'c.answer_id=a.id')]]);
                  $answers_arr = [];
                  foreach ($answers as $key => $answer) {
                  $answers_arr[$key] = $answer;
                  $comment_arr = [];
                  foreach ($comments as $comment) {
                  if ($comment['answer_id'] == $answer['id']) {
                  $comment_arr[] = $comment;
                  }
                  }
                  $answers_arr[$key]['comments'] = $comment_arr;
                  }
                  }
                 */
            } else {
                custom_show_404();
            }
            $data['title'] = 'Remember Always | Community';
            $data['breadcrumb'] = ['title' => 'Question Details', 'links' => [['link' => site_url(), 'title' => 'Home'], ['link' => site_url('community'), 'title' => 'Questions']]];
            $this->template->load('default', 'community/question', $data);
        } else {
            custom_show_404();
        }
    }

    /**
     * It is used to add new answer of particular question.
     * @author AKK
     */
    public function add_answers() {
        $slug = $this->input->post('slug');
        $data = [];
        if ($slug != null) {
            $question_data = $this->community_model->sql_select(TBL_QUESTIONS . ' q', 'id,slug', ['where' => array('slug' => trim($slug), 'q.is_delete' => 0)], ['single' => true]);
            if (!empty($question_data)) {
                $dataArr = array(
                    'user_id' => $this->user_id,
                    'question_id' => $question_data['id'],
                    'answer' => $this->input->post('description'),
                    'created_at' => date('Y-m-d H:i:s'));
                $id = $this->community_model->common_insert_update('insert', TBL_ANSWERS, $dataArr);
                $this->session->set_flashdata('success', 'Answer has been added successfully.');
            } else {
                $this->session->set_flashdata('error', 'Something went wrong pelase try again!');
            }
        } else {
            $this->session->set_flashdata('error', 'Something went wrong pelase try again!');
        }
        redirect('community/view/' . $question_data['slug']);
    }

    /**
     * Ajax call to this function get comments given to answer
     * @author KU
     */
    public function get_comments() {
        $id = $this->input->post('answer');
        $answer = $this->community_model->sql_select(TBL_ANSWERS, 'id,answer,created_at', ['where' => array('id' => $id, 'is_delete' => 0)], ['single' => true]);
        if (!empty($answer)) {
            $comments = $answer = $this->community_model->sql_select(TBL_COMMENTS . ' c', 'c.comment,c.created_at,u.firstname,u.lastname,u.profile_image,u.facebook_id,u.google_id', ['where' => array('c.answer_id' => $id, 'c.is_delete' => 0)], ['join' => [array('table' => TBL_USERS . ' u', 'condition' => 'u.id=c.user_id')], 'order_by' => 'c.created_at DESC']);
            $data['comments'] = $comments;
            $data['answer'] = $answer;
            $data['success'] = true;
        } else {
            $data['success'] = false;
            $data['error'] = 'something went wrong pelase try again!';
        }
        echo json_encode($data);
        exit;
    }

    /**
     * Post comment functionality
     * @author KU
     */
    public function post_comment() {
        //-- check user is logged in or not
        if ($this->is_user_loggedin) {
            if ($this->input->post('comment') != '' && $this->input->post('answer') != '') {
                $answer = $this->community_model->sql_select(TBL_ANSWERS, 'id', ['where' => array('id' => $this->input->post('answer'), 'is_delete' => 0)], ['single' => true]);
                if (!empty($answer)) {
                    $data = [
                        'user_id' => $this->user_id,
                        'comment' => trim($this->input->post('comment')),
                        'answer_id' => $answer,
                        'created_at' => date('Y-m-d H:i:s')
                    ];
                    $id = $this->community_model->common_insert_update('insert', TBL_COMMENTS, $data);
                    $data['success'] = true;
                } else {
                    $data['success'] = false;
                    $data['error'] = 'Something went wrong. Please try again later.';
                }
            } else {
                $data['success'] = false;
                $data['error'] = 'Missing Parameter';
            }
        } else {
            $data['success'] = false;
            $data['error'] = 'Please login to post a comment!';
        }
    }

}
