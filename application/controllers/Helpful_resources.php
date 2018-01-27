<?php

/**
 * Helpful_resources Controller
 * Display all funeral resources
 * @author KU 
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Helpful_resources extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Display funeral resource page
     */
    public function index() {
        $data['title'] = 'Helpful Resources';
        $service_categories = $this->users_model->sql_select(TBL_SERVICE_CATEGORIES, '*', ['where' => ['is_delete' => 0]]);

        $data['service_categories'] = $service_categories;
        $data['breadcrumb'] = ['title' => 'Helpful Resources', 'links' => [['link' => site_url(), 'title' => 'Home']]];
        $this->template->load('default', 'resources/helpful_resources', $data);
    }

    /**
     * Display funeral resource page
     */
    public function planning() {
        $data['title'] = 'Remember Always | Funeral Planning';
        $data['breadcrumb'] = ['title' => 'Funeral Planning', 'links' => [['link' => site_url(), 'title' => 'Home']]];
        $this->template->load('default', 'resources/funeral_planning', $data);
    }

}
