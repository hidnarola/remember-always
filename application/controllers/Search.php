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
     * Display Blog listing
     */
    public function indexq($start = 0) {
        $blog_list = $this->blogs_model->sql_select(TBL_BLOG_POST, '*', ['where' => ['is_delete' => 0, 'is_active' => 1]], ['order_by' => 'id DESC', 'limit' => 10]);
        $data['blog_list'] = $blog_list;

        $page_config = front_pagination();
        $page_config['per_page'] = 4;
        $page_config['base_url'] = site_url('blog');
        $page_config["total_rows"] = $this->load_blogs('count', 0);
        $data['blogs'] = $this->load_blogs('result', $start);
        $this->pagination->initialize($page_config);

        $data['title'] = 'All Blogs';
        $data['breadcrumb'] = ['title' => 'Blogs', 'links' => [['link' => site_url(), 'title' => 'Home']]];
        $this->template->load('default', 'blog_post/index', $data);
    }

    /**
     * Display search result page
     */
    public function index($start = 0) {
        $page_config = front_pagination();
        $page_config['per_page'] = 12;
        $page_config['base_url'] = site_url('search');
        $offset = 12;
        $page_config['total_rows'] = $this->search_model->get_results('count', $start, $offset);
        $data['results'] = $this->search_model->get_results('result', $start, $offset);
        $this->pagination->initialize($page_config);

        $data['links'] = $this->pagination->create_links();
        $data['title'] = 'Remember Always | Profiles';
        $data['breadcrumb'] = ['title' => 'Find Life Profile', 'links' => [['link' => site_url(), 'title' => 'Home']]];
        $this->template->load('default', 'search/listing', $data);
    }

}
