<?php

/**
 * Search Controller
 * Display search results
 * @author KU 
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Search extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('search_model');
    }

    /**
     * Display search result page
     */
    public function index($start = 0) {
        $page_config = front_pagination();
        $page_config['per_page'] = 12;
        $page_config['base_url'] = site_url('search');
        if ($this->input->get('type') != '') {
            $page_config['suffix'] = '?type=' . $this->input->get('type') . '&keyword=' . $this->input->get('keyword') . '&location=' . $this->input->get('location');
            $page_config['first_url'] = site_url('search') . '?type=' . $this->input->get('type') . '&keyword=' . $this->input->get('keyword') . '&location=' . $this->input->get('location');
        }
        $offset = 12;
        $page_config['total_rows'] = $this->search_model->get_results('count', $start, $offset);
        $data['results'] = $this->search_model->get_results('result', $start, $offset);
        $this->pagination->initialize($page_config);

        $data['links'] = $this->pagination->create_links();
        $data['title'] = 'Remember Always | Profiles';
        $data['breadcrumb'] = ['title' => 'Find Life Profile', 'links' => [['link' => site_url(), 'title' => 'Home']]];
        $this->template->load('default', 'search/listing', $data);
    }

    /**
     * Displays search result for auto complete
     */
    public function autocomplete() {
        $query = $this->input->get_post('query');
        $result = $this->search_model->find($query);
        echo json_encode($result);
        exit;
    }

    /**
     * Displays search result for auto complete
     */
    public function get_result() {
        $search_txt = trim($this->input->get_post('search_text'));

        if ($search_txt != '') {
            //if user search for profile then
            $data = $this->search_model->get_all_details(TBL_PROFILES, 'CONCAT(firstname," ",lastname)="' . $search_txt . '" AND is_published = 1 AND is_delete = 0')->row_array();
            if (count($data) > 0) {
                echo json_encode(array('slug' => $data['slug'], 'type' => 'profile'));
            } else {
                $where = ['where' => ['name' => $search_txt, 'is_delete' => 0]];
                $option = ['single' => true];

                //--- If user searches for service provider name
                $data = $this->search_model->sql_select(TBL_SERVICE_PROVIDERS, 'slug', $where, $option);
                if (count($data) > 0) {
                    echo json_encode(array('slug' => $data['slug'], 'type' => 'service_provider'));
                } else {
                    //--- if user search direct affiliation name
                    $data = $this->search_model->sql_select(TBL_AFFILIATIONS, 'slug', $where, $option);
                    if (count($data) > 0) {
                        echo json_encode(array('slug' => $data['slug'], 'type' => 'affiliation'));
                    } else {
                        //--- if user search for blog post
                        $data = $this->search_model->sql_select(TBL_BLOG_POST, 'slug', ['where' => ['title' => $search_txt]], $option);
                        if (count($data) > 0) {
                            echo json_encode(array('slug' => $data['slug'], 'type' => 'blog'));
                        } else {
                            echo json_encode(array('type' => ''));
                        }
                    }
                }
            }
        } else {
            echo json_encode(array('type' => ''));
        }
        exit;
    }

}
