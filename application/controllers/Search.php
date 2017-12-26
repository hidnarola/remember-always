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
    }

    /**
     * Display search result page
     */
    public function index() {
        $data['title'] = 'Affiliation';
        $data['breadcrumb'] = ['title' => 'Find Life Profile', 'links' => [['link' => site_url(), 'title' => 'Home']]];
        $this->template->load('default', 'search/listing', $data);
    }

}
