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

}
