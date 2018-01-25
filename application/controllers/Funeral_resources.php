<?php

/**
 * Funeral_resources Controller
 * Display all funeral resources
 * @author KU 
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Funeral_resources extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Display funeral resource page
     */
    public function index() {
        $data['title'] = 'Funeral Resources';
        $service_categories = $this->users_model->sql_select(TBL_SERVICE_CATEGORIES, '*', ['where' => ['is_delete' => 0]]);

        $data['service_categories'] = $service_categories;
        $data['breadcrumb'] = ['title' => 'Funeral Resources', 'links' => [['link' => site_url(), 'title' => 'Home']]];
        $this->template->load('default', 'resources/funeral_resources', $data);
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
